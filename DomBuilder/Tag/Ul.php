<?php
/** 
 * Тег <ul>
 * 
 * Устанавливает маркированный список.
 * 
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag; 

class Ul extends \DomBuilder\Tag
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('ul')->tagStyle(self::TAG_STYLE_DOUBLE)->tagType(self::TAG_TYPE_BLOCK);
  }

  /** 
   * Получение двойного тега
   *
   * @return string
   */  
  protected function _tagDoubleBlock( $text )
  {  
    if( self::$docCompress == true ) $inLi = false;
    else $inLi = ($this->parents('li', self::RET_LIST)->length() == 0) ? false : true;
    $html = '';
    if($inLi) $html.= self::lf();
    $html.= $this->_tagDoubleOpen();
    if( !empty($text) ) $html.= self::lf();
    $html.= $text;        
    $html.= $this->_tagDoubleClose();  
    $html.= self::lf();
    if($inLi == false) return $html;
    return $this->_tabHtml($html);
  }  
}