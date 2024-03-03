<?php

require_once SRC_ROOT_PATH . '/app/baseclasses/BaseModel.php';

class PostModel extends BaseModel
{
    public static $PDOATTR = [
        'post_id' => PDO::PARAM_INT,
        'owner_id' => PDO::PARAM_INT,
        'body' => PDO::PARAM_STR,
        'created_at' => PDO::PARAM_STR,
        'refer_type' => PDO::PARAM_STR,
        'refer_post' => PDO::PARAM_INT,
        'refer_post_owner' => PDO::PARAM_INT,
        'tags' => PDO::PARAM_STR
    ];

    public $post_id;
    public $owner_id;
    public $body;
    public $created_at;

    public $refer_type = null;
    public $refer_post = null;
    public $refer_post_owner = null;

    public $tags = [];

    public function __construct($array = null)
    {
        parent::__construct($array);
        $this->_primary_key = ['post_id', 'owner_id'];
    }
}
