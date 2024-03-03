<?php

abstract class BaseModel {
  public static $PDOATTR = [];
  public $_primary_key = '';

  public function __construct($array = null) {
    if(!is_null($array)){
      $this->constructFromArray($array);
    }
  }

  public function set($attribute, $value) {
    $this->$attribute = $value;
    return $this;
  }

  public function get($attribute) {
    return $this->$attribute;
  }
  
  public final function constructFromArray($array)
  {
    foreach (array_keys($array) as $attribute) {
      $this->$attribute = $array[$attribute];
    }

    return $this;
  }

  public final function toArray()
  {
    $array = [];
    foreach ($this->_attributes as $attribute) {
      $array[$attribute] = $this->$attribute;
    }

    return $array;
  }
}
