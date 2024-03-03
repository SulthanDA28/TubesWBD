<?php

require_once SRC_ROOT_PATH . "/app/baseclasses/BaseController.php";
require_once SRC_ROOT_PATH . "/app/controllers/Post/PostController.php";

class ComposePage extends BaseController{
    protected static $instance;

    public function __construct($srv){
        parent::__construct($srv);
    }

    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new static(
                PostController::getInstance()
            );
        }
        return self::$instance;
    }

    protected function get($urlParams)
    {
        require PAGE_PATH . "/compose.php";
        exit();
    }
}


?>