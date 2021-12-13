<?php
$date = strtotime("now");
include("functions.php");
$pdo = connect_to_db();

$sql = 'SELECT * FROM log_table';

$stmt = $pdo->prepare($sql);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$output = "";
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
        $output .= "<div class='log my-log'><p>{$record["user_id"]}<span> {$result_time_diff}に投稿</span></p><p class='oritext'>{$record["text"]}</p><p>{$record["trans_text"]}</p></div>";
    } else {
        $output .= "<div class='log other-log'><p>{$record["user_id"]}<span> {$result_time_diff}に投稿</span></p><p class='oritext'>{$record["text"]}</p><p>{$record["trans_text"]}</p></div>";
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <style>
        body {
            padding: 0;
            margin: 0 auto;
            width: 375px;
        }

        a, button{
            cursor: pointer;
            text-decoration: none;
            color: black;
        }

        header {
            position: fixed;
            width: 375px;
            top: 0;
            border-bottom: 2px solid #333333;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
        }

        header div {
            width: 30%;
            text-align: center;
            border: 2px solid #333;
            margin: 8px 0;
        }

        header h2, header p {
            margin: 0;
        }

        main {
            position: fixed;
            top: 46px;
            display: flex;
            width: 375px;
            height: calc(100% - 120px);
            flex-direction: column;
            align-items: center;
            margin: 0 auto;
            overflow: scroll;
        }

        #output {
            width: 100%;
        }

        .log {
            margin: 8px;
            padding: 8px 16px;
            border: 2px solid #333333;
            border-radius: 16px;
            max-width: 50%;
        }

        .log p {
            margin: 0;
            font-size: 16px;
        }

        .log > p {
            padding-bottom: 8px;
        }

        .log span {
            font-size: 12px;
        }

        .oritext {
            border-bottom: 1px solid #333;
        }

        .my-log {
            background: #717375;
            color: white;
            margin-left: auto;
        }

        .other-log {
            background: #EAEBEB;
            color: black;
            margin-right: auto;
        }

        footer {
            position: fixed;
            width: 375px;
            bottom: 0;
            border-top: 2px solid #333333;
            background: white;
        }

        footer > div {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 8px 0;
        }

        footer > div > textarea {
            width: 64%;
            height: 48px;
            font-size: 20px;
            resize: none;
        }

        footer > div > button {
            width: 16%;
            height: 48px;
            padding: 2px;
            font-size: 20px;
            margin-left: 16px;
        }
    </style>
</head>
<body>
    <header>
        <div>
            <a href="room_list.php"><p>退出</p></a>
        </div>
        <h2>チャット</h2>
        <div>
            <p>ユーザー名</p>
        </div>
    </header>
    <main>
        <div id="output">
            <?=$output?>
        </div>
    </main>

    <footer>
        <div>
            <textarea id="text-form"></textarea>
            <button id="send"><i class="fas fa-paper-plane"></i></button>
        </div>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>

        $(function() {
            $('#output')[0].scrollIntoView(false);
        });

        $('#send').on('click', function () {
            const text = $('#text-form').val();
            const textFormData = new FormData();
            textFormData.append('text', text);
            axios
            .get(`translate.php?text=${text}`)
            .then(function(response){
                // console.log(response);
                const transTextFormData = new FormData();
                transTextFormData.append('text', text);
                transTextFormData.append('trans-text', response.data);
                axios({
                    method: 'post',
                    url: 'chat-post.php',
                    data: transTextFormData,
                    headers: { "Content-Type": "multipart/form-data" },
                })
                .then(function(response) {
                // console.log(response);
                const array = [];
                response.data.forEach(value => {
                    const date = new Date().getTime();
                    const timestamp = new Date(value.created_at).getTime();
                    const time_diff = (date - timestamp) / 1000;
                    let result_time_diff;
                    if (Math.floor(time_diff / 60) == 0) {
                        result_time_diff = `たった今`;
                    } else if (Math.floor(time_diff / 60) <= 59) {
                        const minute_diff = Math.floor(time_diff / 60);
                        result_time_diff = `${minute_diff}分前に`;
                    } else if (Math.floor(time_diff / 3600) <= 23) {
                        const hour_diff = Math.floor(time_diff / 3600);
                        result_time_diff = `${hour_diff}時間前に`;
                    } else {
                        const date_diff = Math.floor(time_diff / 86400);
                        result_time_diff = `${date_diff}日前に`;
                    }
                    if (value.user_id == 1) {
                        array.push(`<div class='log my-log'><p>${value.user_id}<span> ${result_time_diff}投稿</span></p><p class='oritext'>${value.text}</p><p>${value.trans_text}</p><div>`);
                    } else {
                        array.push(`<div class='log other-log'><p>${value.user_id}<span> ${result_time_diff}投稿</span></p><p class='oritext'>${value.text}</p><p>${value.trans_text}</p><div>`);
                    }
                });
                $('main').html(array);
                })
                .catch(function(error) {
                console.log('post error');
                console.log(error);
                })
                .finally(function() {
                console.log('ajax done!');
                $('#text-form').val('');
                });
            });
        });
    </script>
</body>
</html>