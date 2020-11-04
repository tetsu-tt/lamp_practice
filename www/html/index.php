<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';


session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

// get_db_connect関数の定義付けが行われているdb.phpの読み込みは、functions.phpで行われているためindex.phpでは必要ない
$db = get_db_connect();
$user = get_login_user($db);

$items = get_open_items($db);

// レッスン(10/27)
// ランダムな文字列であるトークンをセッションに入れる。そして、トークンの文字列を$tokenに代入する。
$token = get_csrf_token();


include_once VIEW_PATH . 'index_view.php';

