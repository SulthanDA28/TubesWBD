<?php

require_once SRC_ROOT_PATH . "/app/baseclasses/BaseModel.php";
require_once SRC_ROOT_PATH . "/app/core/PDOHandler.php";

class RegisterModel
{
    protected static $instance;


    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }


    public static function register($username, $password, $nama)
    {
        try{
            $hashpass = password_hash($password, PASSWORD_DEFAULT);
            $db = PDOHandler::getInstance()->getPDO();
            $check = "SELECT * FROM users WHERE username = '$username'";
            $hasilcek = $db->query($check);
            $row = $hasilcek->fetchAll(PDO::FETCH_ASSOC);
            if($row){
                return false;
            }
            else{

                $sql = "INSERT INTO users (username, password_hashed, profile_name, role) VALUES ('$username', '$hashpass', '$nama', 'user')";
                $result = $db->query($sql);
                if ($result) {
                    return true;
                } else {
                    return false;
                }
            }
        }catch(Exception $e){
            return false;
        }
    }
}
?>