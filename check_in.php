<?php
//------入室者を登録するphpです-------------------------------------//

var_dump($_GET);
exit();

//セッションの開始
session_start();
//関数ファイル読み込み
include('functions.php');
//セッション状態の確認とセッションID再生成
check_session_id();

?>