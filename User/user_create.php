<!-- 新規登録確認ページ -->
<?php
// var_dump($_POST);
// exit();

//DB接続
include('functions.php');

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
// if (!$username = $_POST['username']) {
//   $err['username'] = 'ユーザー名を記入してください';
// }
//メールアドレス
$email = $_POST["email"];
// if (!$email = $_POST['email']) {
//   $err['email'] = 'メールアドレスを記入してください';
// }
//パスワード(正規表現を使う)
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
//正規表現
// if (!preg_match("/\A[a-z\d]{8,100}+\z/i", $password)) {
//   $err['password'] = 'パスワードは英数字8文字以上100文字以下にしてください';
// }

//DB接続
$pdo = connect_to_db();

//フォームに入力されたmailがすでに登録されていないかチェック
//SQL作成
$sql = 'SELECT COUNT(*) FROM users_table WHERE email=:email';
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
//メールアドレス重複処理
if ($stmt->fetchColumn() > 0) {
  echo '<p>同じメールアドレスが存在します．</p>';
  echo '<a href="user_input.php">戻る</a>';
  exit();
}


//ユーザー登録処理
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
echo 'ユーザー登録完了しました.';
echo '<br>';
echo '<a href="login_form.php">ログインページ</a>';
exit();
