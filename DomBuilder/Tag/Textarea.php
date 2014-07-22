<?php
/** 
 * Тег <textarea>
 * 
 * Представляет собой элемент формы для создания области, в которую можно 
 * вводить несколько строк текста.
 * 
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag; 

class Textarea extends \DomBuilder\Tag
{
  /**
   * Признака необходимости заполнения поля
   * @var boolean
   */   
  protected $_fill;
  /**
   * Регулярное выражение для проверки
   * @var boolean
   */   
  protected $_reg; 
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
    $this->_defValue = false;
    $this->_fill = false;
    $this->_reg = '';
    $this->_error = false;
    $this->_errorStr = 'Ошибка';
    $this->_nameStr = '';
    $this->_tagNum = self::$_countTags++;                
    $this->tagName('textarea')->tagStyle(self::TAG_STYLE_DOUBLE)->tagType(self::TAG_TYPE_INLINE)->attrName(true)->attr('rows', '3')->attr('cols', '6');    
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
    //Если не совпадает максимальная длина
    if( $this->_checkMaxLength() == false )
      return $this->error(true)->errorStr($this->_lang('Содержит недопустимое количество символов'));    
    //Если не передано браузером: 
    else if( $value === false ) 
      return $this->error(true)->errorStr($this->_lang('Значение не передано'));
    //Если надо было заполнять, а поле не заполнено: 
    else if( ($this->fill()===true) && empty($value) && ($value!=='0') )
      return $this->error(true)->errorStr($this->_lang('Не заполнено'));
    //Если не надо было заполнять и поле не заполненно: 
    else if( ($this->fill()===false) && empty($value) ) 
      return $this->error(false);      
    //Если регулярное выражение не заданно:
    else if( empty($this->_reg) ) 
      return $this->error(false);        
    //Если ошибка регулярного выражения:
    else if( mb_ereg($this->_reg, $value)===false )
      return $this->error(true)->errorStr($this->_lang('Содержит недопустимые символы'));
    else
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
   * Установка/взятие регулярного выражения для проверки
   * 
   * @param string $reg условие проверки
   * @return object Возвращает объект класса Input
   */   
  public function reg( $reg=NULL )
  {
    if( !isset($reg) ) return $this->_reg;
    $this->_reg = $reg;
    return $this;
  }
  
  /** 
   * Установка/взятие признака необходимости заполнения поля
   * 
   * @param boolen $fill Признак необходимости заполнения поля [optional]      
   * @return mixed Возвращает объект класса Input или признак необходимости проверки
   */   
  public function fill( $fill=NULL )
  {
    if( !isset($fill) ) return $this->_fill;
    $this->_fill = $fill;
    return $this; 
  } 
  
  /** 
   * Получение/установка значения атрибута maxlength
   *
   * @param string $value Значение [optional]   
   * @return string Возвращает значения поля или false
   */   
  public function maxlength( $value=NULL )
  {
    return $this->attr('maxlength', $value);
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
   * Установка значения строк и колоник
   *
   * @param mixed $cols      
   * @param mixed $rows
   * @return object Объект класса Tag - текущий узел
   */  
  public function size( $cols='', $rows='' )
  {
    return $this->attr('rows', $rows)->attr('cols', $cols);
  }   
  
  /** 
   * Получение тега с содержимым HTML узла
   *
   * @return string
   */     
  protected function _tag()
  {
    $html = '';
    $value = $this->value();
    if( $value !== false )
    {
      $html = $this->_jsValue($value);
    }
    else if( $this->_defValue !== false )     
    {
      $html = $this->_jsValue($this->_defValue);        
    }
    return $this->_tagDouble().$html;
  }
  
  protected function _jsValue($value)
  {
    if( strlen($value) == 0 ) return '';
    $id = $this->attrId(true)->attr('id');
  //$code = '$(document).ready(function(){$("#'.$id.'").val('.json_encode($value).')});';
    $code = 'document.getElementById("'.$id.'").value='.json_encode($value).';';
    $this->after('script')->javascript()->program($code);
    return self::LF;
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
      if($name == 'maxlength') continue;
      $str.= ( isset($val) ) ? $name.'="'.$val.'" ' : '';
    }
    return mb_substr($str, 0, mb_strlen($str)-1);
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
    if($name === 'type') $this->_setType( $val );
    switch( $name )
    {
      case 'id':
      case 'name':
      {
        if($val === true) $val = $name.'textarea'.$this->_tagNum;
      }
      break;
    }
    $this->_attr[$name] = $val;
  }

  /** 
   * Проверка максимальной длины строки
   * 
   * @return boolean
   */   
  protected function _checkMaxLength()  
  {
    $maxlength = $this->maxlength();
    if( empty($maxlength) ) return true;
    $value = $this->value();
    if( mb_strlen($value) <= $maxlength) return true;
    return false;
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
          case 'Не заполнено': return 'Is empty';     
          case 'Значение не передано': return 'Value is not send';
          case 'Содержит недопустимое количество символов': return 'Exceed the limit of characters';
          case 'Содержит недопустимые символы': return 'Illegal characters';
        }
      }
      break;
    }
    return $str;
  }  
}