<?php
// var_dump($_POST);
// exit();
session_start();
include('chat_functions.php');

$text = htmlspecialchars($_POST['text'], ENT_QUOTES);
$trans_text = htmlspecialchars($_POST['trans-text'], ENT_QUOTES);
$user_id = $_SESSION['user_id'];
$room_id = $_SESSION['room_id'];

// データの確認
if (isset($_FILES['upfile']) && $_FILES['upfile']['error'] == 0) {
    // 情報の取得
    $uploaded_file_name = $_FILES['upfile']['name'];
    $temp_path  = $_FILES['upfile']['tmp_name'];
    $directory_path = 'upload/';
    // ファイル名の準備
    $extension = pathinfo($uploaded_file_name, PATHINFO_EXTENSION);
    $unique_name = date('YmdHis').md5(session_id()) . '.' . $extension;
    $save_path = $directory_path . $unique_name;
    // 今回は画面に表示しないので権限の変更までで終了
    if (is_uploaded_file($temp_path)) {
        if (move_uploaded_file($temp_path, $save_path)) {
        chmod($save_path, 0644);
        } else {
        exit('Error:アップロードできませんでした');
        }
    } else {
        exit('Error:画像がありません');
    }
}

$pdo = connect_to_db();

$sql = 'INSERT INTO log_table (id, text, trans_text, upfile, user_id, room_id, created_at, updated_at) VALUES (null, :text, :trans_text, :upfile, :user_id, :room_id, now(), now())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':text', $text, PDO::PARAM_STR);
$stmt->bindValue(':trans_text', $trans_text, PDO::PARAM_STR);
$stmt->bindValue(':upfile', $save_path, PDO::PARAM_STR);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':room_id', $room_id, PDO::PARAM_STR);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

$sql = 'SELECT * FROM log_table LEFT OUTER JOIN users_table ON log_table.user_id = users_table.id WHERE room_id = :room_id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':room_id', $room_id, PDO::PARAM_STR);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($result);
exit();