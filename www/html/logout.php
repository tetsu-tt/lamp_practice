<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';

session_start();
$_SESSION = array();
// session_get_cookie_params()で、セッションクッキーのパラメーターを得る
$params = session_get_cookie_params();
// session_name()で現在のセッション名を取得
setcookie(session_name(), '', time() - 42000,
  $params["path"], 
  $params["domain"],
  $params["secure"], 
  $params["httponly"]
);
session_destroy();

redirect_to(LOGIN_URL);

