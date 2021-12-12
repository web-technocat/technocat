<!-- 新規登録ページ -->
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
  <title>アカウント作成</title>
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/miyuki.css">
</head>

<body>
  <div class="container">
    <div class="content">
      <form action="./user_create.php" method="POST">
        <h1>アカウント作成</h1>
        <br>

        <div class="control">
          <label for="username">ユーザー名</label>
          <input id="username" type="text" name="username">
        </div>

        <div class="control">
          <label for="email">メールアドレス<span class="required">必須</span></label>
          <input id="email" type="email" name="email">
        </div>

        <div class="control">
          <label for="password">パスワード<span class="required">必須</span></label>
          <input id="password" type="password" name="password">
        </div>

        <div class="control">
          <button type="submit" class="btn">新規登録</button>
        </div>
      </form>
      <div>
        <p>すでに登録済みの方は<a href="../login/login_form.php">こちら</a></p>
      </div>
    </div>
  </div>

</body>

</html>