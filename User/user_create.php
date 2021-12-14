<!-- 新規登録確認ページ -->
<?php
// var_dump($_POST);
// exit();

//セッション開始
session_start();
//関数読み込み
include('../functions.php');

//入力項目のチェック
if (
  !isset($_POST['username']) || $_POST['username'] == '' ||
  !isset($_POST['email']) || $_POST['email'] == '' ||
  !isset($_POST['password']) || $_POST['password'] == ''
) {
  echo json_encode(["error_msg" => "no input"]);
  exit();
}

//データの受け取り
$username = $_POST["username"];
$email = $_POST["email"];
$password = password_hash($_POST["password"], PASSWORD_DEFAULT);


//-----バリデーション-----//
// //エラーメッセージ
// $err = [];
// //ユーザーネーム
// if (!$username = $_POST['username']) {
//   $err['username'] = 'ユーザー名を入力してください!!';
// }
// //メールアドレス
// if (!$email = $_POST['email']) {
//   $err['email'] = 'メールアドレスを入力してください!!';
//   //sessionは連想配列
// }
// //パスワード
// $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
// if (!$password = $_POST['password']) {
//   $err['password'] = 'パスワードを入力してください!!';
//   //sessionは連想配列
// };

//-----新規登録時にエラーがあった場合に新規登録フォームに表示-----//
// if (count($err) > 0) {
//   //エラーがあった場合
//   //セッションにエラーメッセージを入れて、ログイン画面に戻す
//   $_SESSION = $err;
//   header('Location:user_input.php');
//   return; //処理を止める
// };

//DB接続
$pdo = connect_to_db();

//フォームに入力されたmailがすでに登録されていないかチェック
//SQL作成
$sql = 'SELECT * FROM users_table WHERE email=:email';
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
// 実行内容
$member = $stmt->fetch(PDO::FETCH_ASSOC);

if ($member['email'] === $email) {
  $message = "<p>同じメールアドレスが存在します．</p>";
  $link = "<a href=user_input.php class=button>戻る</a>";
}

//ユーザー登録処理
// if (count($err) === 0) {
//SQL作成
$sql = 'INSERT INTO users_table (id,username,email,password,is_admin,is_deleted,created_at,updated_at) VALUES(NULL,:username,:email,:password,0,0,now(),now())';
//SQl準備
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
// var_dump($status);
// exit();
$message = "<p>ユーザー登録<br>完了しました</p>";
$link = "<a href=../login/first_login_form.php class=button>ログインページ</a>";
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
    <?= $message ?>
    <?= $link ?>
  </div>
</body>

</html>