<?php
/** 
 * Тег <wbr>
 * 
 * Указывает браузеру место, где допускается делать перенос строки в тексте.
 *
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag; 

class Wbr extends \DomBuilder\Tag
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('wbr')->tagStyle(self::TAG_STYLE_SINGLE);
  } 
}