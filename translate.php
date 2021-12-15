<?php
session_start();
include('chat_functions.php');

$user_id = $_SESSION['user_id'];
$pdo = connect_to_db();

$sql = 'SELECT language FROM users_table LEFT OUTER JOIN profile_table ON users_table.id = profile_table.user_id WHERE users_table.id = :user_id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

$select_result = $stmt->fetch(PDO::FETCH_ASSOC);

$text = $_GET["text"];
$url = "https://script.google.com/macros/s/AKfycbyuXFxS9xIoY2QuZsxjjrb-qOP7x_D1wQV1vxqjKxI2mjL8T1DbvhYidh43eQcokFvR/exec";

// if ($_SESSION) {

// } else {

// }
if ($select_result['language'] == 0) {
    $palam=array(
        'text'=>"{$text}",
        'source'=>'ja',
        'target'=>'en',
        'type'=>'html'
    );
} else {
    $palam=array(
        'text'=>"{$text}",
        'source'=>'en',
        'target'=>'ja',
        'type'=>'html'
    );
}

$ch = curl_init();
$headr = array();
$headr[] = 'Content-Type: application/json;';
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($palam));

//API実行
$result = curl_exec($ch);

curl_close($ch);

$rec = json_decode($result,true);
echo $rec['text'];

?>
