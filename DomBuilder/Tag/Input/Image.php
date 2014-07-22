<?php
/** 
 * Тег <input type="image">
 * 
 * Элемент формы.
 * 
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag\Input; 

class Image extends \DomBuilder\Tag\Input
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->attr('type', 'Image');
  } 
  
  /** 
   * Добавление значения к аттрибуту src
   *
   * @param string $value Значение [optional]
   * @return object Объект класса Tag - текущий узел
   */   
  public function src( $value=NULL )
  {
    return $this->attr('src', $value);
  }  
}