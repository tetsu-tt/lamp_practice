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
