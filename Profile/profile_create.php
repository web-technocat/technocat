<?php
// echo '<pre>';
// var_dump($_POST);
// echo '</pre>';
// exit();

// echo '<pre>';
// var_dump($_FILES);
// echo '</pre>';
// exit();

// //セッション開始
session_start();
//関数読み込み
include("../functions.php");
//セッション状態確認
check_session_id();


//入力項目のチェック
if (
  !isset($_POST['gender']) || $_POST['gender'] == '' ||
  !isset($_POST['birth']) || $_POST['birth'] == '' ||
  !isset($_POST['language']) || $_POST['language'] == '' ||
  !isset($_POST['hobby']) || $_POST['hobby'] == '' ||
  !isset($_POST['self_introduction']) || $_POST['self_introduction'] == '' ||
  !isset($_POST['user_id']) || $_POST['user_id'] == ''
) {
  echo json_encode(["error_msg" => "no input"]);
  exit();
}

// //値の取得
$gender = $_POST['gender'];
$birth = $_POST['birth'];
$language = $_POST['language'];
$hobby = $_POST['hobby'];
$self_introduction = $_POST['self_introduction'];
$user_id = $_POST['user_id'];


// ここからファイルアップロード&DB登録の処理を追加しよう！！！
//-----送信時のエラー確認-----//
//ファイルが送信されている かつ 送信時のエラーなし
if (isset($_FILES['upfile']) && $_FILES['upfile']['error'] == 0) {
  //ファイル名を定義
  $uploaded_file_name = $_FILES['upfile']['name'];
  //一時保存されている場所を定義
  $temp_path  = $_FILES['upfile']['tmp_name'];
  //指定の保存場所
  $directory_path = '../upload/';

  //ファイルの拡張子の種類を取得
  $extension = pathinfo($uploaded_file_name, PATHINFO_EXTENSION);
  //ファイルごとにユニークな名前を作成し、末尾に拡張子を追加
  $unique_name = date('YmdHis') . md5(session_id()) . '.' . $extension;
  //指定の保存場所を追加し，保存用のパスを作成（upload/hogehoge.pngのような形になる）．
  $save_path = $directory_path . $unique_name;

  // var_dump($save_path);
  // exit();

  //指定の場所に指定の名前でファイルを保存する
  //tmp領域にファイルが存在しているか
  if (is_uploaded_file($temp_path)) {
    //指定のパスでファイルの保存が成功したかどうか
    if (move_uploaded_file($temp_path, $save_path)) {
      //PHP がファイルを操作するために権限を変更
      chmod($save_path, 0644);
      //画像を HTML に埋め込む
      //ダブルクォーテーションを用いる場合は{}で変数を埋め込むことができる
      //$str2 = "ジーズで{$lang2}を勉強中！";
      $img = "<img src={$save_path} alt='アップロード'>";
      $_SESSION['img'] = $img;
    } else {
      exit('アップロードできませんでした');
    }
  } else {
    exit('画像がありません');
  }
} else {
  exit('画像が送信されていません');
}

//-----DB情報追加-----//
//DB接続
$pdo = connect_to_db();


  //SQL作成
  $sql = "INSERT INTO profile_table(id, gender, birth, language,hobby,image,self_introduction,user_id,created_at,updated_at) VALUES(NULL,:gender,:birth,:language,:hobby,:image,:self_introduction,:user_id,now(), now())";

  //SQL準備
  $stmt = $pdo->prepare($sql);
  //バインド変数
  $stmt->bindValue(':gender', $gender, PDO::PARAM_STR);
  $stmt->bindValue(':birth', $birth, PDO::PARAM_STR);
  $stmt->bindValue(':language', $language, PDO::PARAM_STR);
  $stmt->bindValue(':hobby', $hobby, PDO::PARAM_STR);
  $stmt->bindValue(':image', $save_path, PDO::PARAM_STR);
  $stmt->bindValue(':self_introduction', $self_introduction, PDO::PARAM_STR);
  $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
  //SQL実行
  try {
    $status = $stmt->execute();
  } catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
  }
  //TOP画面へ遷移
  header("Location:../takeshi/room_list.php");
  exit();
