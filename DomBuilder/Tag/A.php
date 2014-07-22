<?php
/** 
 * Тег <a>
 * 
 * Предназначен для создания ссылок.
 *
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag; 

class A extends \DomBuilder\Tag
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('a')->tagStyle(self::TAG_STYLE_DOUBLE)->tagType(self::TAG_TYPE_INLINE);    
  }
  
  /** 
   * Добавление значения к аттрибуту href
   *
   * @param string $attrValue Значение
   * @return object Объект класса Tag - текущий узел
   */   
  public function href( $attrValue=NULL )
  {
    return $this->attr('href', $attrValue);
  }
}