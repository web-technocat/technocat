<?php
//-------トークルーム一覧のページです-----------------------------------------//

//セッションの開始
session_start();
//関数ファイル読み込み
include('functions.php');
//セッション状態の確認とセッションID再生成
check_session_id();


// DB接続
$pdo = connect_to_db();

//SQL処理 room_table(x)とusers_table(y)を結合して取得
$sql = 'SELECT x.id,room_name,room_type,host_user,username
FROM  room_table as x LEFT JOIN users_table as y 
ON x.host_user = y.id ORDER BY x.created_at DESC';

$stmt = $pdo->prepare($sql);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
//$resultに結果を受け取る
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);


//取得したデータにHTMLタグをつける
$output = "";
foreach ($result as $record) {
  $output .= "
    <a href=member_list.php?id={$record["id"]}>
    <li><img src=./img/null.png class=profile_img>{$record["room_name"]}</li>
    </a>
  ";
}

//タイトル表示のための変数
$title = "room select";
//ユーザー名表示のための変数
$username = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>room list</title>

  <!-- reset.css読み込み -->
  <link rel="stylesheet" href="./css/reset.css">
  <!-- takeshi.css読み込み -->
  <link rel="stylesheet" href="./css/takeshi.css">
  <!-- line-awesome読み込み -->
  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

</head>

<body>

  <div id="wrapper_y">

    <!-- ヘッダーの読み込み -->
    <?php include('./takeshi/header_takeshi.php'); ?>

    <!-- メイン部分 -->
    <div class="main_contents">

      <div id="main_top">

        <!-- 検索部分 -->
        <section>
          <span class="las la-search"></span><input type="text" id="search" placeholder="キーワードを入力">
        </section>

        <!-- ルーム追加ボタン -->
        <section>
          <a href="room_input.php">
            <div id="add_btn" class="las la-plus"></div>
          </a>
        </section>

      </div>

      <!-- トークルーム一覧出力部分 -->
      <section id="room_section">
        <ul id="result">
          <?= $output ?>
          <ul>
      </section>


    </div>
    <!-- メイン部分ここまで -->

    <!-- フッターの読み込み -->
    <?php include('./takeshi/footer_takeshi.php'); ?>

  </div>
  <!--wrapperここまで -->

  <!-- jquery読み込み -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!-- axios読み込み -->
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <!-- takeshi.js読み込み -->
  <script src="./js/takeshi.js"></script>

  <script>
    //--------検索部分--------------------------------------//

    //検索ワード入力欄のキーを上げたら発動
    $('#search').on('keyup', function(e) {
      console.log(e.target.value); //入力文字をコンソールに出す
      const searchWord = e.target.value; //入力された値
      const requestUrl = "room_search.php"; //送信先ファイル

      axios
        .get(`${requestUrl}?searchword=${searchWord}`)
        .then(function(response) { //responseにデータ受け取り
          //console.log(response);
          //表示のための配列
          const array = [];

          //response.dateに繰り返し処理でタグをつける
          response.data.forEach(function(x) {
            array.push(`<a href=member_list.php?id=${x.id}><li>${x.room_name} type:${x.room_type} host:${x.username}</li></a>`);
          });
          $('#result').html(array); //id=resultのhtmlを上書き
        })
        .catch(function(error) {
          console.log(error); //失敗したらコンソールにエラーを出す
        })
        .finally(function() {
          // 省略
        });


    });
  </script>

</body>

</html>