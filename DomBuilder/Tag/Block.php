<?php
/** 
 * Блок
 *
 * Не содержит HTML разметки. Служит для формирования содержимого 
 * с необходимыми отступами.
 * 
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag; 

class Block extends \DomBuilder\Tag
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('div')->tagStyle(self::TAG_STYLE_DOUBLE)->tagType(self::TAG_TYPE_BLOCK);
  }
  
  /** 
   * Получение двойного тега
   *
   * @return string
   */  
  protected function _tagDoubleBlock( $text )
  {  
    $html = '';
    $html.= $this->_tagDoubleOpen();
    $html.= $text;        
    $html.= $this->_tagDoubleClose();  
    return $html;
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

  /** 
   * Табуляция текста
   *
   * @return string
   */  
  protected function _tabHtml($html)
  { 
    //Замена всех 0D0A на 0А:
    $html = str_replace(self::LT.self::LF, self::LF, $html);
    //Если последний символ не перевод строки:
    if( substr($html, -1 ) != self::LF ) $html.=self::LF;
    //Замена всех LF на LF.TB
    $html = str_replace(self::LF, self::LF.self::TB, $html);
    //Удаление последнего TB
    $html = substr( $html, 0, strlen($html)-strlen(self::TB) );
    return $html;
  } 
  
}