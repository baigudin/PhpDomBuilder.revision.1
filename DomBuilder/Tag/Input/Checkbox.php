<?php
/** 
 * Тег <input type="checkbox">
 * 
 * Элемент формы.
 * 
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag\Input; 

class Checkbox extends \DomBuilder\Tag\Input
{
  /**
   * Признака необходимости заполнения поля
   * @var boolean
   */   
  protected $_fill;
  
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->attr('type', 'checkbox');
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
    $value = $this->value();
    if( $this->fill()===true && $value===false )        
      return $this->checked((bool)$value)->error(true)->errorStr($this->_lang('Флаг не установлен'));
    return $this->checked((bool)$value)->error(false);     
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
   * Получение тега с содержимым HTML узла
   *
   * @return string
   */     
  protected function _tag()
  {
    $value = $this->value();
    if( $value !== false ) $this->checked();
    return parent::_tag();
  }
}