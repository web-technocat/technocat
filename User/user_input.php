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
















    <!-- <div class="content">
      <form action="./user_create.php" method="POST">
        <h1>アカウント作成</h1>
        <br>

        <div class="control">
          <label for="username">ユーザー名</label>
          <input id="username" type="text" name="username">
          <!-- login.php PHP文で定義した変数内にエラーがあれば表示 -->
          <!-- <?php if (isset($err)) : ?>
            <p><?= $err['username']; ?></p>
          <?php endif; ?> -->
        </div>

        <div class="control">
          <label for="email">メールアドレス<span class="required">必須</span></label>
          <input id="email" type="email" name="email">
          <!-- login.php PHP文で定義した変数内にエラーがあれば表示 -->
          <!-- <?php if (isset($err)) : ?>
            <p><?= $err['email']; ?></p>
          <?php endif; ?> -->
        </div>

        <div class="control">
          <label for="password">パスワード<span class="required">必須</span></label>
          <input id="password" type="password" name="password">
          <!-- login.php PHP文で定義した変数内にエラーがあれば表示 -->
          <!-- <?php if (isset($err)) : ?>
            <p><?= $err['password']; ?></p>
          <?php endif; ?> -->
        </div>

        <div class="control">
          <button type="submit" class="btn">新規登録</button>
        </div>
      </form>
      <div>
        <p>すでに登録済みの方は<a href="../login/login_form.php">こちら</a></p>
      </div>
    </div>
  </div> -->

</body>

</html>