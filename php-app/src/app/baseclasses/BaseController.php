<?php
require_once SRC_ROOT_PATH . "/app/exceptions/BadRequestException.php";
require_once SRC_ROOT_PATH . "/app/exceptions/MethodNotAllowedException.php";
// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
// header('Access-Control-Allow-Headers: token, Content-Type');
// header('Access-Control-Max-Age: 1728000');
// header('Content-Length: 0');
// header('Content-Type: text/plain');
// header('Access-Control-Allow-Origin: *');
// header('Content-Type: application/json');
abstract class BaseController {
  protected static $instance;
  protected $srv;

  protected function __construct($srv) {
    $this->srv = $srv;
  }

  public static function getInstance() {
    if (!isset(self::$instance)) {
      self::$instance = new static(null);
    }
    return self::$instance;
  }

  protected function get($urlParams) {
    throw new MethodNotAllowedException("Method not allowed");  
  }
  protected function post($urlParams) {
    throw new MethodNotAllowedException("Method not allowed");  
  }
  protected function put($urlParams) {
    throw new MethodNotAllowedException("Method not allowed");  
  }
  protected function delete($urlParams) {
    throw new MethodNotAllowedException("Method not allowed");
  }

  /**
   * Handle request, wrapper method
   */
  public function handle($method, $urlParams) {
    $lowMethod = strtolower($method);
    echo $this->$lowMethod($urlParams);
  }
}
