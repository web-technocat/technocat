<?php
$text = $_GET["text"];
$url = "https://script.google.com/macros/s/AKfycbyuXFxS9xIoY2QuZsxjjrb-qOP7x_D1wQV1vxqjKxI2mjL8T1DbvhYidh43eQcokFvR/exec";

$palam=array(
    'text'=>"{$text}",
    'source'=>'ja',
    'target'=>'en',
    'type'=>'html'
);

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
