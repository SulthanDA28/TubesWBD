<?php


require_once SRC_ROOT_PATH . "/app/baseclasses/BaseController.php";
require_once SRC_ROOT_PATH . "/app/models/UserModel.php";

class AdminController extends BaseController{
    protected static $instance;
    private function __construct($srv){
        parent::__construct($srv);
    }
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new static(UserModel::getInstance());
        }
        return self::$instance;
    }
    public function get($urlParams){
        $ban = $this->srv->getAllUserBan();
        $unban = $this->srv->getAllUserUnban();


        if($ban!=null || $unban!=null){
            $hasiljson = array(
                'status' => 'sukses',
                'ban' => $ban,
                'unban' => $unban
            );
            header('Content-Type: application/json');
            return json_encode($hasiljson);
        }
        else{
            $hasiljson = array(
                'status' => 'error',
                'message' => 'Tidak ada user'
            );
            header('Content-Type: application/json');
            return json_encode($hasiljson);
            
        }
        
    }

}

?>