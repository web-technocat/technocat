<?php

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
$title = "CAN NOT ENTER";
//ユーザー名表示のための変数
$username = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>can not enter</title>

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

      <section id="not_found">
        <h1>満員です</h1>
        <a href="room_list.php" id="back_btn">戻る</a>
      </section>

    </div>
    <!-- main_contentsここまで -->

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