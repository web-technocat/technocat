<?php
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
    $output .= "<div class='log'><p>{$record["user_id"]}<span> posted at {$record["created_at"]}</span></p><p>{$record["text"]} / {$record["trans_text"]}</p></div>";
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
            margin: 0;

        }
        header {
            position: sticky;
            width: 100vw;
            top: 0;
            padding: 16px;
            border-bottom: 2px solid #333333;
        }

        header p {
            margin: 0;
        }

        .log {
            margin: 8px;
            padding: 0 16px;
            border: 2px solid #333333;
            border-radius: 16px;
        }

        footer {
            position: fixed;
            width: 100vw;
            bottom: 0;
            padding: 16px;
            border-top: 2px solid #333333;
        }

        footer > div {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        footer > div > textarea {
            width: 50vw;
            height: 48px;
            font-size: 20px;
            resize: none;
        }

        footer > div > button {
            width: 5vw;
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
            <p>チャット</p>
        </div>
    </header>
    <main>
        <?=$output?>
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
        $('#send').on('click', function () {
            const text = $('#text-form').val();
            const textFormData = new FormData();
            textFormData.append('text', text);
            axios
            .get(`translate.php?text=${text}`)
            .then(function(response){
                console.log(response);
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
                console.log(response);
                const array = [];
                response.data.forEach(value => {
                    array.push(`<div class='log'><p>${value.user_id}<span> posted at ${value.created_at}</span></p><p>${value.text} / ${value.trans_text}</p><div>`);
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