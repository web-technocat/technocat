<?php
//--------トークルームに入っている人の一覧ページです----------------

$room_id = $_GET['id'];

//セッションの開始
session_start();
//関数ファイル読み込み
include('functions.php');
//セッション状態の確認とセッションID再生成
check_session_id();

// DB接続
$pdo = connect_to_db(); //データベース接続の関数、$pdoに受け取る

//SQL処理 room_tableから情報取得
$sql = 'SELECT * FROM room_table INNER JOIN users_table ON room_table.host_user = users_table.id WHERE room_table.id = :room_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':room_id', $room_id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$result = $stmt->fetch(PDO::FETCH_ASSOC);

// echo '<pre>';
// var_dump($result);
// echo '</pre>';
// exit();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>member list</title>

  <!-- reset.css読み込み -->
  <link rel="stylesheet" href="./css/reset.css">
  <!-- takeshi.css読み込み -->
  <link rel="stylesheet" href="./css/takeshi.css">

</head>

<body>
  <div id="wrapper_y">
    <div class="main_contents">
      <!-- ヘッダー部分 -->
      <header>
        <h1>Member List</h1>
      </header>

      <!-- 仮ログアウトボタン -->
      <a href="todo_logout.php">logout</a>

      <!-- ルーム詳細表示部分 -->
      <section id="room_infometion">
        <h1><?= $result['room_name'] ?></h1>
        <h2>host:<?= $result['username'] ?></h2>
      </section>

      <!-- ルームメンバー表示部分 -->


      <!-- 入室ボタン -->
      <a href="check_in.php?room_id=<?=$result['room_table.id']?><button type="submit" id="join_btn">Join</button></a>

    </div>
    <!-- main_contentsここまで -->

    <!-- フッター部分 -->
    <footer class="footer_y">
      <div id="footer_contents">
        <div class="footer_btn">ボタン1</div>
        <div class="footer_btn">ボタン2</div>
        <div class="footer_btn">ボタン3</div>
      </div>
    </footer>
    <!-- フッター部分ここまで -->

  </div>
  <!--wrapperここまで -->

  <!-- jquery読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</body>

</html>