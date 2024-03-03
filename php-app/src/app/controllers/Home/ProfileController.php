<?php

require_once SRC_ROOT_PATH . "/app/baseclasses/BaseController.php";
require_once SRC_ROOT_PATH . "/app/models/HomeModel.php";
class ProfileController extends BaseController{
    protected static $instance;
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new static(HomeModel::getInstance());
        }
        return self::$instance;
    }
    public function get($urlParams){
        $data = $this->srv->getProfile();
        if($data){
            return json_encode(array(
                'status' => 'success',
                'data' => $data
            ));
        }
        else{
            return json_encode(array(
                'status' => 'failed',
                'message' => 'Failed to get profile',
            ));
        }
    }
}

?>