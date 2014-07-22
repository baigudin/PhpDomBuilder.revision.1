<?php
/** 
 * Тег <input type="password">
 * 
 * Элемент формы.
 * 
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag\Input;

use DomBuilder\Tag as Tag;

class Password extends Text
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->attr('type', 'password');
  }

  /** 
   * Получение тега с содержимым HTML узла
   *
   * @return string
   */     
  protected function _tag()
  {
    return Tag::_tag();
  }
}