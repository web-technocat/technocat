<?php
//-----プロフィール編集-----//
//セッション開始
session_start();
//読み取り関数
include("../functions.php");
//セッション状態確認
check_session_id();
//エラー確認
if (
  !isset($_POST['hobby']) || $_POST['hobby'] == '' ||
  !isset($_POST['id']) || $_POST['id'] == ''
) {
  exit('paramError');
}
//値取得
$hobby = $_POST["hobby"];
$id = $_POST["id"];
//DB接続
$pdo = connect_to_db();
//SQL作成
$sql = "UPDATE profile_table SET hobby=:hobby, updated_at=now() WHERE id=:id";
//SQL準備
$stmt = $pdo->prepare($sql);
//バインド変数
$stmt->bindValue(':hobby', $hobby, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
//SQL実行
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
//TOPへ遷移
header("Location:../room_list.php");
exit();
