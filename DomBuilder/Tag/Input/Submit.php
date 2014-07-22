<?php
/** 
 * Тег <input type="submit">
 * 
 * Элемент формы.
 * 
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag\Input; 

class Submit extends \DomBuilder\Tag\Input
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->attr('type', 'submit');
  } 
}