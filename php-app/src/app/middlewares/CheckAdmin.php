<?php

require_once SRC_ROOT_PATH . "/app/exceptions/BadRequestException.php";
require_once SRC_ROOT_PATH . "/app/models/UserModel.php";

class CheckAdmin {
    private static $instance;

    private function __construct() {}

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function __invoke($path,$method){
        $admin = UserModel::getInstance()->isAdmin();
        if(!$admin){
            throw new BadRequestException("You must admin dulu");
        }
        return true;
    }
}

?>