<?php
//-------ルーム作成の入力画面です-------------------------------------//

//セッションの開始
session_start();
//関数ファイル読み込み
include('functions.php');
//セッション状態の確認とセッションID再生成
check_session_id();


?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>room input</title>

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
        <h1>Room Input</h1>
      </header>

      <!-- ルーム一覧に戻る -->
      <a href="room_list.php">戻る</a>

      <!-- 入力欄 -->
      <form action="room_create.php" method="post">

        <!-- ルームネームを入力 -->
        <div>
          <p>Room Name</p>
          <input type="text" name="room_name">
        </div>

        <!-- 仮ログアウトボタン -->
        <a href="todo_logout.php">logout</a>

        <!-- 部屋のタイプを選択 -->
        <div>
          <input type="radio" name="room_type" value="0">ペア
          <input type="radio" name="room_type" value="1">グループ
        </div>

        <!-- 作成ボタン -->
        <button type="submit">作成</button>

      </form>
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