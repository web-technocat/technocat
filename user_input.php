<?php
// var_dump($_SESSION);

//セッション開始
session_start();
//エラー表示の変数を定義
$err = $_SESSION;

//エラーメッセージを消す（リロードすると消える処理）
$_SESSION = array();
session_destroy();
?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>新規登録</title>
</head>

<body>
  <!-- タイトル -->
  <h2>ユーザー登録フォーム</h2>

  <form action="./user_create.php" method="post">
    <!-- ユーザー名 -->
    <div>
      <label for="username">ユーザー名:</label>
      <input type="text" name="username">
      <!-- user_create.phpで定義した変数内にエラーがあれば表示 -->
      <?php if (isset($err)) : ?>
        <p><?= $err['username']; ?></p>
      <?php endif; ?>
    </div>
    <!-- メールアドレス -->
    <div>
      <label for="email">メールアドレス:</label>
      <input type="email" name="email">
      <!-- user_create.phpで定義した変数内にエラーがあれば表示 -->
      <?php if (isset($err)) : ?>
        <p><?= $err['email']; ?></p>
      <?php endif; ?>
    </div>
    <!-- パスワード -->
    <div>
      <label for="password">パスワード:</label>
      <input type="password" name="password">
      <!-- user_create.phpで定義した変数内にエラーがあれば表示 -->
      <?php if (isset($err)) : ?>
        <p><?= $err['password']; ?></p>
      <?php endif; ?>
    </div>
    <!-- パスワード確認 -->
    <div>
      <label for="password_conf">パスワード確認:</label>
      <input type="password" name="password_conf">
      <!-- user_create.phpで定義した変数内にエラーがあれば表示 -->
      <?php if (isset($err)) : ?>
        <p><?= $err['password_conf']; ?></p>
      <?php endif; ?>
    </div>
    <!-- 登録ボタン -->
    <div>
      <input type="submit" value="新規登録">
    </div>
  </form>
  <!-- ログインボタン -->
  <div>
    <p>すでに登録済みの方は<a href="./login_form.php">こちら</a></p>
  </div>
</body>

</html>