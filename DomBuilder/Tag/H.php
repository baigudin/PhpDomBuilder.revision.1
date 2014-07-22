<?php
/** 
 * Теги от <h1> до  <h6>
 * 
 * Заголовок веб-страницы.
 * 
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag; 

class H extends \DomBuilder\Tag
{
  /**
   * Уровень заголовка по умолчанию
   */ 
  const LEVEL = 6;
  
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('h'.self::LEVEL)->tagStyle(self::TAG_STYLE_DOUBLE)->tagType(self::TAG_TYPE_BLOCK);
  }
  
  /** 
   * Установка уровня заголовка
   *
   * @param integer $level Уровень заголовка от 1 до 6   
   * @return object Возвращает свой объект
   */
  public function level($level)
  {
    if( (1<=$level)&&($level<=6) )
      $this->tagName( sprintf('h%s', $level) );
    else
      $this->tagName( sprintf('h%s', self::LEVEL) );  
    return $this;
  }  
}