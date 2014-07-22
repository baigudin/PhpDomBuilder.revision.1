<?php
/** 
 * Тег <img>
 *
 * Предназначен для отображения на веб-странице изображений
 * 
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag; 

class Img extends \DomBuilder\Tag
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('img')->tagStyle(self::TAG_STYLE_SINGLE)->alt('');
  }
  
  /** 
   * Добавление значения к аттрибуту src
   *
   * @param string $attrValue Значение
   * @return object Объект класса Tag - текущий узел
   */   
  public function src( $attrValue=NULL )
  {
    return $this->attr('src', $attrValue);
  }  
  
  /** 
   * Добавление значения к аттрибуту atl
   *
   * @param string $attrValue Значение
   * @return object Объект класса Tag - текущий узел
   */   
  public function alt( $attrValue=NULL )
  {
    return $this->attr('alt', $attrValue);
  }    
}