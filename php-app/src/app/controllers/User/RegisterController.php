<?php

require_once SRC_ROOT_PATH . "/app/baseclasses/BaseController.php";
require_once SRC_ROOT_PATH . "/app/models/RegisterModel.php";

class RegisterController extends BaseController{
    protected static $instance;
    private function __construct($srv){
        parent::__construct($srv);
    }
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new static(RegisterModel::getInstance());
        }
        return self::$instance;
    }
    public function post($urlParams){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $nama = $_POST['nama'];

        $hasil = $this->srv->register($username, $password, $nama);
        if($hasil==true){
            $hasiljson = array(
                'status' => 'sukses',
                'message' => 'Registrasi berhasil'
            );
            header('Content-Type: application/json');
            return json_encode($hasiljson);
        }
        else{
            $hasiljson = array(
                'status' => 'error',
                'message' => 'Registrasi gagal, username sudah digunakan'
            );
            header('Content-Type: application/json');
            return json_encode($hasiljson);
            
        }
    }

}
?>