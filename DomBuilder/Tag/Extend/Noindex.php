<?php
/** 
 * Не индексировать содержимое
 * 
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag\Extend;

class Noindex extends \DomBuilder\Tag
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('noindex')->tagStyle(self::TAG_STYLE_DOUBLE)->tagType(self::TAG_TYPE_BLOCK);
  }
  
  /** 
   * Получение двойного тега
   *
   * @return string
   */  
  protected function _tagDoubleOpen()
  {  
    return '<!--'.$this->_tagName.'-->';
  }

  /** 
   * Получение двойного тега
   *
   * @return string
   */  
  protected function _tagDoubleClose()
  {  
    return '<!--/'.$this->_tagName.'-->';
  }  
}