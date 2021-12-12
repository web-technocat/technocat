<?php
//-------トークルーム一覧のページです-----------------------------------------//

//セッションの開始
session_start();
//関数ファイル読み込み
include('functions.php');
//セッション状態の確認とセッションID再生成
check_session_id();

// DB接続
$pdo = connect_to_db(); //データベース接続の関数、$pdoに受け取る

//SQL処理 room_tableから情報取得
$sql = 'SELECT * FROM room_table INNER JOIN users_table ON room_table.host_user = users_table.id ORDER BY room_table.created_at DESC';
$stmt = $pdo->prepare($sql);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// echo '<pre>';
// var_dump($result);
// echo '</pre>';
// exit();

//繰り返し処理を用いて，取得したデータから HTML タグを生成する
$output = ""; //表示のための変数を定義
foreach ($result as $record) {
  $output .= "
    <a href=member_list.php?id={$record["id"]}><li>{$record["room_name"]} type:{$record["room_type"]} host:{$record["username"]}</li></a>
  ";
}


?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>room list</title>

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
        <h1>Room List</h1>
      </header>

      <!-- 仮ログアウトボタン -->
      <a href="todo_logout.php">logout</a>

      <!-- 検索部分 -->
      <section>
        <form action="">
          <input type="text">
          <button>serch</button>
        </form>
      </section>

      <!-- ルーム追加ボタン -->
      <section>
        <div>
          <a href="room_input.php">作成ボタン</a>
        </div>
      </section>

      <!-- トークルーム一覧出力部分 -->
      <section id="room_section">
        <ul id="room_list">
          <?= $output?>
          <ul>
      </section>

    </div>
    <!--main_contentsここまで -->

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