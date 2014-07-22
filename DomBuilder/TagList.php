<?php
/** 
 * Список узлов объектной модели веб документа (DOM).
 * 
 * @author Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder; 
 
class TagList
{
  /**
   * Константы для поиска
   */  
  const FIND_VOID = 0x0;
  const FIND_ID = 0x1;
  const FIND_CLASS = 0x2;
  const FIND_TAG = 0x3;
  const FIND_ATTR = 0x4;       
  const FIND_FILTER_ID = 0x10;
  const FIND_FILTER_CLASS = 0x20;
  const FIND_FILTER_TAG = 0x30;     
  const FIND_FILTER_ATTR = 0x40; 
  /**
   * Константы для поиска атрибута
   */  
  const FIND_ATTR_SELF = 0x1;
  const FIND_ATTR_EQ = 0x2;
  /**
   * Строка ошибоки
   */     
  const STR_PRINT_ERROR = '<br /><b><span style="color: #bf2424">PHP Dom Builder</span> error:</b> %s<br />';  
  /**
   * Возращать узел в поиске
   */       
  const RET_NODE = true;
  /**
   * Возращать список в поиске
   */    
  const RET_LIST = false;   

  /**
   * Признак печати ошибок
   * @var boolean
   */   
  static public $printError = true;      
  /**
   * Количество узлов
   * @var integer
   */
  protected $_length;  
  /**
   * Список узлов
   * @var array
   */   
  protected $_node;
  /**
   * Ассоциация числового и строкового ключа списка узлов
   * @var array
   */   
  protected $_assoc;  

  /** 
   * Конструктор класса
   * 
   */
  function __construct()
  {
    $this->_length = 0;
    $this->_node = array();
    $this->_assoc = array();    
  }
  
  /** 
   * Создание нового списка
   * 
   * @return object Объект класса TagList - новый узел
   */
  static public function create()
  {
    return new self();
  }    

  /** 
   * Добавить узел 
   *
   * @param object $arg Объект класса Tag или TagList
   * @return object Объект класса Tag или TagList
   */
  public function push( $arg )
  {
    if( Tag::isSelf($arg) ) $this->_push($arg);
    else if( TagList::isSelf($arg) )
    {
      $nodes = $arg->node();
      foreach($nodes as $node) $this->_push($node);
    }
    return $this;
  }
  
  /** 
   * Добавить узел 
   *
   * @param object $arg Объект класса Tag
   * @return void   
   */
  protected function _push( $node )
  {
    $this->_node[$this->_length++] = $node;
    $this->key($node->key());
  } 
  
  /** 
   * Установка строкового ключа последниму добавленному узлу 
   *
   * @param string $key Строковый ключ     
   * @return object Объект класса TagList
   */
  public function key( $key )
  {
    if( empty($key) ) return $this;    
    if( $this->_length == 0 )
    {
      self::_printError('Length is zero. Can\'t added key.');
      return $this;
    }
    $num = $this->_length - 1;
    $this->_assoc[$key] = $num;
    //Сохраненние ключа в структуре данных узла:
    $this->node($num)->key($key);
    return $this;
  }   

  /** 
   * Взять количество узлов
   *
   * @return integer
   */
  public function length()
  {
    return $this->_length;
  } 
  
  /** 
   * Взять первый узел
   *
   * @return mixed Tag - если есть узлы в списке; False - ошибка
   */
  public function first()
  {
    return $this->node( 0 );
  }  
  
  /** 
   * Взять последний узел
   *
   * @return mixed Tag - если есть узлы в списке; False - ошибка
   */
  public function last()
  {
    return $this->node( -1 );
  }    
  
  /** 
   * Взять узел или массив узлов
   *
   * Функция возвращает массив узлов, если аргумент не передан.
   * Если аргумент больше либо равен нулю, то возвращается узел с соответствующим порядковым номером.
   * Если аргумент меньше нуля, то нумерация начинается с конца массива. 
   * Т.е. [-1] вернёт последний узел, [-2] - предпоследний и т.д.
   *
   * @param integer $arg Порядковый номер узла в списке узлов или его строковый ключ [optional]  
   * @return mixed Array - если аргумент не передан. 
   *               Tag - если аргумент корректен. 
   *               False - ошибка.
   */
  public function node( $arg=NULL )
  {
    if( !isset($arg) ) return $this->_node;
    if( $this->length() == 0 )
    {
      self::_printError('Wrong argument type of node() function: list length is zero');      
      return false;    
    }
    if( is_numeric($arg) )
    {
      $n = ( $arg >= 0 ) ? $arg : $this->length()+$arg;
      if( !isset($this->_node[$n]) ) return false;
      return $this->_node[$n];
    }
    if( is_string($arg) )
    {
      if( !isset($this->_assoc[$arg]) ) return false;       
      if( !isset($this->_node[$this->_assoc[$arg]]) ) return false;      
      return $this->_node[$this->_assoc[$arg]];
    }    
    self::_printError('Wrong argument type of node() function');      
    return false;    
    
  }  

  /** 
   * Взатие корневого узла
   * 
   * @param integer $number Порядковый номер узла в списке узлов [optional]     
   * @return mixed Объект класса Tag - корневой узел;
   *               False - ошибка.
   */
  public function getRoot( $number=0 )
  {
    if( $this->length() == 0 ) return false;
    return $this->node($number)->getRoot();
  }    

  /** 
   * Добавление дочернего узла
   * 
   * @param mixed $node Object Tag - узел, Object TagList - список узлов, string - имя тега узла
   * @return object Объект класса TagList - список добавленных узлов
   */
  public function insert( $node )
  {
    $list = self::create();  
    foreach($this->_node as $n)
      $list->push( $n->insert($node) );
    return $list;  
  } 
  
  /** 
   * Вставка узла после
   * 
   * @param mixed $node Object Tag - узел, Object TagList - список узлов, string - имя тега узла
   * @return object Объект класса TagList
   */
  public function after( $node )
  {
    $list = self::create();    
    foreach($this->_node as $n)
      $list->push( $n->after($node) );
    return $list;
  } 
  
  /** 
   * Вставка узла до
   * 
   * @param mixed  $node  Object Tag - узел, Object TagList - список узлов, string - имя тега узла
   * @param mixed  $mixed Stirng - Имя, array - [Имя] = Значение [optional]
   * @param string $val   Значение [optional]
   * @return object Объект класса TagList
   */
  public function before( $node )
  {
    $list = self::create();    
    foreach($this->_node as $n)
      $list->push( $n->before($node) );
    return $list;
  }  
  
  /** 
   * Удаление узлов списка
   * 
   * @return boolean true - успешно, false - ошибка.
   */  
  public function remove()
  {
    $error = true;
    foreach($this->_node as $node)
      $error &= (bool)$node->remove();
    return $error;
  }  
  
  /** 
   * Установка HTML узлов
   * 
   * @param string $html Устанавливаемая строка.
   * @return object Объект класса TagList
   */
  public function html( $html )  
  {
    foreach($this->_node as $node)
      $node->html( $html );
    return $this;
  }
  
  /**
   * Удаление узлов из списка
   *
   * Функция удаляет узлы из собственного списока согласно запросу.
   * Дочернии элементы строки запроса не обрабатываются.
   *
   * @param string  $query  Строка запроса
   * @param boolean $return Если true - то при обнаружении одного узла вернет объект Dom [optional]
   * @return object Объект класса Tag если найден один узел. 
   *                Объект класса TagList если найдено несколько узлов. 
   */  
  public function not( $query, $return=self::RET_LIST )
  {
    $list = self::create();
    if( Tag::isSelf($query) ) 
      $list->push( $this->_not( self::create()->push($query) ) );
    else if( TagList::isSelf($query) )
      $list->push( $this->_not($query) );
    else
      $list->push( $this->_not( $this->filter($query) ) );
    return $list->_returnNodeOrList($return);
  }

  /**
   * Удаление узлов из списка
   *
   * Функция удаляет узлы из собственного списока согласно запросу.
   *
   * @param object $node Объект класса TagList
   * @return object Объект класса TagList
   */  
  public function _not( $nodes )
  {
    $list = self::create();      
    //Перебераем собственные узлы:
    foreach($this->_node as $self )
    {
      //Перебераем переданные узлы:
      foreach( $nodes->_node as $node )
        if($node === $self) continue 2;
      $list->push( $self );
    }
    return $list;
  }
  
  /**
   * Фильтр списка узлов
   *
   * Функция фильтрует собственный список согласно строке запроса.
   * Дочернии элементы строки запроса не обрабатываются.
   *
   * @param string  $query  Строка запроса
   * @param boolean $return Если true - то при обнаружении одного узла вернет объект Dom [optional]
   * @return object Объект класса Tag если найден один узел. 
   *                Объект класса TagList если найдено несколько узлов. 
   */  
  public function filter( $query, $return=self::RET_LIST )
  {
    $list = self::create();  
    //Подготовка запроса:
    $query = trim( mb_ereg_replace('[ ]{1,}', ' ', strtolower($query) ) );    
    //Выбираем все запросы:
    $queryArray = mb_split('[ ]{0,1},[ ]{0,1}', $query);    
    //Удаляем дочернии элементы строки запроса:
    $i = 0;
    foreach($queryArray as $query) 
    {
      $arr = mb_split('[ ]{1,}', $query);
      $queryArray[$i++] = $arr[0];
    }
    
    foreach($queryArray as $query) 
      $list->push( $this->_filter($query) );
    return $list->_returnNodeOrList($return);
  }

  /**
   * Фильтр списка узлов
   *
   * @param string $query 
   * @return object Объект класса TagList
   */  
  protected function _filter( $query )
  {
    $match = '';
    $nextQuery = '';

    $whatFind = self::_findWhat($query, $match, $nextQuery);
    //self::_findWhatDump( $whatFind, $query, $match, $nextQuery );

    $list = $this->_filterNew( $whatFind, $match );        
    
    if( !empty($nextQuery) ) return $list->_filter($nextQuery);    
    return $list;
  } 

  /**
   * Фильтр списка новых узлов
   *
   * @param string $whatFind
   * @param string $match   
   * @return object Объект класса TagList   
   */  
  protected function _filterNew( $whatFind, $match )
  {
    $list = self::create();
    switch( $whatFind )
    {
      //Фильтр по имени идентифекатора:    
      case self::FIND_FILTER_ID:
      //Фильтр по имени класса:
      case self::FIND_FILTER_CLASS:      
      //Фильтр по имени тега:          
      case self::FIND_FILTER_TAG: 
      //Фильтр по аттрибуту:          
      case self::FIND_FILTER_ATTR: return $this->_findNew( $whatFind, $match ); 
    }
    return $list;
  }    
  
  /**
   * Поиск родительских узлов
   *
   * @param string  $query  Строка запроса
   * @param boolean $return Если true - то при обнаружении одного узла вернет объект Dom [optional]
   * @return object Объект класса Tag если найден один узел. 
   *                Объект класса TagList если найдено несколько узлов. 
   */  
  public function parents( $query, $return=self::RET_LIST )
  {
    $list = self::create();  
    //Подготовка запроса:
    $query = trim( mb_ereg_replace('[ ]{1,}', ' ', strtolower($query) ) );    
    //Выбираем все запросы:
    $queryArray = mb_split('[ ]{0,1},[ ]{0,1}', $query);    
    foreach($queryArray as $query) 
      $list->push( $this->_parents(' '.$query) );
    return $list->_returnNodeOrList($return);
  }
  
  /**
   * Поиск родительских узлов
   *
   * @param string $query 
   * @return object Объект класса TagList
   */  
  protected function _parents( $query )
  {
    $match = '';
    $nextQuery = '';
    
    $whatFind = self::_findWhat($query, $match, $nextQuery);
    //self::_findWhatDump( $whatFind, $query, $match, $nextQuery );

    $list = $this->_parentsNew( $whatFind, $match );        
    if( !empty($nextQuery) ) return $list->_parents($nextQuery);    
    return $list;
  }  

  /**
   * Поиск родительских узлов
   *
   * Функция находит новые узлы относительно своего списка.
   * Найденые узлы добавляет в новый список и возвращает его.
   *
   * @param string $whatFind
   * @param string $match   
   * @return object Объект класса TagList   
   */  
  protected function _parentsNew( $whatFind, $match )
  {
    $list = self::create();
    switch( $whatFind )
    {
      //Поиск по имени идентифекатора:    
      case self::FIND_ID:
      {
        $id = substr($match, 1);
        foreach($this->_node as $node)
          $list->push( $node->getParentsById($id) );
      }
      break;
      //Поиск по имени класса:
      case self::FIND_CLASS:
      {
        $className = substr($match, 1);
        foreach($this->_node as $node)
          $list->push( $node->getParentsByClassName($className) );
      }
      break;
      //Поиск по имени тега:          
      case self::FIND_TAG:
      {
        $tagName = $match;      
        foreach($this->_node as $node)
          $list->push( $node->getParentsByTagName($tagName) );
      }
      break;
      //Поиск по аттрибуту:          
      case self::FIND_ATTR:
      {
        $attrName = NULL; 
        $attrValue = NULL;
        self::_attrFindWhat($match, $attrName, $attrValue);
        foreach($this->_node as $node)
          $list->push( $node->getParentsByAttr($attrName, $attrValue) );  
      }
      break;        
      //Фильтр по имени идентифекатора:    
      case self::FIND_FILTER_ID:
      //Фильтр по имени класса:
      case self::FIND_FILTER_CLASS:      
      //Фильтр по имени тега:          
      case self::FIND_FILTER_TAG: 
      //Фильтр по аттрибуту:          
      case self::FIND_FILTER_ATTR: return $this->_findNew( $whatFind, $match ); 
    }
    return $list;
  }

  /**
   * Поиск узлов
   *
   * @param string  $query  Строка запроса
   * @param boolean $return Если true - то при обнаружении одного узла вернет объект Dom [optional]
   * @return object Объект класса Tag если найден один узел. 
   *                Объект класса TagList если найдено несколько узлов. 
   */  
  public function find( $query, $return=self::RET_LIST )
  {
    $list = self::create();  
    //Подготовка запроса:
    $query = trim( mb_ereg_replace('[ ]{1,}', ' ', strtolower($query) ) );    
    //Выбираем все запросы:
    $queryArray = mb_split('[ ]{0,1},[ ]{0,1}', $query);    
    foreach($queryArray as $query) 
      $list->push( $this->_find(' '.$query) );
    return $list->_returnNodeOrList($return);
  }

  /**
   * Поиск узлов
   *
   * @param string $query 
   * @return object Объект класса TagList
   */  
  protected function _find( $query )
  {
    $match = '';
    $nextQuery = '';

    $whatFind = self::_findWhat($query, $match, $nextQuery);
    //self::_findWhatDump( $whatFind, $query, $match, $nextQuery );

    $list = $this->_findNew( $whatFind, $match );        
    if( !empty($nextQuery) ) return $list->_find($nextQuery);    
    return $list;
  }  

  /**
   * Поиск новых узлов
   *
   * Функция находит новые узлы относительно своего списка.
   * Найденые узлы добавляет в новый список и возвращает его.
   *
   * @param string $whatFind
   * @param string $match   
   * @return object Объект класса TagList   
   */  
  protected function _findNew( $whatFind, $match )
  {
    $list = self::create();
    switch( $whatFind )
    {
      //Поиск по имени идентифекатора:    
      case self::FIND_ID:
      {
        $id = substr($match, 1);
        foreach($this->_node as $node)
          $list->push( $node->getElementsById($id) );
      }
      break;
      //Поиск по имени класса:
      case self::FIND_CLASS:
      {
        $className = substr($match, 1);
        foreach($this->_node as $node)
          $list->push( $node->getElementsByClassName($className) );
      }
      break;
      //Поиск по имени тега:          
      case self::FIND_TAG:
      {
        $tagName = $match;      
        foreach($this->_node as $node)
          $list->push( $node->getElementsByTagName($tagName) );
      }
      break;
      //Поиск по аттрибуту:          
      case self::FIND_ATTR:
      {
        $attrName = NULL; 
        $attrValue = NULL;
        self::_attrFindWhat($match, $attrName, $attrValue);
        foreach($this->_node as $node)
          $list->push( $node->getElementsByAttr($attrName, $attrValue) );  
      }
      break;         
      //Фильтр по имени идентифекатора:    
      case self::FIND_FILTER_ID:
      {
        $id = substr($match, 1);
        foreach($this->_node as $node)
          if( $node->checkElementOnId($id) == true )
            $list->push( $node );
      }
      break;
      //Фильтр по имени класса:
      case self::FIND_FILTER_CLASS:
      {
        $className = substr($match, 1);
        foreach($this->_node as $node)
          if( $node->checkElementOnClassName($className) == true )
            $list->push( $node );
      }
      break;
      //Фильтр по имени тега:          
      case self::FIND_FILTER_TAG:
      {
        $tagName = $match;      
        foreach($this->_node as $node)
          if( $node->checkElementOnTagName($tagName) == true )
            $list->push( $node );
      }
      break;      
      //Фильтр по аттрибуту:          
      case self::FIND_FILTER_ATTR:
      {
        $attrName = NULL; 
        $attrValue = NULL;
        self::_attrFindWhat($match, $attrName, $attrValue);
        foreach($this->_node as $node)
          if( $node->checkElementOnAttr($attrName, $attrValue) == true )        
            $list->push( $node ); 
      }
      break;        
    }
    return $list;
  }

  /**
   * Определение что необходимо искать
   *
   * @return integer
   */  
  static protected function _findWhat( &$query, &$match, &$nextQuery )
  {
    if( empty($query) ) return self::FIND_VOID;  
    $matchArray = array();
    $reg = array(
      self::FIND_ID =>    '^%s#{1}[a-z0-9\_\-]{1,}',
      self::FIND_CLASS => '^%s\.{1}[a-z0-9\_\-]{1,}',
      self::FIND_TAG =>   '^%s[a-z]{1}[a-z1-6]{0,}',
      self::FIND_ATTR =>  '^%s\[{1}[a-z0-9\_\-]{1,}[=]{0,1}[a-z0-9\_\-.:/ ]{1,}\]{1}'
    );
    $findStr = '[ ]{1}';
    $filterStr = '';
    $find = self::FIND_VOID;
    //Поиск:    
    if(mb_ereg(sprintf($reg[self::FIND_ID], $findStr), $query, $matchArray) !== false )
      $find = self::FIND_ID;
    else if(mb_ereg(sprintf($reg[self::FIND_CLASS], $findStr), $query, $matchArray) !== false )
      $find = self::FIND_CLASS;
    else if(mb_ereg(sprintf($reg[self::FIND_TAG], $findStr), $query, $matchArray) !== false )
      $find = self::FIND_TAG;
    else if(mb_ereg(sprintf($reg[self::FIND_ATTR], $findStr), $query, $matchArray) !== false )
      $find = self::FIND_ATTR;       
    //Фильтрация:      
    else if(mb_ereg(sprintf($reg[self::FIND_ID], $filterStr), $query, $matchArray) !== false )
      $find = self::FIND_FILTER_ID;
    else if(mb_ereg(sprintf($reg[self::FIND_CLASS], $filterStr), $query, $matchArray) !== false )
      $find = self::FIND_FILTER_CLASS;
    else if(mb_ereg(sprintf($reg[self::FIND_TAG], $filterStr), $query, $matchArray) !== false )
      $find = self::FIND_FILTER_TAG;
    else if(mb_ereg(sprintf($reg[self::FIND_ATTR], $filterStr), $query, $matchArray) !== false )
      $find = self::FIND_FILTER_ATTR;      
    else
      return $find;
    $explArray = explode($matchArray[0], $query, 2);
    $nextQuery = $explArray[1];
    $match = trim($matchArray[0]);      
    return $find;
  }

  /**
   * Определение что необходимо искать
   *
   * @return integer   
   */  
  static protected function _attrFindWhat( $query, &$attrName, &$attrValue )
  {
    if( empty($query) ) return self::FIND_VOID;  
    $query = mb_substr($query, 1, strlen($query)-2);      
    $matchArray = array();
    $reg = array(
      self::FIND_ATTR_SELF => '^[a-z0-9\_\-]{1,}+$',
      self::FIND_ATTR_EQ =>   '^[a-z0-9\_\-]{1,}[=]{1}[a-z0-9\_\-\.:/ ]{1,}+'
    );
    $find = self::FIND_VOID;
    //Поиск:    
    if(mb_ereg($reg[self::FIND_ATTR_SELF], $query, $matchArray) !== false )
      $find = self::FIND_ATTR_SELF;
    else if(mb_ereg($reg[self::FIND_ATTR_EQ], $query, $matchArray) !== false )
      $find = self::FIND_ATTR_EQ;
    else
      return $find;
    switch($find)
    {
      case self::FIND_ATTR_SELF: 
      {
        $attrName = $matchArray[0];
      }
      break;
      case self::FIND_ATTR_EQ: 
      {
        $split = mb_split('[=]{1}', $matchArray[0]);    
        $attrName = $split[0];
        $attrValue = $split[1];
      }
      break;
    }
    return $find;
  }  
  
  /**
   * Вывод результата поиска узлов
   *
   */   
  static private function _findWhatDump( $whatFind, $query, $match, $nextQuery )
  {
    static $iter = 0;  
    switch($whatFind)
    {
      case self::FIND_VOID:         $whatFindStr = ' VOID';         break;
      case self::FIND_ID:           $whatFindStr = ' ID';           break;
      case self::FIND_CLASS:        $whatFindStr = ' CLASS';        break;
      case self::FIND_TAG:          $whatFindStr = ' TAG';          break;
      case self::FIND_ATTR:         $whatFindStr = ' ATTR';         break;      
      case self::FIND_FILTER_ID:    $whatFindStr = ' FILTER ID';    break;
      case self::FIND_FILTER_CLASS: $whatFindStr = ' FILTER CLASS'; break;
      case self::FIND_FILTER_TAG:   $whatFindStr = ' FILTER TAG';   break;
      case self::FIND_FILTER_ATTR:  $whatFindStr = ' FILTER ATTR';  break;      
      default:                      $whatFindStr = ' UNDEFINED';    break;      
    }
    echo '<b>ITER:</b>'.($iter++).'<br />';
    echo '<b>WHATFIND:</b>'.$whatFindStr.'<br />';    
    echo '<b>QUERY:</b>'.$query.'<br />';    
    echo '<b>MATCH:</b>'.$match.'<br />';
    echo '<b>NEXTQUERY:</b>'.$nextQuery.'<br />';    
    echo '<br />';        
  }

  /**
   * Получение узла или списка
   *
   * @param boolean
   * @return object Объект класса Tag если найден один узел. 
   *                Объект класса TagList если найдено несколько узлов. 
   */  
  protected function _returnNodeOrList($return)
  {
    if( $return == self::RET_LIST) return $this;
    if( $this->length() == 1 )
      return $this->node(0);
    else 
      return $this;
  }

  /** 
   * Добавление класса
   *
   * @param string $className Имя класса
   * @return object Объект класса Tag - текущий узел
   */  
  public function addClass( $className )
  {
    foreach($this->_node as $node) $node->addClass($className);
    return $this;
  }   
  
  /** 
   * Удаление класса
   *
   * @param string $className Имя класса
   * @return object Объект класса Tag - текущий узел
   */  
  public function removeClass( $className )
  {
    foreach($this->_node as $node) $node->removeClass($className);
    return $this;
  } 
  
  /** 
   * Установка атрибута
   *
   * Устанавливает новый аттрибут
   * Если он уже установлен, то перезаписыват его
   *
   * @param mixed  $attrName Stirng - Имя, array - [Имя] = Значение
   * @param string $attrValue Значение [optional]
   * @return object Объект класса TagList
   */  
  public function attr( $attrName, $attrValue=NULL )
  {
    if( is_array($attrName) )
      foreach($attrName as $name => $attrValue) 
        $this->_attr( $name, $attrValue );
    else if( is_string($attrName) )
      $this->_attr( $attrName, $attrValue );
    return $this;
  }
  /** 
   * Добавление значения к аттрибуту
   *
   * Добавляет новый аттрибут к уже существующему
   * Если он не существует, то устанавливает его
   *
   * @param mixed  $attrName  Stirng - Имя, array - [Имя] = Значение
   * @param string $attrValue Значение
   * @return object Объект класса TagList
   */   
  public function addAttr( $attrName, $attrValue=NULL )
  {
    if( is_array($attrName) )
      foreach($attrName as $name => $attrValue) 
        $this->_addAttr( $name, $attrValue );
    else if( is_string($attrName) )
      $this->_addAttr( $attrName, $attrValue );
    return $this;
  }
  
  /** 
   * Удаление атрибута
   *
   * Удаляет установленный аттрибут
   *
   * @param mixed $attrName Stirng - Имя, array - [номер] = Имя
   * @return object Объект класса TagList
   */  
  public function removeAttr( $attrName )
  {
    if( is_array($attrName) )
      foreach($attrName as $n) 
        $this->_removeAttr( $n );
    else if( is_string($attrName) )
      $this->_removeAttr( $attrName );
    return $this;
  }   

  /** 
   * Установка атрибута
   *
   * @param string $name
   * @param string $val
   * @return void
   */    
  protected function _attr( $name, $val )  
  {
    foreach($this->_node as $node)
      $node->attr( $name, $val );
    return $this;
  } 
  
  /** 
   * Добавление значения к аттрибуту
   *
   * @param string $name
   * @param string $val
   * @return void
   */   
  protected function _addAttr( $name, $val )  
  {
    foreach($this->_node as $node)
      $node->addAttr( $name, $val );
    return $this;
  }
  
  /** 
   * Удаление атрибута
   *
   * @param string $name
   * @return void
   */    
  protected function _removeAttr( $name )  
  {
    foreach($this->_node as $node)
      $node->removeAttr( $name );
    return $this;
  }

  /**
   * Проверка корректности типа узла
   * 
   * @param object $node Объект класса Tag
   * @return boolean
   */  
  static public function isSelf($node)
  {
    if( is_a($node, get_class()) ) return true;
    return false;
  }  
  
  /**
   * Вывод ошибки
   * 
   * @param string $str Строка ошибки  
   * @return void
   */  
  static protected function _printError($str)
  {
    if( self::$printError ) echo sprintf( self::STR_PRINT_ERROR, '\''.get_called_class().'\' class error - '.$str);    
  }  
}