<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';


session_start();

// ランダムな文字列であるトークンをセッションに入れる。そして、トークンの文字列を$tokenに代入する。
$token = get_csrf_token();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}


$db = get_db_connect();
$user = get_login_user($db);

$items = get_open_items($db);

// <input type = "hidden" name="order_id" value="<?php print $history['order_id'] 
// 次回function.phpのget_post()を使ってみる(11/11のコメント)
 $order_id = get_post('order_id');

// $order_id = $_POST['order_id'];





if(is_admin($user) === FALSE) {
  $purchase_details = purchase_details($db, $order_id);
} else if(is_admin($user) === TRUE) {
  $purchase_details = purchase_details_admin($db, $order_id);
}
$sum_details = sum_details($purchase_details);


include_once VIEW_PATH . 'purchase_details_view.php';

