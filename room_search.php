<?php
//---------検索用phpです--------------------------------------------//

//関数読み込み
include("functions.php");
//入力ワードを受け取る
$search_word = $_GET["searchword"]; 

//DB接続
$pdo = connect_to_db();

//SQLの記述
//room_table(x)とusers_table(y)を結合
//room_name,usernameから、search_wordに含まれているレコードを探す
$sql = "SELECT x.id,room_name,room_type,host_user,username
FROM  room_table as x LEFT JOIN users_table as y 
ON x.host_user = y.id WHERE concat(room_name,username) LIKE :search_word";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':search_word', "%{$search_word}%", PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

//$resultに結果を取得
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// JavaScript側に $resultをJSON形式にしてデータを送る
echo json_encode($result);
exit();