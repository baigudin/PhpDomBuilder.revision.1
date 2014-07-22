<?php
/** 
 * Тег <command>
 * 
 * Создает команду в виде переключателя, флажка или обычной кнопки.
 *
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag; 

class Command extends \DomBuilder\Tag
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('command')->tagStyle(self::TAG_STYLE_SINGLE);
  } 
}