<?php
/** 
 * Тег <select>
 * 
 * Позволяет создать элемент интерфейса в виде раскрывающегося списка.
 * 
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag; 

class Select extends \DomBuilder\Tag
{
  /**
   * Массив вложенных тегов option
   * @var array
   */  
  protected $_option;
  /**
   * Признака необходимости заполнения поля
   * @var boolean
   */   
  protected $_fill;
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
   * Номер HTML тега
   * @var integer
   */     
  protected $_tagNum;  
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
    $this->_option = array();
    $this->_fill = false;    
    $this->_error = false;
    $this->_errorStr = 'Ошибка';
    $this->_nameStr = '';    
    $this->_defValue = false;
    $this->_tagNum = self::$_countTags++;        
    $this->tagName('select')->tagStyle(self::TAG_STYLE_DOUBLE)->tagType(self::TAG_TYPE_BLOCK)->attrName(true);
  } 

  /** 
   * Установка массива вложенных тегов option
   *
   * @param array $option
   * @return boolean
   */   
  public function setOption($option)
  {
    if( !is_array($option) ) return $this;
    $this->_option = $option;
    foreach($this->_option as $k=>$v) $this->insert('option')->attrValue($k)->html($v);
    return $this;
  }
  
  /** 
   * Установка условия проверки
   * 
   * @param string $reg условие проверки
   * @return object Возвращает объект класса Input
   */   
  public function check()
  {
    $value = $this->value();  
    //Если не передано браузером: 
    if( $value === false ) 
      return $this->error(true)->errorStr($this->_lang('Значение не передано'));
    //Если надо было заполнять, а поле не заполнено: 
    else if( ($this->fill()===true) && empty($value) && ($value!=='0') )
      return $this->error(true)->errorStr($this->_lang('Не заполнено'));
    //Если не надо было заполнять и поле не заполненно: 
    else if( ($this->fill()===false) && empty($value) ) 
      return $this->error(false);      
    //Если ошибка регулярного выражения:
    else if( $this->_checkOption($value) === false )
      return $this->error(true)->errorStr($this->_lang('Содержит недопустимое значение'));
    else
      return $this->error(false);
  }
  
  /** 
   * Получение значения поля ввода через POST/GET метод
   *
   * @return string Возвращает значения поля или false
   */   
  public function value()
  {
    $name = $this->attr('name');
    if( empty($name) || !isset($_REQUEST[$name]) ) return false;
    return trim($_REQUEST[$name]);
  }

  /** 
   * Установка значения по умолчанию
   *
   * @param string $value Ключ массива переданного функции 
   * @return object Объект класса Tag - текущий узел
   */  
  public function defValue( $value=NULL )
  {
    if( !isset($value) ) return $this->_defValue;
    $this->_defValue = $value;
    return $this;
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
   * Установка/взятие признака необходимости заполнения поля
   * 
   * @param boolen $fill Признак необходимости заполнения поля [optional]      
   * @return object Возвращает объект класса Input
   */   
  public function fill( $fill=NULL )
  {
    if( !isset($fill) ) return $this->_fill;
    $this->_fill = $fill;
    return $this; 
  } 

  /** 
   * Проверка значения поля ввода
   *
   * @return string
   */     
  protected function _checkOption($value)
  {
    $option = $this->find('option[value='.$value.']');
    if( $option->length() == 0 ) return false;
    return true;  
  }

  /** 
   * Установка значения поля ввода
   *
   * @return string
   */     
  protected function _setOption($value)
  {
    $option = $this->find('option[value='.$value.']');
    if( $option->length() != 0 ) $option->first()->selected(true);  
  }   
  
  /** 
   * Получение тега с содержимым HTML узла
   *
   * @return string
   */     
  protected function _tag()
  {
    $value = $this->value();
    if( $value !== false ) 
      $this->_setOption($value);
    else if( $this->_defValue !== false ) 
      $this->_setOption($this->_defValue);    
    return parent::_tag();
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
        if($val === true) $val = $name.'select'.$this->_tagNum;
      }
      break;
    }
    $this->_attr[$name] = $val;
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
          case 'Не заполнено': return 'Is empty';     
          case 'Значение не передано': return 'Value is not send';
          case 'Содержит недопустимое значение': return 'Illegal value';
        }
      }
      break;
    }
    return $str;
  }  
}