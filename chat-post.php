<?php
// var_dump($_POST);
// exit();
session_start();
include('functions.php');
// check_session_id();

$text = $_POST['text'];
$trans_text = $_POST['trans-text'];

$pdo = connect_to_db();

$sql = 'INSERT INTO log_table (id, text, trans_text, user_id, room_id, created_at, updated_at) VALUES (null, :text, :trans_text, 2, 1, now(), now())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':text', $text, PDO::PARAM_STR);
$stmt->bindValue(':trans_text', $trans_text, PDO::PARAM_STR);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

$sql = 'SELECT * FROM log_table';

$stmt = $pdo->prepare($sql);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($result);
exit();