<?php
/** 
 * Тег <html>
 * 
 * Является контейнером, который заключает в себе все содержимое веб-страницы.
 * 
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag; 

class Html extends \DomBuilder\Tag
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('html')->tagStyle(self::TAG_STYLE_DOUBLE)->tagType(self::TAG_TYPE_BLOCK);
    switch(self::$docType)
    {
      case self::DOC_XHTML_10: $this->attr( array('xmlns'=>'http://www.w3.org/1999/xhtml', 'xml:lang'=>'ru', 'lang'=>'ru') );  break;
      case self::DOC_HTML_401: break;
      case self::DOC_HTML_5: break;
    }        
  }
}