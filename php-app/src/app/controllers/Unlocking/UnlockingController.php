<?php

require_once SRC_ROOT_PATH . "/app/services/UnlockingService.php";
require_once SRC_ROOT_PATH . "/app/baseclasses/BaseController.php";

class UnlockingController extends BaseController {
  protected static $instance;

  private function __construct($srv)
  {
    parent::__construct($srv);
  }

  public static function getInstance()
  {
    if (!isset(self::$instance)) {
      self::$instance = new static(
        UnlockingService::getInstance()
      );
    }
    return self::$instance;
  }

  public function post($urlParams) {
    
    $socmed_id = $_SESSION['id'];
    $link_code = $_SESSION['username'];

    return $this->srv->requestUnlocking($socmed_id, $link_code);
  }
}
