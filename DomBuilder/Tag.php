<?php
/** 
 * Построение объектной модели веб документа (DOM).
 * 
 * @author Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014 Sergey Baigudin
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com
 */
namespace DomBuilder;

class Tag 
{
  /**
   * Имя класса
   */    
  const NAME_SPACE = 'DomBuilder\Tag';
  /**
   * Перевод строки
   */
  const LF = "\n";
  /**
   * Возврат корретки
   */
  const LT = "\r";
  /**
   * Размер табуляции
   */  
  const TB = "  ";
  /**
   * Тип документа XHTML 1.0
   */    
  const DOC_XHTML_10 = "XHTML 1.0";  
  /**
   * Тип документа HTML 4.01
   */      
  const DOC_HTML_401 = "HTML 4.01";    
  /**
   * Тип документа HTML 5
   */
  const DOC_HTML_5 = "HTML 5";      
  /**
   * Строка ошибоки
   */     
  const STR_PRINT_ERROR = '<br /><b><span style="color: #bf2424">PHP Dom Builder</span> error:</b> %s<br />';  
  /**
   * Возращать узел в поиске
   */       
  const RET_NODE = TagList::RET_NODE;
  /**
   * Возращать список в поиске
   */    
  const RET_LIST = TagList::RET_LIST;
  /**
   * Стили тега - одиночный
   */    
  const TAG_STYLE_SINGLE = 1;
  /**
   * Стили тега - двойной
   */     
  const TAG_STYLE_DOUBLE = 2;
  /**
   * Тип тега - блочный
   */     
  const TAG_TYPE_BLOCK = 1;    
  /**
   * Тип тега - строчный
   */    
  const TAG_TYPE_INLINE = 2;
  
