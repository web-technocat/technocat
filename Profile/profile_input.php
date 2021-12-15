<?php

//-----プロフィール登録-----//
// //セッション開始
session_start();
// //関数読み込み
include("../functions.php");
//セッション状態確認
check_session_id();

//ログイン中のユーザー確認
$user_id = $_SESSION['user_id'];

// var_dump($_SESSION['user_id']);
// exit();



?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>プロフィール入力画面</title>
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/miyuki.css">
  <style>
    .container {
      text-align: center;
    }

    .control {
      margin-bottom: 15px;
    }

    form {
      padding-top: 150px;
    }

    label {
      font-weight: bold;
      margin-bottom: 10px;
    }
  </style>
</head>



<body>
  <div class="container">

    <div class="content">
      <form action="./profile_create.php" method="POST" enctype="multipart/form-data">
        <h1>Profile Create</h1>
        <br>

        <div class="control">
          <label for="gender">Gender</label><br>
          <input id="gender" type="radio" name="gender" value="0">Gentleman
          <input id="gender" type="radio" name="gender" value="1">Lady
        </div>

        <div class="control">
          <label for="birth">Birth Day</label><br>
          <input id="birth" type="date" name="birth" value="2021-01-01">
        </div>

        <div class="control">
          <label for="language">Language</label><br>
          <input id="language" type="radio" name="language" value="0">日本語
          <input id="language" type="radio" name="language" value="1">英語
        </div>

        <div class="control">
          <label for="hobby">Hobby</label><br>
          <input id="hobby" type="text" name="hobby">
        </div>

        <div class="control">
          <label for="upfile">Profile Image</label><br>
          <input id="upfile" type="file" name="upfile" accept="image/*" capture="camera">
        </div>

        <div class="control">
          <label for="self_introduction">Self Introduction</label><br>
          <textarea id="self_introduction" name="self_introduction" cols="30" rows="5"></textarea>
        </div>

        <div>
          <input type="submit" value="Register" class="submit">
        </div>
        <a href="../takeshi/room_list.php">マイページ</a>
        <a href="../login/logout.php">logout</a>
        <!-- ユーザーIDを取得しておく部分 -->
        <input type="hidden" name="user_id" value=<?= $user_id ?>>
      </form>
    </div>
  </div>



</body>

</html>