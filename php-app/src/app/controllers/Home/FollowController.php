<?php

require_once SRC_ROOT_PATH . "/app/baseclasses/BaseController.php";
require_once SRC_ROOT_PATH . "/app/models/HomeModel.php";
class FollowController extends BaseController{
    protected static $instance;
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new static(HomeModel::getInstance());
        }
        return self::$instance;
    }
    public function post($urlParams){
        $userid = $_POST['userid'];
        $data = $this->srv->follow($userid);
        if($data){
            return json_encode(array(
                'status' => 'success',
                'message' => 'Success to follow user',
            ));
        }
        else{
            return json_encode(array(
                'status' => 'failed',
                'message' => 'Failed to follow user',
            ));
        }
        
    }
}

?>