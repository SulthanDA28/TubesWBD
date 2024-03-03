<?php

require_once SRC_ROOT_PATH . "/app/baseclasses/BaseController.php";
require_once SRC_ROOT_PATH . "/app/models/HomeModel.php";
class ProfileUserController extends BaseController{
    protected static $instance;
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new static(HomeModel::getInstance());
        }
        return self::$instance;
    }
    public function get($urlParams){
        $userid = $urlParams[0];
        $data = $this->srv->getProfileUser($userid);
        if($data){
            return json_encode(array(
                'status' => 'success',
                'data' => $data
            ));
        }
        else{
            $data2 = $this->srv->getProfileID($userid);
            if($data2){
                if($data2['id']==$_SESSION['user_id']){
                    $hasil =json_encode(array(
                        'status' => 'success3',
                        'data' => $data2
                    ));
                    return $hasil;
                }
                else{
                    $hasil =json_encode(array(
                        'status' => 'success2',
                        'data' => $data2
                    ));
                    return $hasil;
                }
            }
            else{
                return json_encode(array(
                    'status' => 'failed',
                    'data' => null
                ));
            }
        }
        
    }
}

?>