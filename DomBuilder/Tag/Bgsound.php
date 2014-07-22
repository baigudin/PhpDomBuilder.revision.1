<?php
/** 
 * Тег <bgsound>
 * 
 * Определяет музыкальный файл, который будет проигрываться на веб-странице при ее открытии.
 *
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag; 

class Bgsound extends \DomBuilder\Tag
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('bgsound')->tagStyle(self::TAG_STYLE_SINGLE);
  } 
}