<!-- ログインページ -->
<?php
// var_dump($_SESSION);
session_start();
//エラー表示の変数を定義
$err = $_SESSION;
//sessionの中身(エラーメッセージ)を消す（リロードすると消える処理）
$_SESSION = array();
session_destroy();

?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログイン画面</title>
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/miyuki.css">
</head>

<body>
  <div class="container">
    <div class="content">
      <form action="./login.php" method="POST">
        <h1>ログインフォーム</h1>
        <br>

        <div class="control">
          <label for="email">メールアドレス</label>
          <input type="email" name="email">
          <!-- login.php PHP文で定義した変数内にエラーがあれば表示 -->
          <?php if (isset($err)) : ?>
            <p><?= $err['email']; ?></p>
          <?php endif; ?>
        </div>

        <div class="control">
          <label for="password">パスワード:</label>
          <input type="password" name="password">
          <!-- login.php PHP文で定義した変数内にエラーがあれば表示 -->
          <?php if (isset($err)) : ?>
            <p><?= $err['password']; ?></p>
          <?php endif; ?>
        </div>

        <div class="control">
          <button type="submit" class="btn">ログイン</button>
        </div>
    </div>
    </form>
    <p>新規登録の方は<a href="../User/user_input.php">こちら</a></p>
    <p>プロフィール登録の方は<a href="../Profile/profile_input.php">こちら</a></p>
  </div>

</body>

</html>