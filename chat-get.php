<?php
// var_dump($_POST);
// exit();
session_start();
include('chat_functions.php');

$room_id = $_SESSION['room_id'];
// check_session_id();
$pdo = connect_to_db();

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