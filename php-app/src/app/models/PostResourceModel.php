<?php

require_once SRC_ROOT_PATH . '/app/baseclasses/BaseModel.php';

class PostResourceModel extends BaseModel
{
    public static $PDOATTR = [
        'post_id' => PDO::PARAM_INT,
        'post_owner_id' => PDO::PARAM_INT,
        'path' => PDO::PARAM_STR
    ];

    public $post_id;
    public $post_owner_id;
    public $body;

    public function __construct($array = null)
    {
        parent::__construct($array);
        $this->_primary_key = ['post_id', 'post_owner_id'];
    }
}
