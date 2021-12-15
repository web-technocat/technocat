<?php

//-----プロフィール登録-----//
// //セッション開始
session_start();
// //関数読み込み
include("../functions.php");
//セッション状態確認
check_session_id();

//DB接続
$pdo = connect_to_db();


//ログイン中のユーザー確認
$user_id = $_get['key'];


// ユーザー情報
//SQL作成
//user_table(a)とprofile_table(b)を結合
$sql = "SELECT a.id,a.username,b.gender,b.language,b.hobby,b.image,b.user_id FROM users_table AS a LEFT OUTER JOIN profile_table AS b ON a.id = b.user_id";

//SQL準備
$stmt = $pdo->prepare($sql);
//今回は"ユーザーが入力したデータ"を使用しないのでバインド変数は不要
//SQL実行
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
//SQL実行処理内容
$record = $stmt->fetch(PDO::FETCH_ASSOC);

//性別の表示方法

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>プロフィール画面</title>
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/miyuki.css">
  <style>
    /* Fonts */
    @import url(https://fonts.googleapis.com/css?family=Open+Sans:400);

    /* fontawesome */
    @import url(http://weloveiconfonts.com/api/?family=fontawesome);

    [class*="fontawesome-"]:before {
      font-family: 'FontAwesome', sans-serif;
    }

    body {
      font: 400 87.5%/1.5em 'Open Sans', sans-serif;
    }

    /*枠デザイン*/
    .profile_box {
      border-bottom: solid 10px #ff7d6e;
      border-radius: 10px;
      padding-top: 145px;
    }

    .profile_box .box-title {
      font-size: 25px;
      line-height: 1.8;
      background: #bf4b3d;
      /*タイトルの背景色*/
      padding: 4px;
      text-align: center;
      color: #FFF;
      /*文字色*/
      font-weight: bold;
      letter-spacing: 0.05em;
      border-radius: 10px 10px 0 0;
    }

    /*内容*/
    .profile_center {
      text-align: center;
      margin: 10px 15px 0 0;
    }

    /*プロフィール画像*/
    .profile_figure {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      /*丸くする*/
      border: solid 3px #f2d0cb;
      /*枠線*/
    }

    /*名前*/
    .profile_name {
      padding: 15px 20px;
      font-weight: bold;
      font-size: 16px;
    }

    /*自己紹介文*/
    .profile_box p {
      padding: 15px 20px;
      margin: 0;
    }

    /*リスト*/
    .profile_box ul {
      padding: 0.5em 1em 0.5em 2.3em;
      position: relative;
    }

    .profile_box ul li {
      line-height: 1.5;
      padding: 0.5em 0;
      list-style-type: none !important;
    }

    .profile_box ul li:before {
      font-family: "Font Awesome 5 Free";
      /*アイコンの種類*/
      font-weight: 900;
      position: absolute;
      left: 1em;
      /*左端からのアイコンまでの距離*/
      color: #ff7d6e;
      /*アイコン色*/
    }

    footer {
      display: flex;
      justify-content: space-around;
      align-items: center;
      margin-top: 30px;
    }

    a.btn--orange {
      color: #fff;
      font-size: 20px;
      background-color: #ff7d6e;
      border-bottom: 5px solid #b84c00;
      padding: 15px;
      border-radius: 5px;
    }

    a.btn--orange:hover {
      margin-top: 3px;
      color: #fff;
      background: #ff7d6e;
      border-bottom: 2px solid #b84c00;
    }

    a.btn--shadow {
      -webkit-box-shadow: 0 3px 5px rgba(0, 0, 0, .3);
      box-shadow: 0 3px 5px rgba(0, 0, 0, .3);
    }
  </style>
</head>



<body>
  <div class="container">
    <div class="profile_box">
      <div class="box-title">Profile</div>
      <div class="profile_center">
        <!-- プロフィール画像 -->
        <img alt="" src="<?= $record['image'] ?>" class="profile_figure">
        <!-- ユーザーネーム -->
        <div class="profile_name">
          <?= $record['username'] ?>
        </div>
      </div>
      <ul>
        <li>性別：
          <!-- valueの値が0だと男性、1だと女性 -->
          <?= $record['gender'] == 0 ? '男性' : '女性' ?>
        </li>
        <li>使用言語：
          <!-- valueの値が0だと日本語、1だと英語 -->
          <?= $record['language'] == 0 ? '日本語' : '英語' ?>
        </li>
        <li>趣味：
          <?= $record['hobby'] ?>
        </li>
        <li>何か一言：
          <?= $record['self_introduction'] ?>
        </li>
      </ul>
    </div>

    <footer>
      <!-- TOP画面へ遷移 -->
      <div class="home">
        <a href="../takeshi/room_list.php" class="btn btn--orange btn--cubic btn--shadow">HOME</a>
      </div>

      <!-- ログアウト -->
      <div class="logout">
        <a href="../login/logout.php" class="btn btn--orange btn--cubic btn--shadow">LOGOUT</a>
      </div>

    </footer>

</body>

</html>