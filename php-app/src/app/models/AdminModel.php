<?php

require_once SRC_ROOT_PATH . "/app/baseclasses/BaseModel.php";
require_once SRC_ROOT_PATH . "/app/core/PDOHandler.php";

class AdminModel
{
    protected static $instance;
    
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function banUser($user_id){
        try{
            $db = PDOHandler::getInstance()->getPDO();
            $sql = "UPDATE users SET status = 'ban' WHERE id = '$user_id'";
            $result = $db->query($sql);
            if($result){
                return true;
            }
            else{
                return false;
            }
        }catch(Exception $e){
            return false;
        }
    }

    public function unbanUser($user_id){
        try{
            $db = PDOHandler::getInstance()->getPDO();
            $sql = "UPDATE users SET status = null WHERE id = '$user_id'";
            $result = $db->query($sql);
            if($result){
                return true;
            }
            else{
                return false;
            }
        }catch(Exception $e){
            return false;
        }
    }

    public function setAdmin($user_id){
        try{
            $db = PDOHandler::getInstance()->getPDO();
            $sql = "UPDATE users SET role = 'admin' WHERE id = '$user_id'";
            $result = $db->query($sql);
            if($result){
                return true;
            }
            else{
                return false;
            }
        }catch(Exception $e){
            return false;
        }
    }

    public function deleteUser($user_id){
        try{
            $db = PDOHandler::getInstance()->getPDO();
            $sql1 = "DELETE FROM users_detail WHERE id = $user_id";
            $sql = "DELETE FROM users WHERE id = $user_id";
            $result1 = $db->query($sql1);
            $result = $db->query($sql);
            if($result && $result1){
                return true;
            }
            else{
                return false;
            }
        }catch(Exception $e){
            return false;
        }
    }

}

?>
