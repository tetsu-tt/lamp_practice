<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
// get_db_connect() のあるファイル(db.php)の読み込みがされていないのはなぜ？

session_start();

//ログインできなければログインページに戻る
if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

// ログインできた場合にデータベースに接続する
$db = get_db_connect();

//ユーザー情報（ユーザー名やパスワード）を取得する 
$user = get_login_user($db);

// 管理者でなければログインページに飛ばす
if(is_admin($user) === false){
  redirect_to(LOGIN_URL);
}

// 商品一覧を取り出す
$items = get_all_items($db);
include_once VIEW_PATH . '/admin_view.php';
