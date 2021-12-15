<?php
//------入室処理(checkin_tableに登録）のphpです-------------------------------------//

//セッションの開始
session_start();
//関数ファイル読み込み
include('takeshi_functions.php');
//セッション状態の確認とセッションID再生成
check_session_id();


//ルームIDとユーザーIDを取得
$room_id = $_POST['room_id'];
$room_type = $_POST['room_type'];
$user_id = $_SESSION['user_id'];

// var_dump($room_type);
// exit();


// DB接続
$pdo = connect_to_db(); //データベース接続の関数、$pdoに受け取る

//もしプライベートルームであれば
if($room_type == '1'){
  
  $sql = 'SELECT COUNT(*) FROM checkin_table WHERE room_id = :room_id';

  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':room_id', $room_id, PDO::PARAM_STR);

  try {
    $status = $stmt->execute();
  } catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
  }

  if ($stmt->fetchColumn() > 1) {
    header("Location:full.php");
    exit();
  }
}

//SQL checkin_tableへ登録処理
$sql = 'INSERT INTO checkin_table(id,user_id,room_id) VALUES(NULL,:user_id,:room_id)';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':room_id', $room_id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

//セッションにルームIDを渡す
$_SESSION['room_id'] = $room_id;

//処理が終わった後はチャットページへ移動
header("Location:../rtchat.php");
exit();


?>