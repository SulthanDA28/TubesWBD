<?php

require_once SRC_ROOT_PATH . "/app/baseclasses/BaseController.php";
require_once SRC_ROOT_PATH . "/app/models/AdminModel.php";

class SetAdminController extends BaseController{
    protected static $instance;
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new static(AdminModel::getInstance());
        }
        return self::$instance;
    }
    public function post($urlParams){
        $user_id = $_POST['id'];
        $hasil = $this->srv->setAdmin($user_id);
        if($hasil==true){
            $hasiljson = array(
                'status' => 'sukses',
                'message' => 'User berhasil di set admin'
            );
            header('Content-Type: application/json');
            return json_encode($hasiljson);
        }
        else{
            $hasiljson = array(
                'status' => 'error',
                'message' => 'User gagal di set admin'
            );
            header('Content-Type: application/json');
            return json_encode($hasiljson);
            
        }
    }
        
}

?>