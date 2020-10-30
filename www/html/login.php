<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';

session_start();

// ランダムな文字列であるトークンをセッションに入れる。そして、トークンの文字列を$tokenに代入する。
$token = get_csrf_token();

if(is_logined() === true){
  redirect_to(HOME_URL);
}

include_once VIEW_PATH . 'login_view.php';