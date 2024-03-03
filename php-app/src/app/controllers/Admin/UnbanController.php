<?php

require_once SRC_ROOT_PATH . "/app/baseclasses/BaseController.php";
require_once SRC_ROOT_PATH . "/app/models/AdminModel.php";
class UnbanController extends BaseController{
    protected static $instance;
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new static(AdminModel::getInstance());
        }
        return self::$instance;
    }
    public function put($urlParams){
        parse_str(file_get_contents('php://input'), $_PUT);
        $user_id = $_PUT['id'];
        $hasil = $this->srv->unbanUser($user_id);
        if($hasil==true){
            $hasiljson = array(
                'status' => 'sukses',
                'message' => 'User berhasil di unbanned'
            );
            header('Content-Type: application/json');
            return json_encode($hasiljson);
        }
        else{
            $hasiljson = array(
                'status' => 'error',
                'message' => 'User gagal di unbanned'
            );
            header('Content-Type: application/json');
            return json_encode($hasiljson);
            
        }
    }
        
    
}

?>