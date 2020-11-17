<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';


session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}


$db = get_db_connect();
$user = get_login_user($db);

$items = get_open_items($db);




if(is_admin($user) === FALSE) {
    $purchase_history = get_purchase_history($db, $user);
} else if(is_admin($user) === TRUE) {
    $purchase_history = purchase_history_admin($db, $user);
}


include_once VIEW_PATH . 'purchase_history_view.php';

