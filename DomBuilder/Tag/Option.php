<?php
/** 
 * Тег <option>
 * 
 * Определяет отдельные пункты списка.
 * 
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag; 

class Option extends \DomBuilder\Tag
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('option')->tagStyle(self::TAG_STYLE_DOUBLE)->tagType(self::TAG_TYPE_INLINE);                
  }
  
  /** 
   * Установка атрибута VALUE
   *
   * @param string $attrValue Значение [optional]
   * @return object Объект класса Tag - текущий узел
   */  
  public function attrValue( $attrValue=NULL )
  {
    return $this->attr('value', $attrValue);
  }  
  
  /** 
   * Установка атрибута SELECTED
   *
   * @param boolean $selected Значение [optional]
   * @return object Объект класса Tag - текущий узел
   */  
  public function selected( $selected=true )
  {
    if( $selected == false ) return $this->removeAttr('selected');
    else return $this->attr('selected', 'selected');
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
   * Получение двойного тега
   *
   * @return string
   */  
  protected function _tagDoubleLine( $text )
  {  
    if(self::$docType == self::DOC_HTML_5 && strlen($text)==0 && strlen($this->attr('label'))==0) $this->attr('label', ' ');
    $html = '';
    $html.= $this->_tagDoubleOpen();
    $html.= $text;        
    $html.= $this->_tagDoubleClose();          
    $html.= self::lf();    
    return $html;
  }   
}