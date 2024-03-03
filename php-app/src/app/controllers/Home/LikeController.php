<?php

require_once SRC_ROOT_PATH . "/app/baseclasses/BaseController.php";
require_once SRC_ROOT_PATH . "/app/models/HomeModel.php";
class LikeController extends BaseController{
    protected static $instance;
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new static(HomeModel::getInstance());
        }
        return self::$instance;
    }
    public function post($urlParams){
        $post_id = $_POST['post_id'];
        $owner = $_POST['owner'];
        $result = $this->srv->likes($post_id,$owner);
        if($result){
            return json_encode(array('status' => 'success'));
        }
        else{
            return json_encode(array('status' => 'failed'));
        }
    }
}

?>