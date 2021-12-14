<?php

//仮のトークルームファイル
//退出ボタンを設置

//セッションの開始
session_start();
//関数ファイル読み込み
include('takeshi_functions.php');
//セッション状態の確認とセッションID再生成
check_session_id();


//<?=htmlspecialchars($hoge, ENT_QUOTES);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Talk Room</title>

  <!-- reset.css読み込み -->
  <link rel="stylesheet" href="./css/reset.css">
  <!-- takeshi.css読み込み -->
  <link rel="stylesheet" href="./css/takeshi.css">
</head>

<body>
  <div id="wrapper_y">
    <div class="main_contents">
      <a href="check_out.php">exit</a>



    </div>
    <!-- main_contentsここまで -->
  </div>
  <!--wrapperここまで -->

  <!-- jquery読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>

</html>