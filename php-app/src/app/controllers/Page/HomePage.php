<?php
require_once SRC_ROOT_PATH . "/app/baseclasses/BaseController.php";
class HomePage extends BaseController{
    protected static $instance;

    public function __construct(){
        parent::__construct(null);
    }
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new static();
        }
        return self::$instance;
    }
    public function get($urlParams){
        require PAGE_PATH . "/home.php";
        exit();
    }
}


?>