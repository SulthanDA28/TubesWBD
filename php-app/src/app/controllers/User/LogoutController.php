<?php



require_once SRC_ROOT_PATH . "/app/baseclasses/BaseController.php";
require_once SRC_ROOT_PATH . "/app/models/LoginModel.php";

class LogoutController extends BaseController{
    protected static $instance;
    private function __construct($srv){
        parent::__construct($srv);
    }
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new static(LoginModel::getInstance());
        }
        return self::$instance;
    }
    
    public function get($urlParams){
       $this->srv->logout();
    }

}




?>