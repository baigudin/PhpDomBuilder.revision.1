<?php
/** 
 * Тег <title>
 * 
 * Определяет заголовок документа.
 * 
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag; 

class Title extends \DomBuilder\Tag
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('title')->tagStyle(self::TAG_STYLE_DOUBLE)->tagType(self::TAG_TYPE_BLOCK);    
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
  protected function _tagDoubleHtml()
  { 
    return $this->_html();
  }  
}