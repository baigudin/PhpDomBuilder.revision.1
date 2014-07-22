<?php
/** 
 * Тег <script>
 * 
 * Предназначен для описания скриптов.
 * 
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag;

class Script extends \DomBuilder\Tag
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('script')->tagStyle(self::TAG_STYLE_DOUBLE)->tagType(self::TAG_TYPE_BLOCK);                
  }
  
  /** 
   * Тип с подключенным внешним JavaScript файлом
   * 
   * @param string $src Путь к файлу
   * @return object Возвращает объект класса Dom_Input
   */
  public function typeJavaScript( $src )
  {
    return $this->_attrJavaScript($src);        
  }
  
  /** 
   * Вставка Java Script кода
   *
   * @return object Возвращает объект класса Dom
   */ 
  public function program($code)
  {
    $code = '<!--'.self::LF.$code.self::LF.'-->';
    return $this->html($code);
  }

  /** 
   * Установка типа JavaScript
   *
   * @return object Возвращает объект класса Dom
   */ 
  public function javascript()
  {
    return $this->attr( 'type', 'text/javascript' );    
  }  
  
  /** 
   * Установка атрибутов для Java Script файлов
   *
   * @return void
   */ 
  protected function _attrJavaScript($src)
  {
    if(self::$docType != self::DOC_HTML_5)$this->attr( 'language', 'JavaScript');    
    return $this->attr( 'type', 'text/javascript')->attr( 'src', $src);    
  }  
}