<?php

require_once SRC_ROOT_PATH . "/app/baseclasses/BaseManager.php";

require_once SRC_ROOT_PATH . "/app/models/PostResourceModel.php";

class PostResourceManager extends BaseManager
{
    protected static $instance;
    protected $tableName = 'post_resources';

    public function __construct()
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
}