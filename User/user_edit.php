<?php
//-----ユーザー編集-----//
//セッション開始
session_start();
//関数読み込み
include("../functions.php");
//セッション確認変数
check_session_id();

// var_dump($_GET);
// exit();

//取得したidを定義
$id = $_GET["id"];

//DB接続
$pdo = connect_to_db();

//SQL作成
//idが一致しているものを取得
$sql = 'SELECT * FROM users_table WHERE id=:id';
//SQL準備
$stmt = $pdo->prepare($sql);
//バインド変数
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
//SQL実行
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
//SQL実行内容
$record = $stmt->fetch(PDO::FETCH_ASSOC);

//取得したデータ確認
// echo '<pre>';
// var_dump($record);
// echo '</pre>';
// exit();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザーリスト（編集画面）</title>
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/miyuki.css">
  <link rel="stylesheet" href="../css/login.css">
</head>

<body>
  <div class="container">

    <div class="form-wrapper">
      <h1>Account Edit</h1>
      <form action="./user_update.php" method="POST">

        <div class="form-item">
          <label for="username">UserName</label>
          <input type="text" name="username" required="required" placeholder="User Name" value="<?= $record['username'] ?>"></input>
        </div>

        <div class="form-item">
          <label for="email">Email</label>
          <input type="email" name="email" required="required" placeholder="Email Address" value="<?= $record['email'] ?>"></input>
        </div>

        <div class="form-item">
          <label for="password">Password</label>
          <input type="password" name="password" required="required" placeholder="Password" value="<?= $record['password'] ?>"></input>
        </div>

        <div class="button-panel">
          <input type="submit" class="button" title="Edit Account" value="Edit"></input>
        </div>

        <!-- 次の更新処理でidが必要になるため，<input type="hidden">を用いてidを送信する． -->
        <input type="hidden" name="id" value="<?= $record['id'] ?>">
      </form>
      <div class="form-footer">
        <p><a href="./user_list.php">List Display</a></p>
      </div>

    </div>
  </div>
</body>

</html>