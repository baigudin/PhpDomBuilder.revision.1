<?php
/** 
 * Тег <form>
 * 
 * Устанавливает форму на веб-странице.
 * 
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag; 

class Form extends \DomBuilder\Tag
{
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('form')->tagStyle(self::TAG_STYLE_DOUBLE)->tagType(self::TAG_TYPE_BLOCK);    
  }
  
  /** 
   * Получение/установка значения атрибута action
   *
   * @param string $value Значение [optional]   
   * @return string Возвращает значения поля или false
   */   
  public function action( $value=NULL )
  {
    if( !isset($value) ) return $this->attr('action');
    if( self::$docType==self::DOC_HTML_5 && empty($value) ) return $this;
    return $this->attr('action', $value);
  }
  
  /** 
   * Получение/установка значения атрибута enctype
   *
   * @param string $value Значение [optional]   
   * @return string Возвращает значения поля или false
   */   
  public function enctype( $value=NULL )
  {
    if( isset($value) ) return $this->attr('enctype', $value);
    return $this->attr('enctype');
  }  
  
  /** 
   * Установка атрибута method = post
   *
   * @return string Возвращает значения поля или false
   */   
  public function get()
  {
    return $this->method('get');
  }   

  /** 
   * Установка атрибута method = post
   *
   * @return string Возвращает значения поля или false
   */   
  public function post()
  {
    return $this->method('post');
  }  
  
  /** 
   * Получение/установка значения атрибута method
   *
   * @param string $value Значение [optional]   
   * @return string Возвращает значения поля или false
   */   
  public function method( $value=NULL )
  {
    return $this->attr('method', $value);
  }  
}