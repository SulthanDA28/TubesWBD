<?php

require_once SRC_ROOT_PATH . "/app/baseclasses/BaseModel.php";
require_once SRC_ROOT_PATH . "/app/core/PDOHandler.php";

class LoginModel 
{
    protected static $instance;


    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }



    public static function login($username, $password)
    {
        try{
            $db = PDOHandler::getInstance()->getPDO();
            $sql = "SELECT * FROM users WHERE username = '$username'";
            $result = $db->query($sql);
            $row = $result->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                if(password_verify($password, $row['password_hashed'])){
                    if($row['status'] == 'ban'){
                        $array = array('status' => $row['status'], 'role' => $row['role']);
                        return $array;
                    }
                    else
                    {
                        $_SESSION['user_id'] = $row['id'];
                        $_SESSION['role'] = $row['role'];
                        $_SESSION['username'] = $row['username'];
                        $array = array('status' => $row['status'], 'role' => $row['role']);
                        return $array;
                    }
                }
                else{
                    return null;
                }
        
                
            } else {
                return null;
            }
        }catch(Exception $e){
            return null;
        }
    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['role']);
    }

}

?>