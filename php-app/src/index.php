<?php

define('SRC_ROOT_PATH', __DIR__);
define('CONTROLLER_PATH', __DIR__ . '/app/controllers');
define('MIDDLEWARE_PATH', __DIR__ . '/app/middlewares');
define('PAGE_PATH', __DIR__ . '/app/view');


require_once "app/config/config.php";
require_once SRC_ROOT_PATH . "/app/router/Router.php";
require_once CONTROLLER_PATH . "/User/LoginController.php";
require_once CONTROLLER_PATH . "/User/LogoutController.php";
require_once CONTROLLER_PATH . "/User/RegisterController.php";
require_once CONTROLLER_PATH . "/User/GetAllUserController.php";
require_once CONTROLLER_PATH . "/User/GetFollowsController.php";
require_once CONTROLLER_PATH . "/User/GetPostCountController.php";
require_once CONTROLLER_PATH . "/User/GetPostDataController.php";
require_once CONTROLLER_PATH . "/Admin/AdminController.php";
require_once CONTROLLER_PATH . "/Admin/BanController.php";
require_once CONTROLLER_PATH . "/Admin/UnbanController.php";
require_once CONTROLLER_PATH . "/Admin/SetAdmin.php";
require_once CONTROLLER_PATH . "/Admin/DeleteUserController.php";
require_once CONTROLLER_PATH . "/Home/GetPostController.php";
require_once CONTROLLER_PATH . "/Home/LikeController.php";
require_once CONTROLLER_PATH . "/Home/GetPostIDController.php";
require_once CONTROLLER_PATH . "/Home/ReplyPostController.php";
require_once CONTROLLER_PATH . "/Home/GetReplyPostController.php";
require_once CONTROLLER_PATH . "/Home/ClickPostController.php";
require_once CONTROLLER_PATH . "/Home/ProfileController.php";
require_once CONTROLLER_PATH . "/Home/ProfileUserController.php";
require_once CONTROLLER_PATH . "/Home/FollowController.php";
require_once CONTROLLER_PATH . "/Home/UnfollowController.php";

require_once CONTROLLER_PATH . "/Page/HomePage.php";
require_once CONTROLLER_PATH . "/Page/LoginPage.php";
require_once CONTROLLER_PATH . "/Page/ComposePage.php";
require_once CONTROLLER_PATH . "/Page/SettingsPage.php";
require_once CONTROLLER_PATH . "/Page/AdminPage.php";
require_once CONTROLLER_PATH . "/Page/UserPage.php";
require_once CONTROLLER_PATH . "/Page/HomePage.php";
require_once CONTROLLER_PATH . "/Page/PostPage.php";
require_once CONTROLLER_PATH . "/Page/AdminPageUnban.php";
require_once CONTROLLER_PATH . "/Page/ProfilePage.php";


require_once MIDDLEWARE_PATH . "/CheckAdmin.php";
require_once MIDDLEWARE_PATH . "/CheckLogin.php";

session_start();
$router = new Router();

// $router->addHandler("/example", BaseController::getInstance(), [BaseMiddleware::getInstance()]);
$router->addHandler("/api/login", LoginController::getInstance(), []);
$router->addHandler("/api/logout", LogoutController::getInstance(), []);
$router->addHandler("/api/register", RegisterController::getInstance(), []);
$router->addHandler("/api/admin", AdminController::getInstance(), []);
$router->addHandler("/api/ban", BanController::getInstance(), []);
$router->addHandler("/api/unban", UnbanController::getInstance(), []);
$router->addHandler("/api/setadmin", SetAdminController::getInstance(), []);
$router->addHandler("/api/deleteuser", DeleteUserController::getInstance(), []);
$router->addHandler("/api/getpost/*", GetPostController::getInstance(), []);
$router->addHandler("/api/like", LikeController::getInstance(), []);
$router->addHandler("/api/getpostid/*/*", GetPostIDController::getInstance(), []);
$router->addHandler("/api/reply/*/*", ReplyPostController::getInstance(), []);
$router->addHandler("/api/getreply/*/*", GetReplyPostController::getInstance(), []);
$router->addHandler("/api/clickpost", ClickPostController::getInstance(), []);
$router->addHandler("/api/profile", ProfileController::getInstance(), []);
$router->addHandler("/api/profileuser/*", ProfileUserController::getInstance(), []);
$router->addHandler("/api/follow", FollowController::getInstance(), []);
$router->addHandler("/api/unfollow", UnfollowController::getInstance(), []);
$router->addHandler("/api/getalluser", GetAllUserController::getInstance(), []);
$router->addHandler("/api/getdatafollows/*/*", GetFollowsController::getInstance(), []);
$router->addHandler("/api/getpostcount/*", GetPostCountController::getInstance(), []);
$router->addHandler("/api/getpostdata/*/*/*", GetPostDataController::getInstance(), []);


$router->addHandler("/", HomePage::getInstance(), []);
$router->addHandler("/login", LoginPage::getInstance(), []);
$router->addHandler("/compose/kicau", ComposePage::getInstance(), [CheckLogin::getInstance()]);
$router->addHandler("/compose/create", PostController::getInstance(), [CheckLogin::getInstance()]);
$router->addHandler("/user", UserPage::getInstance(), []);
$router->addHandler("/settings/*", SettingsPage::getInstance(), [CheckLogin::getInstance()]);
$router->addHandler("/admin/*", AdminPage::getInstance(), [CheckAdmin::getInstance()]);
$router->addHandler("/admin/unban/*", AdminPageUnban::getInstance(), [CheckAdmin::getInstance()]);
$router->addHandler("/post/*/*", PostPage::getInstance(), []);
$router->addHandler("/profiles", ProfilePage::getInstance(), []);
$router->addHandler("/profiles/*", ProfilePage::getInstance(), []);



$router->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);