<?php
//-----プロフィール登録-----//
// //セッション開始
session_start();
// //関数読み込み
include("functions.php");
// //セッション状態確認
check_session_id();
//ログイン中のユーザー確認
$user_id = $_SESSION['user_id'];

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>プロフィール入力画面</title>
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/miyuki.css">
</head>



<body>
  <div class="container">
    <div class="content">
      <form action="./profile_create.php" method="POST" enctype="multipart/form-data">
        <h1>プロフィール入力画面</h1>
        <br>

        <div class="control">
          <label for="gender">性別</label>
          <input id="gender" type="radio" name="gender" value="0">男性
          <input id="gender" type="radio" name="gender" value="1">女性
        </div>

        <div class="control">
          <label for="birth">生年月日</label>
          <input id="birth" type="date" name="birth">
        </div>

        <div class="control">
          <label for="country">国籍</label>
          <input id="birth" type="date" name="birth">
        </div>

        <div class="control">
          <label for="hobby">趣味</label>
          <input id="hobby" type="text" name="hobby">
        </div>

        <div class="control">
          <label for="upfile">プロフィール画像</label>
          <input id="upfile" type="file" name="upfile" accept="image/*" capture="camera">
        </div>
    </div>
  </div>

  <!-- ユーザーIDを取得しておく部分 -->
  <input type="hidden" name="user_id" value=<?= $user_id ?>>
  <div>
    <input type="submit" value="登録">
  </div>
  </form>
  <a href="../room_list.php">マイページ</a>
  <a href="../login/logout.php">logout</a>
</body>

</html>