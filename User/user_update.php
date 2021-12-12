<?php
//-----ユーザー更新-----//
// //セッション開始
session_start();
//関数読み込み
include("functions.php");
// //セッション確認変数
check_session_id();
//エラー確認
if (
  !isset($_POST['username']) || $_POST['username'] == '' ||
  !isset($_POST['email']) || $_POST['email'] == '' ||
  !isset($_POST['password']) || $_POST['password'] == '' ||
  !isset($_POST['id']) || $_POST['id'] == ''
) {
  exit('paramError');
}
//値取得
$username = $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];
$id = $_POST["id"];
//DB接続
$pdo = connect_to_db();
//SQL作成
$sql = "UPDATE users_table SET username=:username,email=:email, password=:password, updated_at=now() WHERE id=:id";
//SQL準備
$stmt = $pdo->prepare($sql);
//バインド変数
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
//SQL実行
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
//ユーザーリストに遷移
header("Location:user_list.php");
exit();
