<?php

//---------------------関数ファイル---------------------------------------//

//DB接続のための関数
//new PDO($dbn, $user, $pwd)を返す
function connect_to_db()
{
  // 各種項目設定
  $dbn = 'mysql:dbname=technocat;charset=utf8mb4;port=3306;host=localhost';
  $user = 'root';
  $pwd = '';

  // DB接続
  try {
    return new PDO($dbn, $user, $pwd);
  } catch (PDOException $e) {
    echo json_encode(["db error" => "{$e->getMessage()}"]);
    exit();
  }
}
// 「dbError:...」が表示されたらdb接続でエラーが発生していることがわかる．

//ログイン状態の確認の関数

//以下の 2 つの状態を「ログインしていない」とみなす！！
//「セッション変数にsession_idを持っていない」
//「id が最新ではない」はログインしていない状態
function check_session_id()
{
  if (!isset($_SESSION["session_id"]) || $_SESSION["session_id"] != session_id()) {
    header('Location:../login/login.php'); //ログイン画面へ
    exit();
  } else {
    session_regenerate_id(true);  //セッションIDの再生成
    $_SESSION["session_id"] = session_id(); //新しいセッションIDを取得
  }
}

//セッションにroom_idがあればチャットルームへ
function check_room_session_id()
{
  if (isset($_SESSION["room_id"])) {
    header('Location:../rtchat.php'); //チャット画面へ
    exit();
  } 
}

?>