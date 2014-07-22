<?php
/** 
 * Тег <meta>
 *
 * Определяет метатеги.
 * 
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag; 

class Meta extends \DomBuilder\Tag
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('meta');
    switch( self::$docType )
    {
      case self::DOC_XHTML_10: $this->tagStyle(self::TAG_STYLE_DOUBLE)->tagType(self::TAG_TYPE_BLOCK); break;
      case self::DOC_HTML_401:
      case self::DOC_HTML_5: $this->tagStyle(self::TAG_STYLE_SINGLE); break;
    }    
  }
}