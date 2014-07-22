<?php
/** 
 * Тег <object>
 * 
 * Сообщает браузеру, как загружать и отображать объекты, 
 * которые исходно браузер не понимает.
 * 
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com
 */
namespace DomBuilder\Tag; 

class Object extends \DomBuilder\Tag
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('object')->tagStyle(self::TAG_STYLE_DOUBLE)->tagType(self::TAG_TYPE_BLOCK);    
  }
}