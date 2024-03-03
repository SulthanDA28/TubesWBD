<?php

require_once SRC_ROOT_PATH . "/app/baseclasses/BaseController.php";
require_once SRC_ROOT_PATH . "/app/models/HomeModel.php";
class UnfollowController extends BaseController{
    protected static $instance;
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new static(HomeModel::getInstance());
        }
        return self::$instance;
    }
    public function delete($urlParams){
        parse_str(file_get_contents('php://input'), $_DELETE);
        $userid = $_DELETE['userid'];
        $data = $this->srv->unfollow($userid);
        if($data){
            return json_encode(array(
                'status' => 'success',
                'message' => 'Success to unfollow user',
            ));
        }
        else{
            return json_encode(array(
                'status' => 'failed',
                'message' => 'Failed to unfollow user',
            ));
        }
        
    }
}

?>