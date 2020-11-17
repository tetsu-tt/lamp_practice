<?php

// わからないコード
function dd($var){
  var_dump($var);
  exit();
}

function redirect_to($url){
  header('Location: ' . $url);
  exit;
}

function get_get($name){
  if(isset($_GET[$name]) === true){
    return $_GET[$name];
  };
  return '';
}

// 次回復習する(11/16実施予定)
function get_post($name){
  if(isset($_POST[$name]) === true){
    return $_POST[$name];
  };
  return '';
}

// ファイルの名前を取得する
function get_file($name){
  if(isset($_FILES[$name]) === true){
    return $_FILES[$name];
  };
  return array();
}

// ユーザーidが正しければ、ユーザーidを出力。
// この関数は$nameの値がABCの時
// $_SESSION['ABC']が存在すれば$_SESSION['ABC']を返す。
// $_SESSION['ABC']が存在しなければ空文字を返す。
function get_session($name){
  if(isset($_SESSION[$name]) === true){
    return $_SESSION[$name];
  };
  return '';
}

// セッションに変数を代入する
function set_session($name, $value){
  $_SESSION[$name] = $value;
}

function set_error($error){
  $_SESSION['__errors'][] = $error;
}

function get_errors(){
  $errors = get_session('__errors');
  if($errors === ''){
    return array();
  }
  set_session('__errors',  array());
  return $errors;
}

function has_error(){
  return isset($_SESSION['__errors']) && count($_SESSION['__errors']) !== 0;
}

function set_message($message){
  $_SESSION['__messages'][] = $message;
}

function get_messages(){
  $messages = get_session('__messages');
  if($messages === ''){
    return array();
  }
  set_session('__messages',  array());
  return $messages;
}

// ユーザーidが正しいかチェック
//理解が曖昧
function is_logined(){
  return get_session('user_id') !== '';
}

function get_upload_filename($file){
  if(is_valid_upload_image($file) === false){
    return '';
  }
  $mimetype = exif_imagetype($file['tmp_name']);
  $ext = PERMITTED_IMAGE_TYPES[$mimetype];
  return get_random_string() . '.' . $ext;
}

function get_random_string($length = 20){
  return substr(base_convert(hash('sha256', uniqid()), 16, 36), 0, $length);
}

function save_image($image, $filename){
  return move_uploaded_file($image['tmp_name'], IMAGE_DIR . $filename);
}

function delete_image($filename){
  if(file_exists(IMAGE_DIR . $filename) === true){
    unlink(IMAGE_DIR . $filename);
    return true;
  }
  return false;
  
}


function is_valid_length($string, $minimum_length, $maximum_length = PHP_INT_MAX){
  // 関数内の変数string
  $length = mb_strlen($string);
  return ($minimum_length <= $length) && ($length <= $maximum_length);
}

function is_alphanumeric($string){
  return is_valid_format($string, REGEXP_ALPHANUMERIC);
}

function is_positive_integer($string){
  // 関数内の変数$string
  return is_valid_format($string, REGEXP_POSITIVE_INTEGER);
}

function is_valid_format($string, $format){
  return preg_match($format, $string) === 1;
}


function is_valid_upload_image($image){
  if(is_uploaded_file($image['tmp_name']) === false){
    set_error('ファイル形式が不正です。');
    return false;
  }
  $mimetype = exif_imagetype($image['tmp_name']);
  if( isset(PERMITTED_IMAGE_TYPES[$mimetype]) === false ){
    set_error('ファイル形式は' . implode('、', PERMITTED_IMAGE_TYPES) . 'のみ利用可能です。');
    return false;
  }
  return true;
}

// 教科書の課題で実施したもの
function h($str){
  return htmlspecialchars($str,ENT_QUOTES,'UTF-8');
}


// 10/27更新
// トークンの生成
// 正確に言葉にする(10/27)
function get_csrf_token(){
  // get_random_string()はユーザー定義関数。30字のランダムな文字列を作成する。
  $token = get_random_string(30);
  // set_session()はユーザー定義関数。トークンのランダムな文字列を$_SESSION['csrf']に代入する
  set_session('csrf_token', $token);
  // トークンの出力
  return $token;
}


function is_valid_csrf_token($token){
  if($token === '') {
    return false;
  }

  // get_session()の引数がcsrf_tokenなので
  // $_SESSION['csrf_token']が存在すれば$_SESSION['csrf_token']を返す。
  // $_SESSION['csrf_token']が存在しなければ空文字を返す。
  return $token === get_session('csrf_token');
  // 等しければtrueを返す
  // return $token === $_SESSION['csrf_token'];
}


// 11/11の試み(購入履歴の取得)
function get_purchase_history($db, $user) {

        $sql = "SELECT purchase_history.order_id, purchase_date, SUM(price*amount)
                FROM purchase_history
                INNER JOIN purchase_details
                ON purchase_history.order_id = purchase_details.order_id
                WHERE purchase_history.user_id = ?
                GROUP BY purchase_history.order_id";
          
        //purchase_historyのSQL文を実行する準備と実行を行う
        return fetch_all_query($db, $sql, [$user['user_id']]);
}


// 11/11の試み（管理者から購入履歴を見る場合→全てのユーザーの購入履歴の取得）
// 11/16の試み（第２引数に$userが必要か確認する）
function purchase_history_admin($db, $user) {

  $sql = "SELECT purchase_history.order_id, purchase_date, SUM(price*amount)
          FROM purchase_history
          INNER JOIN purchase_details
          ON purchase_history.order_id = purchase_details.order_id
          GROUP BY purchase_history.order_id";
    
  //purchase_historyのSQL文を実行する準備と実行を行う
  // 第３引数と？を結び付ける必要がないので、３つ目の引数はいらない（レッスン）
  return fetch_all_query($db, $sql);
}


//  購入明細画面のSQL文「商品名」「購入時の商品価格」 「購入数」「小計」(11/16の試み)
function purchase_details($db, $order_id) {

     $sql =  "SELECT name, price, amount, purchase_date, price*amount
              FROM purchase_details
              INNER JOIN purchase_history
              ON purchase_details.order_id = purchase_history.order_id
              WHERE purchase_history.order_id = ?";    
     
     //purchase_detailsのSQL文を実行する準備と実行を行う
      return fetch_all_query($db, $sql, [$order_id]);


}

// 購入明細画面のSQL文「該当の注文の合計金額」
function sum_details($purchase_details){
  $total_price = 0;
  foreach($purchase_details as $purchase_detail){
    $total_price += $purchase_detail['price'] * $purchase_detail['amount'];
  }
  return $total_price;
}

// 購入明細画面のSQL文「商品名」「購入時の商品価格」 「購入数」「小計」（管理者用）(11/16の試み)
function purchase_details_admin($db,$order_id){
$sql =   "SELECT name, price, amount,purchase_date, price*amount
          FROM purchase_details
          INNER JOIN purchase_history
          ON purchase_details.order_id = purchase_history.order_id
          WHERE purchase_history.order_id = ?";
//purchase_details_adminのSQL文を実行する準備と実行を行う
return fetch_all_query($db, $sql, [$order_id]);
}