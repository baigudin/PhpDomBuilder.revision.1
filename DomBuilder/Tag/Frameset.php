<?php
/** 
 * Тег <frameset>
 * 
 * Определяет структуру фреймов на веб-странице.
 * 
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com
 */
namespace DomBuilder\Tag; 

class Frameset extends \DomBuilder\Tag
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('frameset')->tagStyle(self::TAG_STYLE_DOUBLE)->tagType(self::TAG_TYPE_BLOCK);    
  }
}