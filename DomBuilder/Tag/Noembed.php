<?php
/** 
 * Тег <noembed>
 * 
 * Предназначен для отображения информации на веб-странице, если браузер 
 * не поддерживает работу с плагинами.
 * 
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com
 */
namespace DomBuilder\Tag; 

class Noembed extends \DomBuilder\Tag
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('noembed')->tagStyle(self::TAG_STYLE_DOUBLE)->tagType(self::TAG_TYPE_BLOCK);    
  }
}