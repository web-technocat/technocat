<?php
//--------トークルームに入っている人の一覧ページです----------------

//ルームIDを取得
$room_id = $_GET['id'];

//セッションの開始
session_start();
//関数ファイル読み込み
include('functions.php');
//セッション状態の確認とセッションID再生成
check_session_id();

// DB接続
$pdo = connect_to_db();

//SQL処理 users_table(x)とroom_table(y)を結合して取得
$sql = 'SELECT x.id,room_name,room_type,host_user,username
FROM  room_table as x LEFT JOIN users_table as y 
ON x.host_user = y.id WHERE x.id = :room_id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':room_id', $room_id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

//$resultにデータを取得
$result = $stmt->fetch(PDO::FETCH_ASSOC);

//SQL処理 checkin_table(x)とusers_table(y)を結合して取得
$sql = 'SELECT x.room_id,y.username
FROM checkin_table as x LEFT JOIN users_table as y 
ON x.user_id = y.id where x.room_id = :room_id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':room_id', $room_id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

//$memberにデータを取得
$members = $stmt->fetchAll(PDO::FETCH_ASSOC);

// タグをつけて表示
foreach ($members as $member) {
  $member_list .= "
    <li>{$member['username']}</li>
  ";
}

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

      <!-- 仮戻るボタン -->
      <a href="room_list.php">戻る</a>

      <!-- ルーム詳細表示部分 -->
      <section id="room_infometion">
        <h1><?= $result['room_name'] ?></h1>
        <h2>host:<?= $result['username'] ?></h2>
      </section>

      <!-- ルームメンバー表示部分 -->
      <section id="join_member">
        <ul>
          <?= $member_list ?>
        </ul>
      </section>

      <!-- 入室ボタン部分 -->
      <form action="check_in.php" method="post">
        <!-- ルームナンバーを送るためのinput hidden -->
        <input type="hidden" name="room_id" value=<?= $result['id'] ?>>
        <!-- 入室ボタン Join! -->
        <button type="submit" id="join_btn">Join</button>
      </form>

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