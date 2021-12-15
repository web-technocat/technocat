<?php
//-------トークルームを作るPHPです---------------------------------//

//セッションの開始
session_start();
//関数ファイル読み込み
include('takeshi_functions.php');
//セッション状態の確認とセッションID再生成
check_session_id();


//データの入力確認
if (
  !isset($_POST['room_name']) || $_POST['room_name'] == '' ||
  !isset($_POST['room_type']) || $_POST['room_type'] == '' 
) {
  exit('ParamError'); //エラーを返す
}

//変数に代入
$user_id = $_SESSION['user_id'];
$room_name = $_POST['room_name'];
$room_type = $_POST['room_type'];

// DB接続
$pdo = connect_to_db(); //データベース接続の関数、$pdoに受け取る

//SQL 登録処理実行 
//room_tableに新規テーブルを作成 そのままcheckin_tableに登録
$sql = 'INSERT INTO room_table(id,room_name,room_type,created_at,host_user) 
VALUES(NULL,:room_name,:room_type,now(),:user_id);
INSERT INTO checkin_table(id,user_id,room_id) 
VALUES(NULL,:user_id,LAST_INSERT_ID())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':room_name',$room_name,PDO::PARAM_STR);
$stmt->bindValue(':room_type',$room_type, PDO::PARAM_STR);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

//checkin_tableからroom_idを取得
$sql = 'SELECT room_id FROM checkin_table WHERE user_id = :user_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$result = $stmt->fetch(PDO::FETCH_ASSOC);

//セッションにroom_idを渡す
$_SESSION['room_id'] = $result['room_id'];

//処理が終わったらチャットページに移動
header("Location:../rtchat.php");
exit();

?>