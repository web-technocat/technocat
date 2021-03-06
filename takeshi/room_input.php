<?php
//-------ルーム作成の入力画面です-------------------------------------//

//セッションの開始
session_start();
//関数ファイル読み込み
include('takeshi_functions.php');
//セッション状態の確認とセッションID再生成
check_session_id();
//セッションにroom_idがあればチャットルームへ
check_room_session_id();
//ユーザーIDを取得
$user_id = $_SESSION['user_id'];

// DB接続
$pdo = connect_to_db();


//タイトル表示のための変数
$title = "トークルーム作成";
//ユーザー名表示のための変数
$username = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>room input</title>

  <!-- reset.css読み込み -->
  <link rel="stylesheet" href="../css/reset.css">
  <!-- takeshi.css読み込み -->
  <link rel="stylesheet" href="./css/takeshi.css">
  <!-- line-awesome読み込み -->
  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>

<body>
  <div id="wrapper_y">

    <!-- ヘッダーの読み込み -->
    <?php include('header_takeshi.php'); ?>

    <div class="main_contents">

      <!-- 入力フォーム -->
      <form action="room_create.php" method="post">

        <!-- ルームネームを入力 -->
        <div>
          <p>トークルーム名</p>
          <input type="text" name="room_name" id="create_room" required>
        </div>

        <!-- 部屋のタイプを選択 -->
        <div id="select_type">
          <label><input type="radio" name="room_type" value="0">グループ</label>
          <label><input type="radio" name="room_type" value="1">プライベート</label>
        </div>

        <!-- 作成ボタン -->
        <button type="submit" id="room_create_btn">作成</button>

      </form>
    </div>
    <!--main_contentsここまで -->

    <!-- フッターの読み込み -->
    <?php include('footer_takeshi.php'); ?>

  </div>
  <!--wrapperここまで -->

  <!-- jquery読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!-- takeshi.js読み込み -->
  <script src="./js/takeshi.js"></script>

</body>

</html>