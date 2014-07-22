<?php
/** 
 * Тег <tt>
 * 
 * Увеличивает размер шрифта на единицу по сравнению с обычным текстом.
 *
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag; 

class Tt extends \DomBuilder\Tag
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('tt')->tagStyle(self::TAG_STYLE_DOUBLE)->tagType(self::TAG_TYPE_INLINE);    
  } 
}