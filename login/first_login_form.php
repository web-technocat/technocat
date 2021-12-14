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
  <link rel="stylesheet" href="../css/login.css">
</head>

<body>
  <div class="container">
    <div class="form-wrapper">
      <h1>Sign In</h1>
      <form action="./first_login.php" method="POST">

        <div class="form-item">
          <label for="email"></label>
          <input type="email" name="email" required="required" placeholder="Email Address"></input>
          <!-- login.php PHP文で定義した変数内にエラーがあれば表示 -->
          <?php if (isset($err)) : ?>
            <p><?= $err['email']; ?></p>
          <?php endif; ?>
        </div>

        <div class="form-item">
          <label for="password"></label>
          <input type="password" name="password" required="required" placeholder="Password"></input>
          <!-- login.php PHP文で定義した変数内にエラーがあれば表示 -->
          <?php if (isset($err)) : ?>
            <p><?= $err['password']; ?></p>
          <?php endif; ?>
        </div>

        <div class="button-panel">
          <input type="submit" class="button" title="Sign In" value="Sign In"></input>
        </div>
      </form>
      <div class="form-footer">
        <p><a href="../User/user_input.php">Create an account</a></p>
      </div>
    </div>

</body>

</html>