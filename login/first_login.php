<?php
// var_dump($_POST);
// exit();

//セッション開始
session_start();
//関数読み込み
include('../functions.php');

//-----バリデーション-----//
//エラーメッセージ
// $err = [];
//メールアドレス
// if (!$email = $_POST['email']) {
//   $err['email'] = 'メールアドレスを入力してください!!';
//   //sessionは連想配列
// }
// //パスワード
// if (!$password = $_POST['password']) {
//   $err['password'] = 'パスワードを入力してください!!';
//   //sessionは連想配列
// };
$email = $_POST['email'];
$password = $_POST['password'];
//DB接続
$pdo = connect_to_db();

//-----ログイン時にエラーがあった場合にログインフォームに表示-----//
// if (count($err) > 0) {
//   //エラーがあった場合
//   //セッションにエラーメッセージを入れて、ログイン画面に戻す
//   $_SESSION = $err;
//   header('Location:../login/first_login_form.php');
//   return; //処理を止める
// };

//-----ログイン成功時の処理-----//
// if (count($err) === 0) {
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
  if (password_verify($_POST['password'], $val['password'])) {
    $_SESSION = array();
    //user_id はログイン時にセッション変数に保存している値を使用する
    $_SESSION['user_id'] = $val['id'];
    $_SESSION['session_id'] = session_id();
    $_SESSION['is_admin'] = $val['is_admin'];
    $_SESSION['username'] = $val['username'];
    //管理者であれば、管理者専用画面に遷移
    if ($_SESSION['is_admin'] === '1') {
      $url = 'https://technocat.lolipop.io/User/user_list.php';
      header("Location:" . $url);
      exit();
    } else {
      //ユーザーであれば、マイページへ遷移
      $url = 'https://technocat.lolipop.io/Profile/profile_input.php';
      header("Location:" . $url);
      exit();
    }
  }
  // } else {
  //   echo "<p>ログイン情報に誤りがあります</p>";
  //   echo "<a href=first_login_form.php>ログイン</a>";
  //   exit();
  // }
// }

?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/miyuki.css">
  <style>
    .container {
      text-align: center;
      padding-top: 300px;
    }

    p {
      font-weight: bold;
      font-size: 40px;
      line-height: 1.15;
      height: 115px;
    }

    .button {
      display: inline-block;
      border-radius: 5%;
      /* 角丸       */
      font-size: 18pt;
      /* 文字サイズ */
      text-align: center;
      /* 文字位置   */
      cursor: pointer;
      /* カーソル   */
      padding: 12px 12px;
      /* 余白       */
      background: #000066;
      /* 背景色     */
      color: #ffffff !important;
      /* 文字色     */
      line-height: 1em;
      /* 1行の高さ  */
      transition: .3s;
      /* なめらか変化 */
      box-shadow: 6px 6px 3px #666666;
      /* 影の設定 */
      border: 2px solid #000066;
      /* 枠の指定 */
    }

    .button:hover {
      box-shadow: none;
      /* カーソル時の影消去 */
      color: #000066 !important;
      /* 背景色     */
      background: #ffffff;
      /* 文字色     */
    }
  </style>
</head>

<body>
  <div class="container">
    <?php if (!password_verify($_POST['password'], $val['password'])) : ?>
      <p>ログイン情報に<br>誤りがあります</p>
      <a href="./first_login_form.php" class="button">ログイン</a>
    <?php endif ?>
  </div>
</body>

</html>