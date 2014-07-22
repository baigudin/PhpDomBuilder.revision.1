<?php
/** 
 * Комментарий.
 *
 * Добавляет комментарий в код документа.
 * 
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag; 

class Comment extends \DomBuilder\Tag
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('comment')->tagStyle(self::TAG_STYLE_DOUBLE)->tagType(self::TAG_TYPE_BLOCK);    
  }
  
  /** 
   * Получение двойного тега
   *
   * @return string
   */  
  protected function _tagDoubleOpen()
  {  
    return '<!--';
  }

  /** 
   * Получение двойного тега
   *
   * @return string
   */  
  protected function _tagDoubleClose()
  {  
    return '-->';
  }  
}