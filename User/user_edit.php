<?php
//-----ユーザー編集-----//
//セッション開始
session_start();
//関数読み込み
include("functions.php");
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
</head>

<body>
  <div class="container">
    <div class="content">
      <form action="./user_update.php" method="POST">
        <h1>アカウント情報</h1>
        <br>

        <div class="control">
          <label for="username">ユーザー名</label>
          <input id="username" type="text" name="username" value="<?= $record['username'] ?>">
        </div>

        <div class="control">
          <label for="email">メールアドレス<span class="required">必須</span></label>
          <input id="email" type="email" name="email" value="<?= $record['email'] ?>">
        </div>

        <div class="control">
          <label for="password">パスワード<span class="required">必須</span></label>
          <input id="password" type="password" name="password" value="<?= $record['password'] ?>">
        </div>

        <div class="control">
          <button type="submit" class="btn">更新</button>
        </div>
        <!-- 次の更新処理でidが必要になるため，<input type="hidden">を用いてidを送信する． -->
        <input type="hidden" name="id" value="<?= $record['id'] ?>">
      </form>
      <div>
        <a href="./user_list.php">一覧画面</a>
      </div>
    </div>
  </div>
</body>

</html>