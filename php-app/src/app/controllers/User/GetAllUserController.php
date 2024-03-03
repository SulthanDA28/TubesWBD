<?php



require_once SRC_ROOT_PATH . "/app/baseclasses/BaseController.php";
require_once SRC_ROOT_PATH . "/app/models/UserModel.php";

class GetAllUserController extends BaseController{
    protected static $instance;
    private function __construct($srv){
        parent::__construct($srv);
    }
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new static(UserModel::getInstance());
        }
        return self::$instance;
    }
    
    public function get($urlParams){
        $data = $this->srv->getAllUser();
        if($data!=null){
            return json_encode(array(
                'status' => 'success',
                'message' => 'Success to get all user',
                'data' => $data
            ));
        }
        else{
            return json_encode(array(
                'status' => 'failed',
                'message' => 'Failed to get all user',
            ));
        }
    }

}




?>