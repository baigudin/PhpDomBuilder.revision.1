<?php
/** 
 * Тег <ol>
 * 
 * Устанавливает нумерованный список.
 * 
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag; 

class Ol extends \DomBuilder\Tag
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('ol')->tagStyle(self::TAG_STYLE_DOUBLE)->tagType(self::TAG_TYPE_INLINE);                
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
    $html.= self::lf();    
    return $html;
  } 
}