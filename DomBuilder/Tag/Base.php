<?php
/** 
 * Тег <base>
 * 
 * Инструктирует браузер относительно полного базового адреса текущего документа.
 *
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag; 

class Base extends \DomBuilder\Tag
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('base')->tagStyle(self::TAG_STYLE_SINGLE);
  } 
}