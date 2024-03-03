<?php

require_once SRC_ROOT_PATH . "/app/baseclasses/BaseModel.php";
require_once SRC_ROOT_PATH . "/app/core/PDOHandler.php";

class UserModel
{
    public function isAdmin(){
        return $_SESSION['role'] == 'admin';
    }

    public function isUser(){
        return $_SESSION['role'] == 'user';
    }

    public function isLogin(){
        return isset($_SESSION['user_id']);
    }
    protected static $instance;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function getAllUser(){
        try{
            $user = $_SESSION['user_id'];
            $db = PDOHandler::getInstance()->getPDO();
            $sql = "SELECT * FROM users WHERE id != $user AND role='user' ORDER BY id";
            $result = $db->query($sql);
            if($result){
                $hasil = $result->fetchAll(PDO::FETCH_ASSOC);
                return $hasil;
            }
            else{
                return null;
            }
        }catch(Exception $e){
            return null;
        }

    }
    public function getAllUserBan(){
        try{
            $db = PDOHandler::getInstance()->getPDO();
            $sql = "SELECT * FROM users WHERE status = 'ban' ORDER BY id";
            $result = $db->query($sql);
            $hasil = $result->fetchAll(PDO::FETCH_ASSOC);
            return $hasil;
        }catch(Exception $e){
            return null;
        }

    }
    public function getAllUserUnban(){
        try{
            $db = PDOHandler::getInstance()->getPDO();
            $sql = "SELECT * FROM users WHERE status IS NULL and role = 'user' ORDER BY id";
            $result = $db->query($sql);
            $hasil = $result->fetchAll(PDO::FETCH_ASSOC);
            return $hasil;
        }catch(Exception $e){
            return null;
        }

    }



}

?>