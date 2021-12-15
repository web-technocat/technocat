<?php
//--------トークルームに入っている人の一覧ページです----------------

//ルームIDを取得
$room_id = $_GET['id'];

//セッションの開始
session_start();
//関数ファイル読み込み
include('takeshi_functions.php');
//セッション状態の確認とセッションID再生成
check_session_id();
//セッションにroom_idがあればチャットルームへ
check_room_session_id();

//セッションからuserIDを取得
$user_id = $_SESSION['user_id'];
// DB接続
$pdo = connect_to_db();

//-----------------トークルーム情報取得----------------------------------------------//

//SQL処理 users_table(x)とroom_table(y)をprofile_table(z)結合して取得
$sql = 'SELECT x.id,room_name,room_type,host_user,username,image FROM room_table as x LEFT JOIN users_table as y ON x.host_user = y.id LEFT JOIN profile_table as z ON y.id = z.user_id WHERE x.id = :room_id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':room_id', $room_id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

//$resultにデータを取得
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
  header("Location:no_room.php");
  exit();
}

// var_dump($result);
// exit();


//-----------------チェックイン情報取得----------------------------------------------//

//SQL処理 room_table(x)とusers_table(y)とprofile_table(z)を結合して取得
$sql = 'SELECT y.id,x.room_id,username,image FROM checkin_table as x LEFT JOIN users_table as y ON x.user_id = y.id LEFT JOIN profile_table as z ON y.id = z.user_id where x.room_id = :room_id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':room_id', $room_id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

//$memberにデータを取得
$members = $stmt->fetchAll(PDO::FETCH_ASSOC);

// var_dump($members);
// exit();

// タグをつけて表示
foreach ($members as $member) {
  //エスケープ処理
  $user_id = htmlspecialchars($member['id'], ENT_QUOTES);
  $room_id = htmlspecialchars($member['room_id'], ENT_QUOTES);
  $username = htmlspecialchars($member['username'], ENT_QUOTES);
  $image = htmlspecialchars($member['image'], ENT_QUOTES);

  $member_list .= "
    <a href=../profile/profile_page.php?key={$user_id}><li class=checkin_member><img src ={$image} class=profile_img>{$username}</li></a>
  ";
}

//タイトル表示のための変数
$title = "infomation";
//ユーザー名表示のための変数
$username = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>member list</title>

  <!-- reset.css読み込み -->
  <link rel="stylesheet" href="../css/reset.css">
  <!-- takeshi.css読み込み -->
  <link rel="stylesheet" href="./css/takeshi.css">

  <!-- line-awesome読み込み -->
  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

</head>

<body>
  <div id="wrapper_y">

    <!-- ヘッダーの読み込み -->
    <?php include('header_takeshi.php'); ?>

    <div class="main_contents">

      <!-- ルーム詳細表示部分 -->
      <section id="room_infometion">
        <h1><?= htmlspecialchars($result['room_name'], ENT_QUOTES); ?></h1>

        <div id="host_view">
          <p>ホストユーザー</p>
          <a href="../profile/profile_page.php?key=<?= htmlspecialchars($result['host_user'], ENT_QUOTES); ?>" id="host_user">
            <img src=<?= htmlspecialchars($result['image'], ENT_QUOTES); ?> class="profile_img" alt="プロフィール画像">
            <p><?= htmlspecialchars($result['username'], ENT_QUOTES); ?></p>
          </a>
        </div>
      </section>

      <!-- ルームメンバー表示部分 -->
      <section id="join_member">
        <p>参加中のメンバー</p>
        <ul>
          <!-- php側でエスケープ処理済-->
          <?= $member_list ?>
        </ul>
      </section>

      <!-- 入室ボタン部分 -->
      <form action="check_in.php" method="post">
        <!-- ルームナンバーを送るためのinput hidden -->
        <input type="hidden" name="room_id" value=<?= htmlspecialchars($result['id'], ENT_QUOTES); ?>>
        <!-- ルームタイプを送るためのinput hidden -->
        <input type="hidden" name="room_type" value=<?= htmlspecialchars($result['room_type'], ENT_QUOTES); ?>>
        <!-- 入室ボタン Join! -->
        <button type="submit" id="join_btn">入室</button>
      </form>

    </div>
    <!-- main_contentsここまで -->

    <!-- フッターの読み込み -->
    <?php include('footer_takeshi.php'); ?>

  </div>
  <!--wrapperここまで -->

  <!-- jquery読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <!-- takeshi.js読み込み -->
  <script src="./js/takeshi.js"></script>

  <script>
    //スワイプしてリロードする関数
    function setSwipe(swiped_content) {
      var s_Y; // スワイプ開始位置の定義
      var e_Y; // スワイプ終了位置の定義
      var dist = 30; // スワイプしたと判断するpx数を定義
      // スワイプ開始位置を決める（指が画面に触れた時）
      $(`${swiped_content}`).on('touchstart', function(e) {
        e.preventDefault();
        s_Y = e.touches[0].pageY;
      });
      // スワイプ終了位置を決める（指が画面上を動いてる時）
      $(`${swiped_content}`).on('touchmove', function(e) {
        e.preventDefault();
        e_Y = e.changedTouches[0].pageY;
      });
      // 指が画面から離れた時
      $(`${swiped_content}`).on('touchend', function(e) {
        if (s_Y + dist < e_Y) {
          // 下にスワイプした時の処理
          location.reload();
        }
      });
    }

    //関数実行(body);
    setSwipe('body');
  </script>

</body>

</html>