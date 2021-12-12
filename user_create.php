<?php
// var_dump($_POST);
// exit();
//セッション開始
session_start();
//関数読み込み
include('./functions/dbconnect.php');


//-----バリデーション-----//
//エラーメッセージを格納する配列
$err = [];
//ユーザー名
if (!$username = $_POST['username']) {
  $err['username'] = 'ユーザー名を入力してください';
}
//メールアドレス
if (!$email = $_POST['email']) {
  $err['email'] = 'メールアドレスを記入してください';
}
//パスワード
//正規表現＋パスワードハッシュ
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
if (!preg_match("/\A[a-z\d]{8,100}+\z/i", $password)) {
  $err['password'] = 'パスワードは英数字8文字以上100文字以下にしてください';
}
//パスワード確認
$password_conf = $_POST['password_conf'];
if ($password !== $password_conf) {
  $err['password_conf'] = '確認用パスワードと異なっています';
}
//-----バリデーション終了-----//

//DB接続
$pdo = connect_to_db();

//-----フォームに入力されたmailが既に登録されていないかチェック-----//
//SQL作成
$sql = "SELECT * FROM users_table WHERE email = :email";
//SQL準備
$stmt = $pdo->prepare($sql);
//バインド変数
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
//SQL実行
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
//実行内容
$member = $stmt->fetch();
// var_dump($member);
// exit();

//メールアドレス確認
if ($member['email'] === $email) {
  //メッセージ表示
  $message = '<h1>同じメールアドレスが存在します<h1>';
  $link = '<a href="user_input.php"></a>';
}

//もしエラーの配列の中身が空だったら、ユーザー登録処理
if (count($err) === 0) {
  //SQL作成
  $sql = 'INSERT INTO users_table (id,username,email,password,is_admin,is_deleted,created_at,updated_at) VALUES(NULL,:username,:email,:password,0,0,now(),now())';
  //SQL準備
  $stmt = $pdo->prepare($sql);
  //バインド変数
  $stmt->bindValue(':username', $username, PDO::PARAM_STR);
  $stmt->bindValue(':email', $email, PDO::PARAM_STR);
  $stmt->bindValue(':password', $password, PDO::PARAM_STR);
  //SQL実行
  try {
    $status = $stmt->execute();
  } catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
  }
  //メッセージ表示
  $message = '<h1>会員登録完了しました</h1>';
  $link = '<a href="login_form">ログインページ</a>';
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <?= $message; ?>
  <?= $link; ?>
</body>

</html>