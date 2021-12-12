<?php
//-------退室処理(checkin_tableから削除）のphpです---------------------------------//

//セッションの開始
session_start();
//関数ファイル読み込み
include('functions.php');
//セッション状態の確認とセッションID再生成
check_session_id();

//ユーザーIDを取得
$user_id = $_SESSION["user_id"];

//DB接続
$pdo = connect_to_db();

//checkin_tableからユーザーIDが一致しているものを削除
$sql = "DELETE FROM checkin_table WHERE user_id =:user_id";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

//処理が終わったらroom_list.php(トークルーム一覧)へ移動
header("Location:room_list.php");
exit();

?>