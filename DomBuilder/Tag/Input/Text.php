<?php
/** 
 * Тег <input type="text">
 * 
 * Элемент формы.
 * 
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag\Input; 

class Text extends \DomBuilder\Tag\Input
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
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->attr('type', 'text');
    $this->_fill = false;
    $this->_reg = '';
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
   * Получение тега с содержимым HTML узла
   *
   * @return string
   */     
  protected function _tag()
  {
    $value = $this->value();
    if( $value !== false ) $this->attrValue($value);
    return parent::_tag();
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
}