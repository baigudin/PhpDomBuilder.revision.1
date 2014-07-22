<?php
/** 
 * Тег <col>
 * 
 * Задает ширину и другие характеристики одной или нескольких колонок таблицы.
 *
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag; 

class Col extends \DomBuilder\Tag
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('col')->tagStyle(self::TAG_STYLE_SINGLE);
  } 
}