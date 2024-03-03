<?php

require_once SRC_ROOT_PATH . "/app/baseclasses/BaseModel.php";
require_once SRC_ROOT_PATH . "/app/core/PDOHandler.php";

class GetAnalyticDataModel
{
    protected static $instance;


    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function getFollows($username, $date){
        try{
            $db = PDOHandler::getInstance()->getPDO();
            $sql = "SELECT COUNT(*) AS total from follows f INNER JOIN users u ON followed_user_id=id WHERE u.username='$username' AND f.created_at <= '$date'::date+1";
            $result = $db->query($sql);
            if($result){
                $data = $result->fetch(PDO::FETCH_ASSOC);
                return $data;
            }
            else{
                return null;
            }
        }catch(Exception $e){
            echo $e->getMessage();
            return null;
        }
    }
    public function getPostCountByOwner($username){
        try{
            $db = PDOHandler::getInstance()->getPDO();
            $sql = "SELECT COUNT(*) count FROM posts p LEFT JOIN users u ON owner_id=id WHERE username='$username' AND p.refer_type IS NULL";
            $result = $db->query($sql);
            // $sql2 = "SELECT DATE(created_at) as day, COUNT(post_id) as total from posts WHERE refer_post_owner=$owner AND refer_type='Reply' GROUP BY day ORDER BY day DESC LIMIT 7";
            // $result2 = $db->query($sql2);
            // $sql3 = "SELECT DATE(created_at) as day, COUNT(post_id) as total from likes WHERE post_owner_id=$owner GROUP BY day ORDER BY day DESC LIMIT 7";
            // $result3 = $db->query($sql3);
            // $sql4 = "SELECT DATE(created_at) as day, SUM(views) as total from posts WHERE owner_id=$owner GROUP BY day ORDER BY day DESC LIMIT 7";
            // $result4 = $db->query($sql4);
            if($result){
                $data = $result->fetch(PDO::FETCH_ASSOC);
                return $data;
            }
            else{
                return null;
            }
        }catch(Exception $e){
            echo $e->getMessage();
            return null;
        }
    }
    public function getDataPostIDByOwner($username, $post_id, $date){
        try{
            $db = PDOHandler::getInstance()->getPDO();
            $sql = "SELECT id FROM users WHERE username='$username'";
            $result = $db->query($sql);
            if(is_null($result)) return null;
            $owner = $result->fetch(PDO::FETCH_ASSOC);
            if(!$owner) return null;
            $owner = $owner['id'];

            $repliesQuery = "SELECT COUNT(*) AS total FROM posts WHERE refer_type='Reply' AND refer_post_owner=$owner AND refer_post=$post_id AND created_at <= '$date'::date+1";
            $repliesResult = $db->query($repliesQuery);
            if(is_null($repliesResult)) return null;
            $repliescount = $repliesResult->fetch(PDO::FETCH_ASSOC);

            $likesQuery = "SELECT COUNT(*) AS total FROM likes WHERE post_owner_id=$owner AND post_id=$post_id AND created_at <= '$date'::date+1";
            $likesResult = $db->query($likesQuery);
            if(is_null($likesResult)) return null;
            $likescount = $likesResult->fetch(PDO::FETCH_ASSOC);
            
            $viewsResult = "SELECT views AS total FROM posts WHERE owner_id=$owner AND post_id=$post_id";
            $viewsResult = $db->query($viewsResult);
            if(is_null($viewsResult)) return null;
            $viewscount = $viewsResult->fetch(PDO::FETCH_ASSOC);
            if(!$viewscount) return null;
            
            // var_dump($repliescount);
            // var_dump($likescount);
            // var_dump($viewscount);
            return array(
                'replies' => $repliescount['total'],
                'likes' => $likescount['total'],
                'views' => $viewscount['total']
            );
        }catch(Exception $e){
            echo $e->getMessage();
            return null;
        }
    }
}

?>