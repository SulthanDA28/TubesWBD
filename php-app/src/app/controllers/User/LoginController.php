<?php



require_once SRC_ROOT_PATH . "/app/baseclasses/BaseController.php";
require_once SRC_ROOT_PATH . "/app/models/LoginModel.php";

class LoginController extends BaseController{
    protected static $instance;
    private function __construct($srv){
        parent::__construct($srv);
    }
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new static(LoginModel::getInstance());
        }
        return self::$instance;
    }
    
    public function post($urlParams){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $role = $this->srv->login($username, $password);
        if($role!=null){
            $hasiljson = array(
                'status' => 'sukses',
                'role' => $role['role'],
                'statusakses' => $role['status']

            );
            header('Content-Type: application/json');
            return json_encode($hasiljson);
        }
        else{
            $hasiljson = array(
                'status' => 'error',
                'message' => 'Username atau password salah'
            );
            header('Content-Type: application/json');
            return json_encode($hasiljson);
            
        }
    }

}




?>