<?php
/** 
 * Тег <input type="radio">
 * 
 * Элемент формы.
 * 
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag\Input; 

class Radio extends \DomBuilder\Tag\Input
{
  /**
   * Признака необходимости заполнения поля
   * @var boolean
   */   
  protected $_fill;
  /**
   * Признака необходимости заполнения поля
   * @var boolean
   */   
  static protected $_attrName = array();  
  
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->attr('type', 'radio');
    $this->_fill = false;
  } 
  
  /** 
   * Установка условия проверки
   * 
   * @param string $reg условие проверки
   * @return object Возвращает объект класса Input
   */   
  public function check()
  {
    $name = $this->attrName();
    $value = $this->value();
    if( $this->fill()===true && $value===false )        
      return $this->checked((bool)$value)->error(true)->errorStr($this->_lang('Переключатель не установлен'));
    else if( !isset(self::$_attrName[$name][$value]) )
      return $this->checked((bool)$value)->error(true)->errorStr('Содержит недопустимое значение');
    return $this->checked((bool)$value)->error(false);     
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
   * Установка атрибута CHECKED
   *
   * @param boolean $checked Значение [optional]
   * @return object Объект класса Tag - текущий узел
   */  
  public function checked( $checked=true )
  {
    if( $checked == false ) return $this->removeAttr('checked');
    else return $this->attr('checked', 'checked');
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
    {
      if($this->_defValue == $value) $this->checked(true);
      else $this->checked(false);    
    }
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
        if($val === true) $val = $name.'input'.$this->_tagNum;
      }
      break;
    }
    $this->_attr[$name] = $val;
    $this->_attrName();
  }  
  
  /** 
   * Установка массива attaName
   *
   * @return void
   */    
  protected function _attrName()
  {
    if( !isset($this->_attr['name']) || !isset($this->_attr['value']) ) return;
    self::$_attrName[$this->_attr['name']][$this->_attr['value']] = true;
  }
}