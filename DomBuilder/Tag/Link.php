<?php
/** 
 * Тег <link>
 * 
 * Устанавливает связь с внешним документом.
 * 
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag; 

class Link extends \DomBuilder\Tag
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('link');                
    switch( self::$docType )
    {
      case self::DOC_XHTML_10: $this->tagStyle(self::TAG_STYLE_DOUBLE)->tagType(self::TAG_TYPE_BLOCK); break;
      case self::DOC_HTML_401:
      case self::DOC_HTML_5: $this->tagStyle(self::TAG_STYLE_SINGLE); break;
    }        
  }
  
  /** 
   * Тип text/css
   * 
   * @param string $href Путь к файлу
   * @return object Возвращает объект класса Dom
   */
  public function typeCss( $href )
  {
    return $this->_attrCss($href);
  }  

  /** 
   * Создание экземпляра класса с типом image/x-icon
   * 
   * @param string $href Путь к файлу
   * @return object Возвращает объект класса Dom
   */
  public function typeIcon( $href )
  {
    return $this->_attrIcon($href);  
  }   
  
  /** 
   * Установка атрибутов для CSS файлов
   *
   * @return void
   */   
  protected function _attrCss($href)
  {
    return $this->attr( array('rel'=>'stylesheet', 'type'=>'text/css', 'href'=>$href, 'media'=>'all') );
  }  
  
  /** 
   * Установка атрибутов для favicon
   *
   * @return void
   */   
  protected function _attrIcon($href)
  {
    return $this->attr( array('rel'=>'shortcut icon', 'type'=>'image/x-icon', 'href'=>$href) );
  }    
}