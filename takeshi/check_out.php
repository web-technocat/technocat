<?php
//-------退室処理(checkin_tableから削除）のphpです---------------------------------//

//セッションの開始
session_start();
//関数ファイル読み込み
include('takeshi_functions.php');
//セッション状態の確認とセッションID再生成
check_session_id();

//セッションからユーザーIDを取得
$user_id = $_SESSION['user_id'];
//セッションからルームIDを取得
$room_id = $_SESSION['room_id'];

//DB接続
$pdo = connect_to_db();

//checkin_tableからユーザーIDが一致しているものを削除
$sql = 'DELETE FROM checkin_table WHERE user_id =:user_id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

//checkin_tableの同じルームidのレコード数をカウント
$sql = 'SELECT COUNT(*) FROM checkin_table WHERE room_id = :room_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':room_id', $room_id, PDO::PARAM_INT);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

// var_dump($room_id);
// exit();

//詰みポイント！！！！！！！！！！！！！

//room_idが一致するレコード数（入室者数）が0以上でなければ、room_tableから削除
if (!$stmt->fetchColumn() > 0) {
  // var_dump($room_id);
  // exit();

  $sql = "DELETE FROM room_table WHERE id = '" . $room_id . "'";
  $stmt = $pdo->prepare($sql);
  //$stmt->bindValue(':room_id', $room_id, PDO::PARAM_INT);
  try {
    $status = $stmt->execute();
  } catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
  }

}

//セッションのroom_idを削除
unset($_SESSION['room_id']);

//処理が終わったらroom_list.php(トークルーム一覧)へ移動
header("Location:room_list.php");
exit();

?>