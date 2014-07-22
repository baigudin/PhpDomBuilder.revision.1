<?php
/** 
 * Тег <source>
 * 
 * Вставляет звуковой или видеофайл для тегов <audio> и <video>.
 *
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag; 

class Source extends \DomBuilder\Tag
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('source')->tagStyle(self::TAG_STYLE_SINGLE);
  } 
}