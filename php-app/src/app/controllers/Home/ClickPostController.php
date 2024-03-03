<?php

require_once SRC_ROOT_PATH . "/app/baseclasses/BaseController.php";
require_once SRC_ROOT_PATH . "/app/models/HomeModel.php";
class ClickPostController extends BaseController{
    protected static $instance;
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new static(HomeModel::getInstance());
        }
        return self::$instance;
    }
    public function put($urlParams){
        parse_str(file_get_contents('php://input'), $_PUT);
        $post_id = $_PUT['post_id'];
        $owner_user = $_PUT['owner_id'];
        $owner_id = $this->srv->getUsernameByPostOwnerId($owner_user);
        $hasil = $this->srv->plusView($post_id,$owner_id);
        if($hasil==true){
            $hasiljson = array(
                'status' => 'succes',
                'message' => 'View berhasil ditambahkan'
            );
            header('Content-Type: application/json');
            return json_encode($hasiljson);
        }
        else{
            $hasiljson = array(
                'status' => 'error',
                'message' => 'View gagal ditambahkan',
                'data' => $owner_user
            );
            header('Content-Type: application/json');
            return json_encode($hasiljson);  
        }
    }
}

?>