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

//取得したidを定義(編集,削除などに使う)
$id = $_GET["id"];
// var_dump($id);
// exit();

//ログイン状態のユーザー確認
$user_id = $_SESSION['user_id'];
// var_dump($user_id);
// exit();

//DB接続
$pdo = connect_to_db();

//SQL作成
//idが一致しているものを取得
$sql = 'SELECT * FROM profile_table WHERE user_id=:user_id';
//SQL準備
$stmt = $pdo->prepare($sql);
//バインド変数
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
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
  <title>プロフィール編集画面</title>
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
      font-size: 15px;
      font-weight: bold;
      margin-bottom: 10px;
    }
  </style>
</head>

<body>
  <div class="container">
    <form action="profile_update.php" method="POST" enctype="multipart/form-data">
      <h1>Profile Edit</h1>
      <br>

      <div class="control">
        <label for="gender">Gender</label>
        <!-- 三項演算子（genderが0→男性にchecked） -->
        <input id="gender" type="radio" name="gender" value="0" <?= $record['gender'] == 0 ? 'checked' : ''; ?> disabled>Gentleman
        <!-- 三項演算子（genderが1→女性にchecked） -->
        <input id="gender" type="radio" name="gender" value="1" <?= $record['gender'] == 1 ? 'checked' : ''; ?> disabled>Lady
      </div>

      <div class="control">
        <label for="birth">Birth Day</label>
        <input id="birth" type="date" name="birth" value="<?= $record['birth'] ?>" disabled">
      </div>

      <div class="control">
        <label for="language">Language</label>
        <!-- 三項演算子（languageが0→日本語にchecked） -->
        <input id="language" type="radio" name="language" value="0" <?= $record['language'] == 0 ? 'checked' : ''; ?>>Japanese
        <!-- 三項演算子（languageが1→英語にchecked） -->
        <input id="language" type="radio" name="language" value="1" <?= $record['language'] == 1 ? 'checked' : ''; ?>>English
      </div>

      <div class="control">
        <label for="hobby">Hobby</label>
        <input id="hobby" type="text" name="hobby" value="<?= $record['hobby'] ?>">
      </div>

      <div class="control">
        <label for="upfile">Profile Image</label><br>
        <img src="<?= $record['image'] ?>" alt="" width="100px" height="100px" style=border-radius:50%;><br>
        <input id="upfile" type="file" name="upfile" accept="image/*" capture="camera">
      </div>

      <div class="control">
        <label for="self_introduction">Self Introduction</label><br>
        <textarea id="self_introduction" name="self_introduction" cols="30" rows="5"></textarea>
      </div>

      <!-- 次の更新処理でidが必要になるため，<input type="hidden">を用いてidを送信する． -->
      <input type="hidden" name="id" value="<?= $record['id'] ?>">
      <div>
        <input type="submit" value="更新">
      </div>
    </form>
    <a href="../takeshi/member_list.php">HOME</a>
    <a href="../login/logout.php">logout</a>
  </div>




</body>

</html>