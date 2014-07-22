<?php
/** 
 * Cтрока
 *
 * Не содержит HTML разметки. Служит для формирования строки.
 * 
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag; 

class Str extends \DomBuilder\Tag
{
  /** 
   * Конструктор класса
   * 
   * @param mixed $mixed stirng - Имя, array - [Имя] = Значение [optional]
   * @param string $val Значение [optional]
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('str')->tagStyle(self::TAG_STYLE_DOUBLE)->tagType(self::TAG_TYPE_INLINE);
  }
 
  /** 
   * Получение двойного тега
   *
   * @return string
   */  
  protected function _tagDoubleOpen()
  {  
    return '';
  }

  /** 
   * Получение двойного тега
   *
   * @return string
   */  
  protected function _tagDoubleClose()
  {  
    return '';
  }
}