<?php
/** 
 * Тег <span>
 * 
 * Предназначен для определения строчных элементов документа.
 * 
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */

namespace DomBuilder\Tag; 

class Span extends \DomBuilder\Tag
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('span')->tagStyle(self::TAG_STYLE_DOUBLE)->tagType(self::TAG_TYPE_INLINE);    
  }
}