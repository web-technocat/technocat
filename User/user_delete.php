<?php
//セッション開始
session_start();
//関数読み込み
include("../functions.php");
//セッション状態の確認
check_session_id();
//取得したIDを定義
$id = $_GET["id"];

// var_dump($id);
// exit();

//DB接続
$pdo = connect_to_db();
//SQL作成
//idが一致しているものを取得
$sql = "UPDATE users_table SET is_deleted = 1,updated_at = now(),WHERE id=:id";
// $sql="UPDATE users_table AS a JOIN profile_table AS b ON a.id = b.user_id SET a.is_deleted = 1, a.updated_at = now() WHERE a.id = :id";
//SQL準備
$stmt = $pdo->prepare($sql);
//バインド変数
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
//SQL実行
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
//ユーザ一覧画面へ
header("Location:user_list.php");
exit();
