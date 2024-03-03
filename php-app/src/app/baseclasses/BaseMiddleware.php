<?php

abstract class BaseMiddleware {
  private static $instance;

  private function __construct() {}

  public static function getInstance() {
    if (!isset(self::$instance)) {
      self::$instance = new static();
    }
    return self::$instance;
  }

  public function __invoke($path, $method)
  {
    return false;
  }
}
