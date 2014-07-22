<?php
/** 
 * Тег <area>
 * 
 * Определяет активные области изображения, которые являются ссылками.
 *
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag; 

class Area extends \DomBuilder\Tag
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('area')->tagStyle(self::TAG_STYLE_SINGLE);
  }
}