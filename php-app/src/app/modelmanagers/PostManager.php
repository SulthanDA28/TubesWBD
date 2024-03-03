<?php

require_once SRC_ROOT_PATH . "/app/baseclasses/BaseManager.php";

require_once SRC_ROOT_PATH . "/app/models/PostModel.php";

require_once SRC_ROOT_PATH . "/app/modelmanagers/PostResourceManager.php";

class PostManager extends BaseManager
{
  protected static $instance;
  protected $tableName = 'posts';

  protected function __construct()
  {
    parent::__construct();
  }

  public static function getInstance()
  {
    if (!isset(self::$instance)) {
      self::$instance = new static();
    }
    return self::$instance;
  }

  public static function getTagsSelection($tags = []) {
    $arrTags = BaseManager::arrToSQLArr($tags);
    $where = ['tags' => ["@>", $arrTags, PDO::PARAM_STR]];
    
    return $where;
  }

  public static function getUserSelection($user_id) {
    $where = ['owner_id' => ['=', $user_id, PDO::PARAM_INT]];

    return $where;
  }

  public function createPost(
    $owner_id,
    $body,
    $refer_type = null,
    $refer_post = null,
    $refer_post_owner = null
    )
  {
    preg_match_all("/(#\w+)/u", $body, $matches);  
    if ($matches) {
        $tagsArray = array_count_values($matches[0]);
        $tags = array_keys($tagsArray);
    }

    $postArr = [
      'owner_id' => $owner_id,
      'body' => $body
    ];

    if(!is_null($refer_type)) {
      $postArr['refer_type'] = $refer_type;
      $postArr['refer_post'] = $refer_post;
      $postArr['refer_post_owner'] = $refer_owner;
    }

    if(isset($tags)) {
      $tagsSQL = BaseManager::arrToSQLArr($tags);
      $postArr['tags'] = $tagsSQL;
    }

    $postObj = new PostModel();
    $postObj = $postObj->constructFromArray($postArr);

    $attributes = array_intersect_key(PostModel::$PDOATTR, $postArr);

    $post_id = $this->insert($postObj, $attributes, 'post_id');
    $post_id = $post_id['post_id'];

    return $post_id;
  }

  public function insertResources($post_id, $owner_id, $resources)
  {
    $postResourceArr = [
      'post_id' => $post_id,
      'post_owner_id' => $owner_id,
      'path' => null
    ];

    $postResourceSrv = PostResourceManager::getInstance();

    foreach ($resources as $filename) {
      $postResourceArr['path'] = $filename;
      $postResourceObj = new PostResourceModel($postResourceArr);

      $attributes = array_intersect_key(PostResourceModel::$PDOATTR, $postResourceArr);
      $postResourceSrv->insert($postResourceObj, $attributes);
    }
  }

  public function getResources($post_id, $post_owner_id)
  {
    $postResourceSrv = PostResourceManager::getInstance();

    $where = [
      "post_id" => ["=", $post_id, PostResourceModel::$PDOATTR["post_id"]],
      "post_owner_id" => ["=", $post_owner_id, PostResourceModel::$PDOATTR["post_owner_id"]]
    ];
    return $postResourceSrv->findAll();
  }

  public function getByUser($user_id)
  {
    $where = PostManager::getUserSelection($user_id);
    return $this->findAll(where:$where);
  }

  public function getReplies($post_id, $owner_id)
  {
    $where = [
      'refer_type' => ['=', 'Reply', PDO::PARAM_STR],
      'refer_post_id' => ['=', $post_id, PDO::PARAM_INT],
      'refer_post_owner' => ['=', $owner_id, PDO::PARAM_INT]
    ];
  }
}