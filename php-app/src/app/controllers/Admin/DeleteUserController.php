<?php

require_once SRC_ROOT_PATH . "/app/baseclasses/BaseController.php";
require_once SRC_ROOT_PATH . "/app/models/AdminModel.php";

class DeleteUserController extends BaseController{
    protected static $instance;
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new static(AdminModel::getInstance());
        }
        return self::$instance;
    }
    public function delete($urlParams){
        parse_str(file_get_contents('php://input'), $_DELETE);
        $user_id = $_DELETE['id'];
        $hasil = $this->srv->deleteUser($user_id);
        if($hasil==true){
            $hasiljson = array(
                'status' => 'sukses',
                'message' => 'User berhasil di hapus'
            );
            header('Content-Type: application/json');
            return json_encode($hasiljson);
        }
        else{
            $hasiljson = array(
                'status' => 'error',
                'message' => 'User gagal di hapus'
            );
            header('Content-Type: application/json');
            return json_encode($hasiljson);
            
        }
    }
        
}

?>