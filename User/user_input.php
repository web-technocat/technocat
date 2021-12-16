<!-- 新規登録ページ -->
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
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
  <title>アカウント作成</title>
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/miyuki.css">
  <link rel="stylesheet" href="../css/login.css">
</head>

<body>
  <div class="container">

    <div class="form-wrapper">
      <h1>Sign Up</h1>
      <form action="./user_create.php" method="POST">

        <div class="form-item">
          <label for="username"></label>
          <input type="text" name="username" required="required" placeholder="User Name"></input>
        </div>

        <div class="form-item">
          <label for="email"></label>
          <input type="email" name="email" required="required" placeholder="Email Address"></input>
        </div>

        <div class="form-item">
          <label for="password"></label>
          <input type="password" name="password" required="required" placeholder="Password"></input>
        </div>

        <div class="button-panel">
          <input type="submit" class="button" title="Sign Up" value="Sign Up"></input>
        </div>
      </form>
      <div class="form-footer">
        <p><a href="../login/login_form.php">Login</a></p>
      </div>
    </div>

</body>

</html>