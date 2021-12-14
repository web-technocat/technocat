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
    header('Location:index.php'); //ログイン画面へ
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
    header('Location:takeshi.php'); //チャット画面へ
    exit();
  } 
}

//現在ログインしているユーザーの情報を取得する関数
function getLouginUser() {
  
  $pdo = connect_to_db();
  $user_id = $_SESSION['user_id'];

  //users_tableとprofile_tableを結合して現在ログインしているユーザーの情報を取得
  $sql = 'SELECT users_table.id,username,image
  FROM users_table LEFT JOIN profile_table
  ON users_table.id = profile_table.user_id
  WHERE users_table.id = :user_id';
  
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
  
  try {
  $status = $stmt->execute();
  } catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
  }
  //$login_userに結果を受け取る
  $login_user = $stmt->fetch(PDO::FETCH_ASSOC);
  //imageのURLのパスを変更(./をとる)
  return $login_user['image'];
}

?>