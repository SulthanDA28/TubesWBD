<?php



require_once SRC_ROOT_PATH . "/app/baseclasses/BaseController.php";
require_once SRC_ROOT_PATH . "/app/models/GetAnalyticDataModel.php";

class GetPostCountController extends BaseController{
    protected static $instance;
    private function __construct($srv){
        parent::__construct($srv);
    }
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new static(GetAnalyticDataModel::getInstance());
        }
        return self::$instance;
    }
    
    public function get($urlParams){
        $username = $urlParams[0];
        $data = $this->srv->getPostCountByOwner($username);
        if($data!=null){
            header('Content-Type: application/json');
            return json_encode(array(
                'status' => 'success',
                'message' => 'Success to get data post',
                'data' => $data
            ));
        }
        else{
            header('Content-Type: application/json');
            return json_encode(array(
                'status' => 'failed',
                'message' => 'Failed to get data post',
            ));
        }
    }

}




?>