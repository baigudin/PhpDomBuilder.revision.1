<?php
/** 
 * Тег <input type="file">
 * 
 * Элемент формы.
 * 
 * @author    Sergey Baigudin <baigudin@mail.ru>
 * @copyright 2012-2014
 * @license   http://baigudin.com/license/
 * @link      http://baigudin.com 
 */
namespace DomBuilder\Tag\Input; 

class File extends \DomBuilder\Tag\Input
{
  /**
   * Признака необходимости заполнения поля
   * @var boolean
   */   
  protected $_fill;
  /** 
   * Установки для загружаемого файла
   * @var StdClass
   */    
  protected $_file;  
  
  /** 
   * Конструктор класса
   * 
   * @return void
   */
  function __construct()
  {
    parent::__construct();
    $this->attr('type', 'file');
    $this->_fill = false;
    $this->_file = new \StdClass();
    $this->_file->name = '';
    $this->_file->path = '';    
    $this->_file->type = '';
    $this->_file->size = 0;    
    $this->_file->maxSize = 0;
    $this->_file->minSize = 0;    
  } 
  

  /** 
   * Установка условия проверки
   * 
   * @param string $reg условие проверки
   * @return object Возвращает объект класса Input
   */   
  public function check()
  {
    $name = $this->attr('name');
    if( !isset($_FILES[$name]) ) return $this->error(false);
    switch($_FILES[$name]['error'])
    {
      case 0:
      {
        if( $_FILES[$name]['size'] > $this->_file->maxSize )
          return $this->error(true)->errorStr($this->_lang('Размер файла больше допустимого'));
        else if( $_FILES[$name]['size'] < $this->_file->minSize )
          return $this->error(true)->errorStr($this->_lang('Размер файла меньше допустимого'));
        else
        {
          $this->_file->name = $_FILES[$name]['name'];
          $this->_file->path = $_FILES[$name]['tmp_name'];                          
          $this->_file->type = $_FILES[$name]['type'];
          $this->_file->size = $_FILES[$name]['size'];              
          return $this->error(false);                    
        }
      }
      break;
      case 1: return $this->error(true)->errorStr($this->_lang('Размер принятого файла превысил максимально допустимый размер'));
      case 2: return $this->error(true)->errorStr($this->_lang('Размер загружаемого файла превысил максимальное значение формы'));
      case 3: return $this->error(true)->errorStr($this->_lang('Загружаемый файл был получен только частично'));
      case 4: 
      {
        if( $this->fill()===false ) return $this->error(false); 
        else return $this->error(true)->errorStr($this->_lang('Файл не был загружен'));
      }
    }
    return $this->error(true);
  }
  
  /** 
   * Получение значения поля ввода из глобальной переменной $_FILES
   *
   * @return object Возвращает объект класса StdClass
   */   
  public function value()
  {
    $name = $this->attr('name');
    if( empty($name) || !isset($_FILES[$name]) ) return false;
    return $_FILES[$name];    
  }

  /** 
   * Данные о файле
   * 
   * @return object Возвращает объект класса StdClass
   */  
  public function file()
  {
    return $this->_file;
  }    
  
  /** 
   * Установка/взятие признака необходимости заполнения поля
   * 
   * @param boolen $fill Признак необходимости заполнения поля [optional]      
   * @return mixed Возвращает объект класса Input или признак необходимости проверки
   */   
  public function fill( $fill=NULL )
  {
    if( !isset($fill) ) return $this->_fill;
    $this->_fill = $fill;
    return $this; 
  }
  
  /** 
   * Установка допустимого размера
   * 
   * @param integer $min Минимальный размер     
   * @param integer $max Максимальный размер        
   * @return object Возвращает объект класса Input
   */  
  public function fileSize( $min, $max )
  {
    return $this->fileMinSize($min)->fileMaxSize($max);
  }  

  /** 
   * Установка допустимого размера
   * 
   * @param integer $size Размер [optional]      
   * @return object Возвращает объект класса Input
   */  
  public function fileMaxSize( $size=NULL )
  {
    if( !isset($size) ) return $this->_file->maxSize;
    $this->_file->maxSize = $size;  
    return $this;
  }  
  
  /** 
   * Установка допустимого размера
   * 
   * @param integer $size Размер [optional]      
   * @return object Возвращает объект класса Input
   */  
  public function fileMinSize( $size=NULL )
  {
    if( !isset($size) ) return $this->_file->minSize;
    $this->_file->minSize = $size;  
    return $this;
  }   
}