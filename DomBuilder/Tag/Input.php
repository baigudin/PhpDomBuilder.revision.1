<?php
/** 
 * Тег <input>
 * 
 * Элемент формы.
 * 
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag; 

class Input extends \DomBuilder\Tag
{
  /**
   * Ошибка поля ввода
   * @var boolean
   */
  protected $_error;  
  /** 
   * Строка ошибки поля
   * @var string   
   */  
  protected $_errorStr;
  /** 
   * Строка имени поля
   * @var string
   */  
  protected $_nameStr;  
  /** 
   * Значения по умолчанию
   * @var mixed
   */    
  protected $_defValue;  
  /**
   * Счетчик количества узлов
   * @var integer
   */   
  static protected $_countTags = 0;  
  
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->_error = false;
    $this->_errorStr = 'Ошибка';
    $this->_nameStr = '';
    $this->_defValue = false;    
    $this->_tagNum = self::$_countTags++;            
    $this->tagName('input')->tagStyle(self::TAG_STYLE_SINGLE)->attrName(true);    
  }
  
  /** 
   * Установка условия проверки
   * 
   * @param string $reg условие проверки
   * @return object Возвращает объект класса Input
   */   
  public function check()
  {
    return $this->error(false);
  }  

  /** 
   * Получение/установка значения поля ввода
   *
   * Получает значение аттрибута переданного чарез POST/GET метод
   * Устанавливает новое значение аттрибута value
   * Если он уже установлен, то перезаписыват его   
   *
   * @param string $value Значение [optional]   
   * @return string Возвращает значения поля или false
   */
  public function value( $value=NULL )
  {
    if( isset($value) ) return $this->_setRequest( $value );        
    $name = $this->attr('name');
    if( empty($name) || !isset($_REQUEST[$name]) ) return false;
    return trim($_REQUEST[$name]);
  } 

  /** 
   * Установка значения по умолчанию
   *
   * @param string $value
   * @return object Объект класса Tag - текущий узел
   */  
  public function defValue( $value=NULL )
  {
    if( !isset($value) ) return $this->_defValue;
    $this->_defValue = $value;
    return $this->attrValue($value);
  }    
  
  /** 
   * Установка атрибута VALUE
   *
   * @param string $value Значение [optional]
   * @return object Объект класса Tag - текущий узел
   */  
  public function attrValue( $value=NULL )
  {
    return $this->attr('value', $value);
  }
  
  /** 
   * Установка атрибута DISABLED
   *
   * @param boolean $disabled Значение [optional]
   * @return object Объект класса Tag - текущий узел
   */  
  public function disabled( $disabled=true )
  {
    if( $disabled == false ) return $this->removeAttr('disabled');
    else return $this->attr('disabled', 'disabled');
  }
  
  /** 
   * Установка атрибута DISABLED
   *
   * @param boolean $readonly Значение [optional]
   * @return object Объект класса Tag - текущий узел
   */  
  public function readonly( $readonly=true )
  {
    if( $readonly == false ) return $this->removeAttr('readonly');
    else return $this->attr('readonly', 'readonly');
  }   

  /** 
   * Установка/взятие признака ошибки заполнения поля
   * 
   * @param boolen $error Признак ошибки заполнения поля [optional]      
   * @return object Возвращает объект класса Input
   */   
  public function error( $error=NULL )
  {
    if( !isset($error) ) return $this->_error;
    $this->_error = $error;
    return $this;
  }
  
  /** 
   * Установка/взятие строки ошибки заполнения поля
   * 
   * @param string $errorStr Строка ошибки заполнения поля [optional]      
   * @return object Возвращает объект класса Input
   */   
  public function errorStr( $errorStr=NULL )
  {
    if( !isset($errorStr) ) return $this->_errorStr;    
    $this->_errorStr = $errorStr;
    return $this;
  }

  /** 
   * Установка/взятие строки имени поля
   * 
   * @param string $nameStr Строка ошибки заполнения поля [optional]      
   * @return object Возвращает объект класса Input
   */   
  public function nameStr( $nameStr=NULL )
  {
    if( !isset($nameStr) ) return $this->_nameStr;
    $this->_nameStr = $nameStr;
    return $this;
  }   
  
  /** 
   * Установка аттрибута
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
        if($val === true) $val = $name.'input'.$this->_tagNum;
      }
      break;
      case 'value':
      {
        $val = htmlspecialchars($val, ENT_QUOTES);
      }
      break;      
    }
    $this->_attr[$name] = $val;
  }
  
  /** 
   * Установка значения переменной метода $_REQUEST
   *
   * @param string $value Значение
   * @return object Объект класса Tag - текущий узел
   */  
  protected function _setRequest( $value )
  {
    $name = $this->attr('name');
    if( empty($name) ) return $this;
    $_REQUEST[$name] = $value;
    return $this;
  }     

  /** 
   * Язык
   * 
   * @return string
   */  
  protected function _lang($str)
  {
    switch( self::lang() )
    {
      case 'en':
      {
        switch($str)
        {
          case 'Неустановленный тип поля': return 'Unknown feild type';
          case 'Не заполнено': return 'Is empty';     
          case 'Значение не передано': return 'Value is not send';
          case 'Содержит недопустимое количество символов': return 'Exceed the limit of characters';
          case 'Содержит недопустимые символы': return 'Illegal characters';
          case 'Содержит недопустимое значение': return 'Illegal value';
          case 'Размер файла больше допустимого': return 'The file size is bigger than acceptable';
          case 'Размер файла меньше допустимого': return 'The file size is less acceptable';
          case 'Размер принятого файла превысил максимально допустимый размер': return 'The size of the passed file exceeds the maximum size';
          case 'Размер загружаемого файла превысил максимальное значение формы': return 'The size of the uploaded file exceeds the maximum value of the form';
          case 'Загружаемый файл был получен только частично': return 'The download was obtained partly';
          case 'Файл не был загружен': return 'The file was not downloaded';
          case 'Флаг не установлен': return 'Checkbox is not set';
          case 'Переключатель не установлен': return 'Switching is not set';          
        }
      }
      break;
    }
    return $str;
  }
}