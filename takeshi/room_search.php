<?php
//---------検索用phpです--------------------------------------------//

//関数読み込み
include("takeshi_functions.php");
//入力ワードを受け取る
$search_word = $_GET["searchword"];
$search_type = $_GET["type"];

// var_dump($_GET);
// exit();

//DB接続
$pdo = connect_to_db();

if($search_type === '0'){
    //SQLの記述
    //room_table(x)とusers_table(y)とprofile_table(z)を結合
    //room_name,usernameから、search_wordに含まれているレコードを探す
    $sql = "SELECT x.id,room_name,room_type,host_user,username,image
    FROM  room_table as x LEFT JOIN users_table as y ON x.host_user = y.id 
    LEFT JOIN profile_table as z ON y.id = z.user_id 
    WHERE room_type = 0
    AND concat(room_name,username) LIKE :search_word";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':search_word', "%{$search_word}%", PDO::PARAM_STR);
    
    try {
      $status = $stmt->execute();
    } catch (PDOException $e) {
      echo json_encode(["sql error" => "{$e->getMessage()}"]);
      exit();
    }
  } else {
    //SQLの記述
    //room_table(x)とusers_table(y)とprofile_table(z)を結合
    //room_name,usernameから、search_wordに含まれているレコードを探す
    $sql = "SELECT x.id,room_name,room_type,host_user,username,image
    FROM  room_table as x LEFT JOIN users_table as y ON x.host_user = y.id 
    LEFT JOIN profile_table as z ON y.id = z.user_id 
    WHERE room_type = 1
    AND concat(room_name,username) LIKE :search_word";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':search_word', "%{$search_word}%", PDO::PARAM_STR);

    try {
      $status = $stmt->execute();
    } catch (PDOException $e) {
      echo json_encode(["sql error" => "{$e->getMessage()}"]);
      exit();
  }

}


//$resultに結果を取得
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$list = [];//jsonにするための変数を準備
foreach ($result as $record) {
  //エスケープ処理
  $id = htmlspecialchars($record['id'], ENT_QUOTES);
  $room_name = htmlspecialchars($record['room_name'], ENT_QUOTES);
  $room_type = htmlspecialchars($record['room_type'], ENT_QUOTES);
  $host_user = htmlspecialchars($record['host_user'], ENT_QUOTES);
  $username = htmlspecialchars($record['username'], ENT_QUOTES);
  $image = htmlspecialchars($record['image'], ENT_QUOTES);
  //$pushにまとめる
  $push = [
    'id' => $id,
    'room_name' => $room_name,
    'room_type' => $room_type,
    'host_user' => $host_user,
    'username' => $username,
    'image' => $image
  ];
  //$listにpush!
  array_push($list, $push);
}

// echo '<pre>';
// var_dump($list);
// echo '</pre>';
// exit();

// JavaScript側に $listをJSON形式にしてデータを送る
echo json_encode($list);
exit();

