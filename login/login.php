<!-- ログイン確認ページ -->
<?php
// var_dump($_POST);
// exit();

//セッション開始
session_start();
//関数読み込み
include('../functions.php');

//-----バリデーション-----//
//エラーメッセージ
$err = [];
//メールアドレス
if (!$email = $_POST['email']) {
  $err['email'] = 'メールアドレスを入力してください!!';
  //sessionは連想配列
}
//パスワード
if (!$password = $_POST['password']) {
  $err['password'] = 'パスワードを入力してください!!';
  //sessionは連想配列
};

//値取得
// $username = $_POST['email'];
// $password = $_POST['password'];

//DB接続
$pdo = connect_to_db();

//-----ログイン時にエラーがあった場合にログインフォームに表示-----//
if (count($err) > 0) {
  //エラーがあった場合
  //セッションにエラーメッセージを入れて、ログイン画面に戻す
  $_SESSION = $err;
  header('Location:../login/login_form.php');
  return; //処理を止める
};



//-----ログイン成功時の処理-----//
if (count($err) === 0) {
  //ログイン成功時の処理
  //SQL作成
  $sql = 'SELECT * FROM users_table WHERE email= :email';
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
  $val = $stmt->fetch(PDO::FETCH_ASSOC);
  //指定したハッシュがパスワードにマッチしているかチェック
  if(password_verify($_POST['password'],$val['password'])){
    $_SESSION = array();
    //user_id はログイン時にセッション変数に保存している値を使用する
    $_SESSION['user_id'] = $val['id'];
    $_SESSION['session_id'] = session_id();
    $_SESSION['is_admin'] = $val['is_admin'];
    $_SESSION['username'] = $val['username'];
    //管理者であれば、管理者専用画面に遷移
    if ($_SESSION['is_admin'] === '1') {
      header('Location:../User/user_list.php');
      exit();
    } else {
      //ユーザーであれば、マイページへ遷移
      header("Location:../Profile/profile_input.php");
      // header("Location:../room_list.php");
      exit();
    }
  }else{
    echo "<p>ログイン情報に誤りがあります</p>";
    echo "<a href=login_form.php>ログイン</a>";
    exit();
  }
}
