<?php
/** 
 * Определение для IE
 * 
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag\Extend;

class Ie extends \DomBuilder\Tag
{
  /**
   * Версия браузера
   * @var string
   */   
  protected $_version; 
  
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->tagName('ie')->tagStyle(self::TAG_STYLE_DOUBLE)->tagType(self::TAG_TYPE_BLOCK);
    $this->_version = '';
  }
  
  /** 
   * Получение двойного тега
   *
   * @param mixed $value версия браузера
   * @return mixed
   */  
  public function version($value=NULL)
  {
    if( !isset($value) ) return $this->_version;
    $this->_version = (string)$value;
    return $this;
  }
  
  /** 
   * Получение двойного тега
   *
   * @return string
   */  
  protected function _tagDoubleOpen()
  {  
    $ver = ( empty($this->_version) ) ? '' : ' '.$this->_version;  
    return '<!--[if IE'.$ver.']>';
  }

  /** 
   * Получение двойного тега
   *
   * @return string
   */  
  protected function _tagDoubleClose()
  { 
    $ver = ( empty($this->_version) ) ? '' : ' '.$this->_version;
    return '<![endif IE'.$ver.']-->';
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