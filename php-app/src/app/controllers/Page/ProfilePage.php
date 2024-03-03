<?php
require_once SRC_ROOT_PATH . "/app/baseclasses/BaseController.php";
class ProfilePage extends BaseController{
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
        if(!isset($_SESSION['user_id'])) {
            header("Location: /login");
        }
        require PAGE_PATH . "/profile.php";
        exit();
    }
}
?>