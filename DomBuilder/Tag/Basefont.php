<?php
/** 
 * Тег <basefont>
 * 
 * Предназначен для задания шрифта, размера и цвета текста по умолчанию.
 *
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag; 

class Basefont extends \DomBuilder\Tag
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('basefont')->tagStyle(self::TAG_STYLE_SINGLE);
  } 
}