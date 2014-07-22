<?php
/** 
 * Тег <i>
 * 
 * Устанавливает курсивное начертание шрифта.
 *
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag; 

class I extends \DomBuilder\Tag
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('i')->tagStyle(self::TAG_STYLE_DOUBLE)->tagType(self::TAG_TYPE_INLINE);    
  } 
}