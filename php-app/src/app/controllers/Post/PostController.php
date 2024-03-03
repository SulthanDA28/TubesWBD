<?php

require_once SRC_ROOT_PATH . "/app/baseclasses/BaseController.php";

require_once SRC_ROOT_PATH . "/app/core/FileAccess.php";

require_once SRC_ROOT_PATH . "/app/modelmanagers/PostManager.php";

require_once SRC_ROOT_PATH . "/app/clients/SocmedSoapClient.php";

class PostController extends BaseController
{
  protected static $instance;

  protected function __construct($srv)
  {
    parent::__construct($srv);
  }

  public static function getInstance()
  {
    if (!isset(self::$instance)) {
      self::$instance = new static(
        PostManager::getInstance()
      );
    }
    return self::$instance;
  }

  protected function compose()
  {
    // insert post tweetpost here
    $user_id = $_SESSION['user_id'];
    $post_id = $this->srv->createPost(
      owner_id: $user_id,
      body: $_POST['post_body'],
    );

    $resources = [];

    // var_dump($_FILES);
    if(!empty($_FILES['file_input']['tmp_name'])) {
      $fileAccess = FileAccess::getInstance();
      $newFileName = $fileAccess->saveFile($_FILES['file_input']['tmp_name'], FileAccess::POSTS_PATH, $_FILES['file_input']['type']);

      $resources[] = $newFileName;
    }

    $this->srv->insertResources(
      $post_id,
      $user_id,
      $resources
    );

    // send SOAP message when user reached 5th post
    if ($post_id == 4) {
      $soapClient = SocmedSoapClient::getInstance();
      $soapClient->requestUnlocking($_SESSION['user_id'], $_SESSION['username']);
    }
  }

  protected function post($urlParams)
  {
    $this->compose();
    header("Location: /");
    exit();
  }
}