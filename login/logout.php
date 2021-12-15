<?php
//-----ログアウト-----//
// var_dump($_POST);
// exit();

//セッション開始
session_start();

//セッション情報を削除
$_SESSION = array();
//ブラウザに保存した情報の有効期限を扱う
if (isset($_COOKIE[session_name()])) {
  setcookie(session_name(), '', time() - 42000, '/');
}
//セッションを破壊
session_destroy();
//ログイン画面へ遷移
header('Location:login_form.php');
exit();
