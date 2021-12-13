<?php
$date = date("Y-m-d H:i:s");
include("functions.php");
$pdo = connect_to_db();

$sql = "SELECT * FROM log_table WHERE created_at >='" . $date . "'";

$stmt = $pdo->prepare($sql);
// $stmt->bindValue(':date', $date, PDO::PARAM_STR);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$new_output = "";
foreach ($result as $record) {
    $timestamp = strtotime($record["created_at"]);
    $time_diff = $date - $timestamp;
    if (floor($time_diff / 60) == 00) {
        $second_diff = $time_diff;
        $result_time_diff = "{$second_diff}秒前";
    } else if (floor($time_diff / 60) <= 59) {
        $minute_diff = floor($time_diff / 60);
        $result_time_diff = "{$minute_diff}分前";
    } else if (floor($time_diff / 3600) <= 23) {
        $hour_diff = floor($time_diff / 3600);
        $result_time_diff = "{$hour_diff}時間前";
    } else {
        $date_diff = floor($time_diff / 86400);
        $result_time_diff = "{$date_diff}日前";
    }
    if ($record["user_id"] == 1) {
        $new_output .= "<div class='log my-log'><p>{$record["user_id"]}<span> {$result_time_diff}に投稿</span></p><p class='oritext'>{$record["text"]}</p><p>{$record["trans_text"]}</p></div>";
    } else {
        $new_output .= "<div class='log other-log'><p>{$record["user_id"]}<span> {$result_time_diff}に投稿</span></p><p class='oritext'>{$record["text"]}</p><p>{$record["trans_text"]}</p></div>";
    }
}

echo $new_output;