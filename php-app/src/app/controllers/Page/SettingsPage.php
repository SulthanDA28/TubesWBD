<?php

require_once SRC_ROOT_PATH . "/app/baseclasses/BaseController.php";
class SettingsPage extends BaseController{
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

    public function get($urlParams)
    {
        if($urlParams[0] = 'profile') {
            require PAGE_PATH . "/profile_setting.php";
            exit();
        }
        if($urlParams[0] = '') {
            require PAGE_PATH . "/settings.php";
            exit();
        }
    }
}


?>