  /**
   * Признак печати ошибок
   * @var boolean
   */   
  static public $printError = true;
  /**
   * Признак сжатия документа
   * @var boolean
   */
  static public $docCompress = true;
  /**
   * Тип документа
   * @var string
   */  
  static public $docType = self::DOC_XHTML_10;  
  /**
   * Язык
   * @var string
   */
  static protected $_lang = 'ru';  
  /**
   * Количество дочерних узлов
   * @var integer
   */
  protected $_length;  
  /**
   * Порядковый номер узла в списке дочерних узлов
   * @var integer
   */
  protected $_number;  
  /**
   * Строка HTML тегов или текста
   * @var string
   */  
  protected $_html;
  /**
   * Массив атрибутов HTML тега
   * @var string
   */   
  protected $_attr;
  /**
   * Идентификатор HTML тега
   * @var integer
   */     
  protected $_tagId;
  /**
   * Имя HTML тега
   * @var string
   */     
  protected $_tagName;  
  /**
   * Стили тега при выводе
   * @var integer
   */     
  protected $_tagStyle;  
  /**
   * Тип тега
   * @var integer
   */     
  protected $_tagType;   
  /**
   * Предыдущий узел
   * @var object Объект класса Tag
   */
  protected $_prev;
  /**
   * Следующий узел
   * @var object Объект класса Tag
   */  
  protected $_next;
  /**
   * Первый дочерний узел
   * @var object Объект класса Tag
   */  
  protected $_child;
  /**
   * Последний дочерний узел
   * @var object Объект класса Tag
   */  
  protected $_last;
  /**
   * Родительский узел
   * @var object Объект класса Tag
   */  
  protected $_parent;  
  /**
   * Любые данные
   * @var mixed
   */  
  protected $_data;   
  /**
   * Ассоциациативный строковый ключ для списка узлов
   * @var string
   */  
  protected $_key;
  /**
   * Счетчик количества узлов
   * @var integer
   */   
  static protected $_countId = 0;
  
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    $this->_length = 0;
    $this->_number = 0;
    $this->_prev = NULL;
    $this->_next = NULL;
    $this->_child = NULL;
    $this->_last = NULL;    
    $this->_parent = NULL;
    $this->_data = NULL;
    $this->_key = '';
    $this->_html = '';
    $this->_attr = array();    
    $this->_tagId = self::$_countId++;    
    $this->_tagName = '';
    $this->_tagStyle = self::TAG_STYLE_DOUBLE;
    $this->_tagType = self::TAG_TYPE_INLINE;
  } 
  
  /** 
   * Деструктор класса
   * 
   * @return void
   */
  function __destruct()
  {
  }   
  
  /** 
   * Копирование класса
   * 
   * @return void
   */
  function __clone()
  {
    $child = $this->_child;
    $this->_length = 0;
    $this->_number = 0;    
    $this->_prev = NULL;
    $this->_next = NULL;
    $this->_child = NULL;
    $this->_last = NULL;    
    $this->_parent = NULL;    
    $this->_tagId = self::$_countId++;        
    while( $child != NULL )
    {
      $node = clone $child;
      $this->_insert($node);
      $child = $child->_next;
    }
  }   
  
  /** 
   * Добавление дочернего узла в начало
   * 
   * @param mixed  $node Object Tag - узел, Object TagList - список узлов, string - имя тега узла
   * @param string $ns   Новый namespace [optional]      
   * @return object Объект класса Tag
   */
  public function insertFirst( $node, $ns=NULL )
  {
    if($this->length() == 0) return $this->insert($node, $ns);
    else return $this->child()->before($node, $ns);
  }
  
  /** 
   * Добавление дочернего узла
   * 
   * @param mixed  $node Object Tag - узел, Object TagList - список узлов, string - имя тега узла
   * @param string $ns   Новый namespace [optional]   
   * @return object Объект класса Tag
   */
  public function insert( $node, $ns=NULL )
  {
    if( is_string($node) ) return $this->_insert( self::create($node, $ns) );
    if( Tag::isSelf($node) ) return $this->_insert( $node );
    if( TagList::isSelf($node) ) 
    {
      $list = $node->node();
      foreach($list as $n) $this->_insert( $n );    
      return $this;
    }
    self::_printError('Wrong argument type of insert() function');
    return $this;
  }

  /** 
   * Добавление дочернего узла
   * 
   * @param object $node Объект класса Tag - узел
   * @return object Объект класса Tag - вставленный узел
   */  
  protected function _insert( $node )   
  {
    if( $node->_isLink() ) $node = clone $node;  
    $node->_prev = NULL;
    $node->_next = NULL;
    if($this->_child == NULL)
    {
      $this->_child = $node;
      $this->_last = $node;      
    }
    else
    {   
      $this->_last->_next = $node;
      $node->_prev = $this->_last;      
      $this->_last = $node;          
    }
    $node->_parent = $this;
    $node->_number = $this->_length;
    $this->_length++;
    return $node;  
  }
  
  /** 
   * Вставка узла после
   * 
   * @param mixed $node Object Tag - узел, Object TagList - список узлов, string - имя тега узла
   * @param string $ns  Новый namespace [optional]      
   * @return object Объект класса Tag - последний вставленный узел
   */
  public function after( $node, $ns=NULL )
  {
    if( is_string($node) ) return $this->_after( self::create($node, $ns) );  
    if( Tag::isSelf($node) ) return $this->_after( $node );
    if( TagList::isSelf($node) ) 
    {
      $last = $this;
      $list = $node->node();
      foreach($list as $n) 
        $last = $last->_after( $n );    
      return $last;
    }
    self::_printError('Wrong argument type of after() function');
    return false;
  }

  /** 
   * Вставка узла после
   * 
   * @param object $node Объект класса Tag - дочерний узел
   * @return object Объект класса Tag - вставленный узел
   */  
  protected function _after( $node )
  {
    if( $node->_isLink() ) $node = clone $node;
    $node->_prev = NULL;
    $node->_next = NULL;  
    $node->_parent = $this->_parent;
    $node->_next = $this->_next;
    $node->_prev = $this;
    $this->_next = $node;
    if($node->_next != NULL) $node->_next->_prev = $node;
    else $node->_parent->_last = $node;
    //Ренумерация порядкового номера:    
    $number = $this->_number;
    $next = $this->_next;
    while($next != NULL)
    {
      $next->_number = ++$number;      
      $next = $next->_next;
    }     
    $this->_parent->_length++;
    return $node;  
  }
 
  /** 
   * Вставка узла до
   * 
   * @param mixed  $node Object Tag - узел, Object TagList - список узлов, string - имя тега узла
   * @param string $ns   Новый namespace [optional]   
   * @return object Объект класса Tag - последний вставленный узел
   */
  public function before( $node, $ns=NULL )
  {
    if( is_string($node) ) return $this->_before( self::create($node, $ns) );    
    if( Tag::isSelf($node) ) return $this->_before( $node );
    if( TagList::isSelf($node) ) 
    {
      $last = $this;
      $list = $node->node();
      foreach($list as $n) 
        $last = $last->_before( $n );    
      return $last;
    }
    self::_printError('Wrong argument type of before() function');
    return false;
  }

  /** 
   * Вставка узла до
   * 
   * @param object $node Объект класса Tag - дочерний узел
   * @return object Объект класса Tag - вставленный узел
   */  
  protected function _before( $node )  
  {
    if( $node->_isLink() ) $node = clone $node;
    $node->_parent = $this->_parent;
    $node->_next = $this;
    $node->_prev = $this->_prev;
    $this->_prev = $node;
    if($node->_prev != NULL) $node->_prev->_next = $node;
    else $node->_parent->_child = $node;
    //Ренумерация порядкового номера:    
    $number = $this->_number;
    $next = $this->_prev;
    while($next != NULL)
    {
      $next->_number = $number++;      
      $next = $next->_next;
    }     
    $this->_parent->_length++;
    return $node;  
  }
  
  /** 
   * Создание корневого узла
   * 
   * @param string $name Имя дочернего класса. Если '' - будет использованно имя класса "Tag" [optional]
   * @return object Объект класса Tag - новый узел
   */
  static public function create( $name='', $ns=NULL )
  {
    if( isset($ns) )
    {
      $ns = str_replace('/', '\\', $ns);;
      return $ns::create($name);
    }
    $class = self::NAME_SPACE;
    if( !empty($name) ) $class.= '\\'.str_replace('/', '\\', $name);
    return new $class();  
  }  
  
  /** 
   * Удаление дочернего/собственного узла
   * 
   * @param object $node Объект класса Tag - дочерний узел. Если нет аргумента удаление собственного узла
   * @return object Удаленный узел или false
   */  
  public function remove( $node=NULL )
  {
    $remove = NULL;
    //Удаление дочернего узла:
    if( Tag::isSelf($node) )
    {
      //Поиск узела:    
      $remove = $this->_child;
      while($remove != NULL)
      {
        if($remove === $node) break;
        $remove = $remove->_next;
      }
      if($remove == NULL) 
      {
        self::_printError('Wrong argument type of remove() function: argument of node is not found in childs list'); 
        return false;
      }    
    }
    else $remove = $this;
    return $remove->_remove();
  }

  /** 
   * Удаление узла
   * 
   * @return object Удаленный узел или false
   */  
  protected function _remove()
  {
    //Ренумерация порядкового номера:    
    $next = $this->_next;
    while( $next != NULL )
    {
      $next->_number--;
      $next = $next->_next;
    }
    //Узел один:
    if($this->_prev == NULL && $this->_next == NULL)
    {
      if( $this->_parent != NULL )
      {
        $this->_parent->_child = NULL;
        $this->_parent->_last = NULL;    
      }
    }
    //Узел первый:
    else if($this->_prev == NULL)
    {
      if( $this->_parent != NULL )
        $this->_parent->_child = $this->_next;
      $this->_next->_prev = NULL;        
    }
    //Узел последний:        
    else if($this->_next == NULL)
    {
      if( $this->_parent != NULL )
        $this->_parent->_last = $this->_prev;    
      $this->_prev->_next = NULL;
    }
    //Узел промежуточный:
    else
    {
      $this->_prev->_next = $this->_next;
      $this->_next->_prev = $this->_prev;
    }
    //Отвязка от родителя:
    if( $this->_parent != NULL )
    {
      $this->_parent->_length--;
      $this->_parent = NULL;
    } 
    //Отвязка от следующего соседа:
    if( $this->_next != NULL ) 
    {
      $this->_next = NULL;
    }     
    //Отвязка от предыдущего соседа:
    if( $this->_prev != NULL ) 
    {
      $this->_prev = NULL;
    }     
    return $this;
  } 
  
  /** 
   * Взатие корневого узла
   * 
   * @return object Объект класса Tag - корневой узел
   */
  public function getRoot()
  {
    if($this->_parent == NULL) return $this;
    return $this->parent()->getRoot();
  }   
  
  /**
   * Взять количество дочерних узлов
   *
   * @return integer
   */
  public function length()
  {
    return $this->_length;  
  }  

  /**
   * Взять порядковый номер узла в списке дочерних узлов
   *
   * @return integer
   */
  public function number()
  {
    return $this->_number;  
  }   

  /**
   * Получение/установка имени HTML тега
   *
   * @param string $tagName Имя HTML тега  
   * @return object Объект класса Tag
   */
  public function tagName( $tagName=NULL )
  {
    if( !isset($tagName) ) return $this->_tagName;
    $this->_tagName = $tagName;  
    return $this;
  }
  
  /**
   * Получение/установка стили тега при выводе
   *
   * @param integer $tagStyle Стиль тега
   * @return object Объект класса Tag
   */     
  public function tagStyle( $tagStyle=NULL )
  {
    if( !isset($tagStyle) ) return $this->_tagStyle;
    $this->_tagStyle = $tagStyle;  
    return $this;
  }   

  /**
   * Получение/установка типа тега
   *
   * @param integer $tagStyle Тип тега  
   * @return object Объект класса Tag
   */     
  public function tagType( $tagType=NULL )
  {
    if( !isset($tagType) ) return $this->_tagType;
    $this->_tagType = $tagType;  
    return $this;
  }     

  /**
   * Взять предыдущий узел
   *
   * @return object Объект класса Tag - предыдущий узел 
   */
  public function prev()
  {
    return $this->_prev;  
  }
  
  /**
   * Взять следующий узел
   *
   * @return object Объект класса Tag - следующий узел    
   */  
  public function next() 
  {
    return $this->_next;
  }
  
  /**
   * Взять дочерний узел
   *
   * @param integer $number Порядковый номер узла в списке дочерних узлов
   * @return object Объект класса Tag - дочерний узел        
   */  
  public function child( $number=0 )
  {
    if( $number >= $this->_length ) self::_printError('Wrong argument $number of child() function');  
    $node = $this->_child;
    while($number != 0)
    {
      if( $node == NULL ) break;
      $node = $node->_next;
      $number--;
    }
    return $node;    
  }
  
  /**
   * Взять последний дочерний узел
   *
   * @return object Объект класса Tag - дочерний узел   
   */  
  public function last()
  {
    return $this->_last;
  }
  
  /**
   * Взять родительский узел
   *
   * @return object Объект класса Tag - родительский узел     
   */  
  public function parent()
  {
    return $this->_parent;
  } 

  /**
   * Получение/установка любых данных
   *
   * @param mixed $data
   * @return object Объект класса Tag
   */     
  public function data( $data=NULL )
  {
    if( !isset($data) ) return $this->_data;
    $this->_data = $data;  
    return $this;
  }

  /**
   * Получение/установка ассоциациативного строкового ключа для списка узлов
   *
   * @param string $key
   * @return object Объект класса Tag
   */     
  public function key( $key=NULL )
  {
    if( !isset($key) ) return $this->_key;
    $this->_key = $key;  
    return $this;
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
    return TagList::create()->push($this)->parents($query, $return);
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
    return TagList::create()->push($this)->find($query, $return);
  }
  
  /**
   * Получение дочернего узла по ID
   *
   * @param string $id Значение ID
   * @return object Объект класса Tag или false;
   */  
  public function getElementById( $id )
  {
    $list = $this->getElementsById($id);
    if($list->length() != 1) return false;
    return $list->first();
  }  

  /**
   * Получение дочерних узлов по ID
   *
   * @param string $id Значение ID
   * @return object Объект класса TagList
   */  
  public function getElementsById( $id )
  {
    $list = TagList::create();
    $node = $this->_child;
    while($node != NULL)
    {
      if( $node->_child != NULL ) $list->push( $node->getElementsById($id) );
      $idAttr = $node->attr('id');
      if( !empty($idAttr) && ($idAttr==$id) ) $list->push( $node );
      $node = $node->_next;
    }
    return $list;
  } 
  
  /**
   * Получение родительских узлов по ID
   *
   * @param string $id Значение ID
   * @return object Объект класса TagList
   */  
  public function getParentsById( $id )
  {
    $list = TagList::create();
    $node = $this->_parent;
    while($node != NULL)
    {
      $idAttr = $node->attr('id');
      if( !empty($idAttr) && ($idAttr==$id) ) $list->push( $node );
      $node = $node->_parent;
    }
    return $list;
  }   
  
  /**
   * Получение списка узлов по имени тега
   *
   * @param string $name Имя тега
   * @return object Объект класса TagList
   */  
  public function getElementsByTagName( $name )
  {
    $list = TagList::create();
    $node = $this->_child;
    while($node != NULL)
    {
      if( $node->_child != NULL ) $list->push( $node->getElementsByTagName($name) );    
      if( $node->_tagName == $name ) $list->push( $node );
      $node = $node->_next;
    }
    return $list;
  }
  
  /**
   * Получение списка родительских узлов по имени тега
   *
   * @param string $name Имя тега
   * @return object Объект класса TagList
   */  
  public function getParentsByTagName( $name )
  {
    $list = TagList::create();
    $node = $this->_parent;
    while($node != NULL)
    {
      if( $node->_tagName == $name ) $list->push( $node );
      $node = $node->_parent;
    }
    return $list;
  }  
  
  /**
   * Получение списка узлов по имени класса
   *
   * @param string $class Имя класса
   * @return object Объект класса TagList
   */  
  public function getElementsByClassName( $class )
  {
    $list = TagList::create();
    $node = $this->_child;
    while($node != NULL)
    {
      if( $node->_child != NULL ) $list->push( $node->getElementsByClassName($class) );    
      if( $node->hasClass($class) == true ) $list->push( $node );      
      $node = $node->_next;
    }
    return $list;
  } 
  
  /**
   * Получение списка родительских узлов по имени класса
   *
   * @param string $class Имя класса
   * @return object Объект класса TagList
   */  
  public function getParentsByClassName( $class )
  {
    $list = TagList::create();
    $node = $this->_parent;
    while($node != NULL)
    {
      if( $node->hasClass($class) == true ) $list->push( $node );            
      $node = $node->_parent;
    }
    return $list;
  } 

  /**
   * Получение списка узлов по имени аттрибута и его значению
   *
   * @param string $attrName  Имя аттрибута
   * @param string $value Значение аттрибута   
   * @return object Объект класса TagList
   */  
  public function getElementsByAttr( $attrName, $value=NULL )
  {
    $list = TagList::create();
    $node = $this->_child;
    while($node != NULL)
    {
      if( $node->_child != NULL ) $list->push( $node->getElementsByAttr($attrName, $value) );    
      foreach($node->_attr as $key=>$val)
      {
        if( !isset($value) && ($key==$attrName) )
        {
          $list->push( $node );      
          break;
        }
        else if( ($key==$attrName)&&($val==$value) ) 
        {
          $list->push( $node );      
          break;
        }
      }
      $node = $node->_next;
    }
    return $list;
  }

  /**
   * Получение списка родительских узлов по имени аттрибута и его значению
   *
   * @param string $attrName  Имя аттрибута
   * @param string $value Значение аттрибута   
   * @return object Объект класса TagList
   */  
  public function getParentsByAttr( $attrName, $value=NULL )
  {
    $list = TagList::create();
    $node = $this->_parent;
    while($node != NULL)
    {
      foreach($node->_attr as $key=>$val)
      {
        if( !isset($value) && ($key==$attrName) )
        {
          $list->push( $node );      
          break;
        }
        else if( ($key==$attrName)&&($val==$value) ) 
        {
          $list->push( $node );      
          break;
        }
      }
      $node = $node->_parent;
    }
    return $list;    
  }   

  /**
   * Проверка узла на ID
   *
   * @param string $id Значение ID
   * @return boolean
   */  
  public function checkElementOnId( $id )
  {
    $idAttr = $this->attr('id');
    if( $idAttr === $id ) return true;
    else return false;
  }  
  
  /**
   * Проверка узла на имя тега
   *
   * @param string $name Имя тега
   * @return boolean
   */  
  public function checkElementOnTagName( $name )
  {
    if( $this->_tagName === $name ) return true;
    else return false;
  }
  
  /**
   * Проверка узла на имя класса
   *
   * @param string $class Имя класса
   * @return boolean
   */  
  public function checkElementOnClassName( $class )
  {
    return $this->hasClass( $class );
  }   
  /**
   * Получение списка узлов по имени аттрибута и его значению
   *
   * @param string $attrName  Имя аттрибута
   * @param string $value Значение аттрибута   
   * @return object Объект класса TagList
   */  
  public function checkElementOnAttr( $attrName, $value=NULL )
  {
    foreach($this->_attr as $key=>$val)
    {
      if( !isset($value) && ($key==$attrName) )
        return true;      
      else if( ($key==$attrName)&&($val==$value) ) 
        return true;
    }
    return false;
  }  
  

  /** 
   * Получение/установка HTML узла
   * 
   * @param string $html Устанавливаемая строка. Если NULL то возвращает html содержимое узла
   * @return mixed object - объект класса Tag - текущий узел. string - html содержимое узла
   */
  public function html( $html=NULL )  
  {
    if( !isset($html) ) return $this->_html();
    $this->_html = $html;
    return $this;
  } 
  
  /** 
   * Получение HTML документа
   * 
   * @return string строка HTML документа
   */
  public function getDocument()  
  {
    $html = self::_getDocTypeTag();
    $html.= $this->_html();
    return $html;
  }
  
  /** 
   * Добавление класса элементу
   *
   * Устанавливает новый аттрибут
   * Если он уже установлен, то перезаписыват его
   *
   * @param string $className Имя класса [optional]
   * @return object Объект класса Tag - текущий узел
   */  
  public function addClass( $className )
  {
    $class = $this->attr('class');
    if( empty($class) ) return $this->attr('class', $className);
    $class = mb_split('[ ]{1,}', trim(mb_ereg_replace('[ ]{1,}', ' ', $class)));
    foreach($class as $cs) if($cs == $className) return $this;
    return $this->addAttr('class', $className);
  }  
  
  /** 
   * Удаление класса элемента
   *
   * @param string $className Имя класса [optional]
   * @return object Объект класса Tag - текущий узел
   */  
  public function removeClass( $className=NULL )
  {
    if( !isset($className) ) return $this->removeAttr('class');
    $class = $this->attr('class');
    if( empty($class) ) return $this;
    $class = mb_split('[ ]{1,}', trim(mb_ereg_replace('[ ]{1,}', ' ', $class)));
    foreach($class as $k=>$cs) if($cs == $className) unset($class[$k]);
    $this->removeAttr('class');
    foreach($class as $cs) $this->addAttr('class', $cs);
    return $this;
  } 

  /** 
   * Проверка на причастность к определённому классу
   *
   * @param string $className Имя класса
   * @return boolean
   */  
  public function hasClass( $className )
  {
    $class = $this->attr('class');
    if( empty($class) ) return false;
    $class = mb_split('[ ]{1,}', trim(mb_ereg_replace('[ ]{1,}', ' ', $class)));
    foreach($class as $cs) if($cs == $className) return true;
    return false;
  }  
  
  /** 
   * Установка атрибута ID
   *
   * @param string $attrValue Значение [optional]
   * @return object Объект класса Tag - текущий узел
   */  
  public function attrId( $attrValue=NULL )
  {
    return $this->attr('id', $attrValue);
  }
  
  /** 
   * Установка атрибута NAME
   *
   * @param string $attrValue Значение [optional]
   * @return object Объект класса Tag - текущий узел
   */  
  public function attrName( $attrValue=NULL )
  {
    return $this->attr('name', $attrValue);
  } 

  /** 
   * Установка атрибута TITLE
   *
   * @param string $attrValue Значение [optional]
   * @return object Объект класса Tag - текущий узел
   */  
  public function attrTitle( $attrValue=NULL )
  {
    return $this->attr('title', $attrValue);
  }   
  
  /** 
   * Установка атрибута STYLE
   *
   * @param string $attrValue Значение [optional]
   * @return object Объект класса Tag - текущий узел
   */  
  public function attrStyle( $attrValue=NULL )
  {
    return $this->attr('style', $attrValue);
  }   
  
  /** 
   * Установка/получение атрибута
   *
   * Устанавливает новый аттрибут
   * Если он уже установлен, то перезаписыват его
   *
   * @param mixed  $attrName  Stirng - Имя, array - [Имя] = Значение
   * @param string $attrValue Значение [optional]
   * @return object Объект класса Tag - текущий узел
   */  
  public function attr( $attrName, $attrValue=NULL )
  {
    if( is_array($attrName) )
      foreach($attrName as $name => $attrValue) 
        $this->_attr( $name, $attrValue );
    else if( is_string($attrName) )
    {
      if( $attrValue === NULL ) return $this->_getAttr($attrName);
      $this->_attr( $attrName, $attrValue );
    }
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
   * @return object Объект класса Tag - текущий узел
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
   * @param mixed $attrName stirng - Имя, array - [номер] = Имя
   * @return object Объект класса Tag - текущий узел
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
   * Добавление значения к аттрибуту
   *
   * @param string $name
   * @param string $val
   * @return void
   */   
  protected function _addAttr( $name, $val )  
  {
    if( !isset($this->_attr[$name]) ) return $this->_attr( $name, $val );
    switch( $name )
    {
      case 'id':
      case 'name': 
      {
        self::_printError('Can not added attribute to «'.$name.'» property');
      }
      break;
      default: 
      {
        if( empty($val) ) break;
        $this->_attr[$name] .= ' '.$val;
      }
    }  
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
    switch( $name )
    {
      case 'id':
      case 'name':
      {
        if($val === true) $val = $name.$this->_tagId;
      }
      break;
    }
    $this->_attr[$name] = $val; 
  }  

  /** 
   * Удаление атрибута
   *
   * @param string $name
   * @return void
   */    
  protected function _removeAttr( $name )  
  {
    if( isset($this->_attr[$name]) ) unset($this->_attr[$name]);
  }
  
  /** 
   * Получение значения атрибута
   *
   * @return string
   */   
  protected function _getAttr($attrName)  
  {
    if( !isset($this->_attr[$attrName]) ) return '';
    return $this->_attr[$attrName];
  }

  /** 
   * Получение HTML узла
   * 
   * @return string
   */
  protected function _html()  
  {
    if( $this->_child == NULL ) return $this->_html;
    $html = '';
    $node = $this->_child;
    while($node != NULL)
    {
      $html.= $node->_tag();
      $node = $node->_next;
    }
    return $html;
  }   
  
  /** 
   * Получение тега с содержимым HTML узла
   *
   * @return string
   */     
  protected function _tag()
  {
    switch( $this->_tagStyle )
    {
      case self::TAG_STYLE_SINGLE: return $this->_tagSingle();
      case self::TAG_STYLE_DOUBLE: return $this->_tagDouble();
    } 
    return '';
  } 
  
  /** 
   * Получение одиночного тега
   *
   * @return string Возвращает HTML тег
   */
  protected function _tagSingle()
  {
    if(empty($this->_tagName)) return '';
    $html = '';
    switch( self::$docType )
    {
      case self::DOC_XHTML_10: $html.= '<'.$this->_tagName.$this->_getAttrStr().' />'; break;
      case self::DOC_HTML_401:
      case self::DOC_HTML_5: $html.= '<'.$this->_tagName.$this->_getAttrStr().'>'; break;
      default: return '';      
    }
    if( $this->_parent->_tagType == self::TAG_TYPE_BLOCK ) $html.= self::lf();
    return $html;  
  }  

  /** 
   * Получение двойного тега
   *
   * @return string Возвращает HTML тег
   */  
  protected function _tagDouble()
  {
    switch( self::$docType )
    {
      case self::DOC_XHTML_10: 
      case self::DOC_HTML_401:
      case self::DOC_HTML_5: break;
      default: return '';
    }
    switch( $this->_tagType )
    {  
      case self::TAG_TYPE_BLOCK: return $this->_tagDoubleBlock( $this->_tagDoubleHtml() );
      case self::TAG_TYPE_INLINE: return $this->_tagDoubleLine( $this->_tagDoubleHtml() );
      default: return '';      
    }
  }
  
  /** 
   * Получение двойного тега
   *
   * @return string
   */  
  protected function _tagDoubleBlock( $text )
  {  
    $html = '';
    $html.= $this->_tagDoubleOpen();
    if( !empty($text) ) $html.= self::lf();
    $html.= $text;        
    $html.= $this->_tagDoubleClose();  
    $html.= self::lf();
    return $html;
  }
  
  /** 
   * Получение двойного тега
   *
   * @return string
   */  
  protected function _tagDoubleLine( $text )
  {  
    $html = '';
    $html.= $this->_tagDoubleOpen();
    $html.= $text;        
    $html.= $this->_tagDoubleClose();          
    return $html;
  }   
  
  /** 
   * Получение двойного тега
   *
   * @return string
   */  
  protected function _tagDoubleOpen()
  {  
    return (empty($this->_tagName)) ? '' : '<'.$this->_tagName.$this->_getAttrStr().'>';
  }

  /** 
   * Получение двойного тега
   *
   * @return string
   */  
  protected function _tagDoubleClose()
  {  
    return (empty($this->_tagName)) ? '' : '</'.$this->_tagName.'>';
  }

  /** 
   * Получение двойного тега
   *
   * @return string
   */  
  protected function _tagDoubleHtml()
  { 
    $html = $this->_html();
    if( strlen($html) == 0 ) return '';  
    if( self::$docCompress == true ) return $html;
    if( $this->_tagType == self::TAG_TYPE_INLINE ) return $html;
    return $this->_tabHtml($html);
  } 
  
  /** 
   * Табуляция текста
   *
   * @return string
   */  
  protected function _tabHtml($html)
  { 
    //Замена всех 0D0A на 0А:
    $html = str_replace(self::LT.self::LF, self::LF, $html);
    //Если последний символ не перевод строки:
    if( substr($html, -1 ) != self::LF ) $html.=self::LF;
    //Замена всех LF на LF.TB
    $html = self::TB . str_replace(self::LF, self::LF.self::TB, $html);
    //Удаление последнего TB
    $html = substr( $html, 0, strlen($html)-strlen(self::TB) );
    return $html;
  }  

  /** 
   * Получение HTML тега типа документа
   * 
   * @return string
   */  
  static protected function _getDocTypeTag()
  {
    switch( self::$docType )
    {
      case self::DOC_XHTML_10: return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'.self::LF;
      case self::DOC_HTML_401: return '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">'.self::LF;      
      case self::DOC_HTML_5:   return '<!DOCTYPE HTML>'.self::LF;
    }  
  }  

  /** 
   * Получение строки всех аттрибутов
   *
   * @return string
   */   
  protected function _getAttrStr()
  {
    if( empty($this->_attr) ) return '';
    $str = ' ';
    foreach($this->_attr as $name => $val)
    {
      $str.= ( isset($val) ) ? $name.'="'.$val.'" ' : '';
    }
    return mb_substr($str, 0, mb_strlen($str)-1);
  }    
  
  /** 
   * Проверка привязки узла к дереву
   *
   * @return boolean
   */   
  protected function _isLink()
  {
    if($this->_parent != NULL) return true;
    if($this->_next != NULL) return true;
    if($this->_prev != NULL) return true;    
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

  /** 
   * Перевод строки
   *
   * Возвращает символ перевода строки если документ не компрессируется 
   *
   * @return string
   */   
  static public function lf()  
  {
    if( self::$docCompress == true ) return '';
    return self::LF;
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
   * Язык
   * 
   * @return string
   */
  static public function lang( $lang=NULL )  
  {
    if( isset($lang) ) self::$_lang = $lang;   
    return self::$_lang;
  }
}