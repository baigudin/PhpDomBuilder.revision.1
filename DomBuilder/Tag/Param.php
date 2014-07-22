<?php
/** 
 * Тег <param>
 * 
 * Предназначен для передачи значений параметров Java-апплетам или 
 * объектам веб-страницы, созданным с помощью тегов <applet> или <object>.
 *
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag; 

class Param extends \DomBuilder\Tag
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('param')->tagStyle(self::TAG_STYLE_SINGLE);
  } 
}