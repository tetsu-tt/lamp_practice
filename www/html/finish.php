<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';

session_start();

$token = $_POST['csrf_token'];

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();

// user_id, name, password,typeの取得
$user = get_login_user($db);

// item_id,amount,price,nameも取得している
$carts = get_user_carts($db, $user['user_id']);
// var_dump($carts[0]);


// 購入日時(11/4更新)
$purchase_date = date('Y-m-d H:i:s');


// 11/4更新
// is_valid_csrf_token()はtokenが一致した場合はtrueを返す。
// tokenが一致しなかった場合はfalseを返す。
if (is_valid_csrf_token($token) !== false){
    if(purchase_carts($db, $carts) === false){
      set_error('商品が購入できませんでした。');
      redirect_to(CART_URL);

    // コード入れてみて動けば関数にしてみる(トランザクションは一旦無視)11/4、SQL文の実行
    // 最終課題のadmin.php参考に入力中
  } else {
          // 11/6の試み
          // try{
              // トランザクション開始
              // $dbh ->beginTransaction();

              //purchase_historyのinsert処理開始
              //purchase_historyのSQL文を作成する
              $sql = 'INSERT INTO purchase_history (user_id, purchase_date) VALUES(?, ?)';
          
              //purchase_historyのSQL文を実行する準備と実行を行う
              // return execute_query($db, $sql, [$user['user_id'], $purchase_date])だとそこで、処理が終了されてしまう（レッスン）
              execute_query($db, $sql, [$user['user_id'], $purchase_date]);

              //最後にinsertされたorder_id(MySQL)を取得
              $order_id = $db->lastInsertId('order_id');


              //purchase_detailsのinsert処理開始
              //purchase_detailsのSQL文を作成する
              $sql = "INSERT INTO purchase_details (order_id, item_id, amount, name, price) VALUES(?, ?, ?, ?, ?)";
              
              //purchase_detailsのSQL文を実行する準備と実行を行う
              // 二重の配列を一重の配列にする
              foreach ($carts as $cart){
              execute_query($db, $sql, [$order_id, $cart['item_id'], $cart['amount'], $cart['name'], $cart['price']]);
              } 
          
              // トランザクション終了
              // $dbh->commit();
            // } catch (PDOException $e) {
              // $dbh->rollback();
              // throw $e;
            // }
  }
}

// 11/4更新
// user_id,purchase_date,item_id,amount,price,nameをテーブルに書き出す必要がある。


$total_price = sum_carts($carts);

include_once '../view/finish_view.php';