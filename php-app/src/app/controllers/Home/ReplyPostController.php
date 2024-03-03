<?php

require_once SRC_ROOT_PATH . "/app/baseclasses/BaseController.php";
require_once SRC_ROOT_PATH . "/app/models/HomeModel.php";
class ReplyPostController extends BaseController{
    protected static $instance;
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new static(HomeModel::getInstance());
        }
        return self::$instance;
    }
    public function post($urlParams){
        $postid = $urlParams[1];
        $owner_user = $urlParams[0];
        $body = $_POST['body'];
        $owner = $this->srv->getUsernameByPostOwnerId($owner_user);
        $result = $this->srv->replyPost($postid,$owner,$body);
        if($result){
            return json_encode(array(
                'status' => 'success',
                'message' => 'reply success'
            ));
        }
        else{
            return json_encode(array(
                'status' => 'failed',
                'message' => 'Cannot reply post. You must post something or there is something wrong'
            ));
        }
    }
}

?>