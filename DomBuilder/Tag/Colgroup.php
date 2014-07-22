<?php
/** 
 * Тег <colgroup>
 * 
 * Предназначен для задания ширины и стиля одной или нескольких колонок таблицы.
 *
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag; 

class Colgroup extends \DomBuilder\Tag
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('colgroup')->tagStyle(self::TAG_STYLE_SINGLE);
  } 
}