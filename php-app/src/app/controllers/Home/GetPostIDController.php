<?php

require_once SRC_ROOT_PATH . "/app/baseclasses/BaseController.php";
require_once SRC_ROOT_PATH . "/app/models/HomeModel.php";
class GetPostIDController extends BaseController{
    protected static $instance;
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new static(HomeModel::getInstance());
        }
        return self::$instance;
    }
    public function get($urlParams){
        $postid = $urlParams[1];
        $owner_username = $urlParams[0];
        $owner = $this->srv->getUsernameByPostOwnerId($owner_username);
        $result = $this->srv->getPostByID($postid,$owner);
        if($result!=null){
            echo json_encode($result);
        }
        else{
            echo json_encode(array(
                'status' => 'error',
                'message' => 'post not found'
            ));
        }
    }
}

?>