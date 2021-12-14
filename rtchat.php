<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/css/lightbox.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/js/lightbox.min.js" type="text/javascript"></script>
<style type="text/css">
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
            height: calc(100% - 184px);
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
            word-break: break-all;
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

        .chat-input {
            position: fixed;
            width: 375px;
            bottom: 66px;
            border-top: 2px solid #333333;
            background: white;
        }

        .chat-container {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px 0;
        }



        .chat-input > div > textarea {
            width: calc(64% + 32px);
            height: 48px;
            font-size: 20px;
            margin-left: 16px;
            resize: none;
            border: 2px solid #333;
        }
        .chat-input > div > textarea.active {
            width: 48%;
        }

        label {
            width: 68px;
            height: 48px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #upfile {
            width: 100%;
            height: 100%;
            padding: 2px;
            font-size: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 2px solid #333;
            cursor: pointer;
        }

        #input-file {
            display: none;
        }

        #send {
            display: none;
            width: 68px;
            height: 48px;
            padding: 2px;
            font-size: 20px;
            margin-left: 16px;
            justify-content: center;
            align-items: center;
            border: 2px solid #333;
            cursor: pointer;
        }

        #send.active {
            display: flex;
        }
        /* フッター全体 */
        .footer_y {
            position: fixed;
            bottom: 0;
            z-index: 10px;
        }

        #footer_contents {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: lightgray;
            width: 375px;
        }

        /* フッターボタン */
        .footer_btn {
            border: 1px solid #000;
            height: 64px;
            width: 25%;
        }
</style>
</head>
<body>
    <header>
        <div>
            <a href="room_list.php">
                <p>退出</p>
            </a>
        </div>
        <h2>チャット</h2>
        <div>
            <p>ユーザー名</p>
        </div>
    </header>
    <main>
        <div id="output">
        </div>
        <div class="chat-input">
            <div class="chat-container">
                <label for="input-file">
                    <div id="upfile">
                        <i class="fas fa-file-upload"></i>
                    </div>
                    <input type="file" name="upload-file" id="input-file"></input>
                </label>
                <textarea id="text-form"></textarea>
                <div id="send" onclick="send();"><i class="fas fa-paper-plane"></i></div>
            </div>
        </div>
    </main>

    <footer class="footer_y">
        <div id="footer_contents">
            <div class="footer_btn">ボタン1</div>
            <div class="footer_btn">ボタン2</div>
            <div class="footer_btn">ボタン3</div>
        </div>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script type="text/javascript">
        function getLog() {
            axios
                .get('chat-get.php')
                .then(function (response) {
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
                            const newText = AutoLink(value.text);
                            array.push(`<div class='log my-log'><p>${value.user_id}<span> ${result_time_diff}投稿</span></p><p class='oritext'>${newText}</p><p>${value.trans_text}</p><div>`);
                            if (newText.includes('<a href')){
                                const data = {
                                    key: '343f9edd1eaa37dcbaacb5482a884a71',
                                    q: value.text
                                }
                                fetch('https://api.linkpreview.net', {
                                    method: 'POST',
                                    mode: 'cors',
                                    body: JSON.stringify(data),
                                })
                                .then(data => data.json())
                                .then(json => array.push(`<div class='log my-log'><a href='${json.url}' target='_blank'><img src='${json.image}' width='187.5'><p>${json.title}</p></a>`));
                            }
                            if (value.upfile !== null) {
                                const fileType = value.upfile.split('.').pop();
                                if (fileType === 'jpg' || fileType === 'png' || fileType === 'webp' || fileType === 'bmp' || fileType === 'gif' || fileType === 'tiff' || fileType === 'svg'){
                                    array.push(`<div class='log my-log'><a href='${value.upfile}' data-lightbox='group'><img src='${value.upfile}' height="117"></a></div>`);
                                } else if (fileType === 'mp3' || fileType === 'wav' || fileType === 'flac' || fileType === 'm4a' || fileType === 'wma' || fileType === 'ogx'){
                                    array.push(`<div class='log my-log'><audio controls src='${value.upfile}'></audio></div>`);
                                } else if (fileType === 'avi'| fileType === 'mp4' || fileType === 'mov' || fileType === 'wmv' || fileType === 'mpg' || fileType === 'mkv' || fileType === 'flv' || fileType === 'asf'){
                                    array.push(`<div class='log my-log'><video controls src='${value.upfile}' width="117"></video></a></div>`);
                                }
                            }
                        } else {
                            const newText = AutoLink(value.text);
                            if (newText.includes('<a href')){
                                const data = {
                                    key: '343f9edd1eaa37dcbaacb5482a884a71',
                                    q: value.text
                                }
                                fetch('https://api.linkpreview.net', {
                                    method: 'POST',
                                    mode: 'cors',
                                    body: JSON.stringify(data),
                                })
                                .then(data => data.json())
                                .then(json => array.push(`<div class='log other-log'><p>${value.user_id}<span> ${result_time_diff}投稿</span></p><p class='oritext'>${newText}</p><a href='${json.url}' target='_blank'><img src='${json.image}' width='187.5'><p>${json.title}</p></a>`));
                            } else {
                                array.push(`<div class='log other-log'><p>${value.user_id}<span> ${result_time_diff}投稿</span></p><p class='oritext'>${newText}</p><p>${value.trans_text}</p><div>`);
                            }
                            if (value.upfile !== null) {
                                const fileType = value.upfile.split('.').pop();
                                if (fileType === 'jpg' || fileType === 'png' || fileType === 'webp' || fileType === 'bmp' || fileType === 'gif' || fileType === 'tiff' || fileType === 'svg'){
                                    array.push(`<div class='log other-log'><a href='${value.upfile}' data-lightbox='group'><img src='${value.upfile}' height="97"></a></div>`);
                                } else if (fileType === 'mp3' || fileType === 'wav' || fileType === 'flac' || fileType === 'm4a' || fileType === 'wma' || fileType === 'ogx'){
                                    array.push(`<div class='log other-log'><audio controls src='${value.upfile}'></audio></div>`);
                                } else if (fileType === 'avi'| fileType === 'mp4' || fileType === 'mov' || fileType === 'wmv' || fileType === 'mpg' || fileType === 'mkv' || fileType === 'flv' || fileType === 'asf'){
                                    array.push(`<div class='log other-log'><video controls src='${value.upfile}' width="117"></video></div>`);
                                }
                            }
                        }
                    });
                    setTimeout(function(){
                        $('#output').html(array);
                        $('#output')[0].scrollIntoView(false);
                    }, 1000)
                });
        }

        function AutoLink(text) {
            var str = text;
            var regexp_url = /((h?)(ttps?:\/\/[a-zA-Z0-9.\-_@:/~?%&;=+#',()*!]+))/g;
            var regexp_makeLink = function(all, url, h, href) {
                return '<a href="h' + href + '" target="_blank" id="link">' + url + '</a>';
            }
            var textWithLink = str.replace(regexp_url, regexp_makeLink);
            return textWithLink;
        }

        $(function () {
            getLog();
        });

        let upfile;
        $('#input-file').on('change', function(){
            upfile = this.files[0];
        });


        $('#text-form').on('change', function () {
            if ($('#text-form').val() !== '') {
                $('#send').addClass('active');
                $('#text-form').addClass('active');
            } else {
                $('#send').removeClass('active');
                $('#text-form').removeClass('active');
            }
        });
        var conn = "";

        function open() {

            conn = new WebSocket('ws://localhost:8080');

            conn.onopen = function (e) {
            };

            conn.onerror = function (e) {
                alert("エラーが発生しました");
            };

            conn.onmessage = function (e) {
                console.log(e.data);
                getLog();
            };

            conn.onclose = function () {
                alert("切断しました");
                setTimeout(open, 5000);
            };

        }

        function send() {
            const text = $('#text-form').val();
            console.log(text);
            if (text !== '') {
                const textFormData = new FormData();
                textFormData.append('text', text);
                axios
                    .get(`translate.php?text=${text}`)
                    .then(function (response) {
                        // console.log(response);
                        const transTextFormData = new FormData();
                        transTextFormData.append('text', text);
                        transTextFormData.append('trans-text', response.data);
                        transTextFormData.append('upfile', upfile);
                        axios({
                            method: 'post',
                            url: 'chat-post.php',
                            data: transTextFormData,
                            headers: { "Content-Type": "multipart/form-data" },
                        })
                            .then(function (response) {
                                // console.log(response);
                                const array = [];
                                console.log(response.data);
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
                                        const newText = AutoLink(value.text);
                                        array.push(`<div class='log my-log'><p>${value.user_id}<span> ${result_time_diff}投稿</span></p><p class='oritext'>${newText}</p><p>${value.trans_text}</p><div>`);
                                        if (newText.includes('<a href')){
                                            const data = {
                                                key: '343f9edd1eaa37dcbaacb5482a884a71',
                                                q: value.text
                                            }
                                            fetch('https://api.linkpreview.net', {
                                                method: 'POST',
                                                mode: 'cors',
                                                body: JSON.stringify(data),
                                            })
                                            .then(data => data.json())
                                            .then(json => array.push(`<div class='log my-log'><a href='${json.url}' target='_blank'><img src='${json.image}' width='187.5'><p>${json.title}</p></a>`));
                                        }
                                        if (value.upfile !== null) {
                                            const fileType = value.upfile.split('.').pop();
                                            if (fileType === 'jpg' || fileType === 'png' || fileType === 'webp' || fileType === 'bmp' || fileType === 'gif' || fileType === 'tiff' || fileType === 'svg'){
                                                array.push(`<div class='log my-log'><a href='${value.upfile}' data-lightbox='group'><img src='${value.upfile}' height="117"></a></div>`);
                                            } else if (fileType === 'mp3' || fileType === 'wav' || fileType === 'flac' || fileType === 'm4a' || fileType === 'wma' || fileType === 'ogx'){
                                                array.push(`<div class='log my-log'><audio controls src='${value.upfile}'></audio></div>`);
                                            } else if (fileType === 'avi'| fileType === 'mp4' || fileType === 'mov' || fileType === 'wmv' || fileType === 'mpg' || fileType === 'mkv' || fileType === 'flv' || fileType === 'asf'){
                                                array.push(`<div class='log my-log'><video controls src='${value.upfile}' width="117"></video></div>`);
                                            }
                                        }
                                    } else {
                                        const newText = AutoLink(value.text);
                                        if (newText.includes('<a href')){
                                            const data = {
                                                key: '343f9edd1eaa37dcbaacb5482a884a71',
                                                q: value.text
                                            }
                                            fetch('https://api.linkpreview.net', {
                                                method: 'POST',
                                                mode: 'cors',
                                                body: JSON.stringify(data),
                                            })
                                            .then(data => data.json())
                                            .then(json => array.push(`<div class='log other-log'><p>${value.user_id}<span> ${result_time_diff}投稿</span></p><p class='oritext'>${newText}</p><a href='${json.url}' target='_blank'><img src='${json.image}' width='187.5'><p>${json.title}</p></a>`));

                                        } else {
                                            setTimeout(function(){
                                                array.push(`<div class='log other-log'><p>${value.user_id}<span> ${result_time_diff}投稿</span></p><p class='oritext'>${newText}</p><p>${value.trans_text}</p><div>`);
                                            }, 100);
                                        }
                                        if (value.upfile !== null) {
                                            const fileType = value.upfile.split('.').pop();
                                            if (fileType === 'jpg' || fileType === 'png' || fileType === 'webp' || fileType === 'bmp' || fileType === 'gif' || fileType === 'tiff' || fileType === 'svg'){
                                                array.push(`<div class='log other-log'><a href='${value.upfile}' data-lightbox='group'><img src='${value.upfile}' height="97"></a></div>`);
                                            } else if (fileType === 'mp3' || fileType === 'wav' || fileType === 'flac' || fileType === 'mp4' || fileType === 'm4a' || fileType === 'wma' || fileType === 'ogx'){
                                                array.push(`<div class='log other-log'><audio controls src='${value.upfile}'></audio></div>`);
                                            } else if (fileType === 'avi'| fileType === 'mp4' || fileType === 'mov' || fileType === 'wmv' || fileType === 'mpg' || fileType === 'mkv' || fileType === 'flv' || fileType === 'asf'){
                                                array.push(`<div class='log other-log'><video controls src='${value.upfile}' width="117"></video></div>`);
                                            }
                                        }
                                    }
                                });
                                setTimeout(function(){
                                    $('#output').html(array);
                                    conn.send(text);
                                    $('#output')[0].scrollIntoView(false);
                                }, 1000)
                            })
                            .catch(function (error) {
                                console.log('post error');
                                console.log(error);
                            })
                            .finally(function () {
                                console.log('ajax done!');
                                $('#text-form').val('');
                            });
                    });
            } else {
                $('#text-form').attr('placeholder', '不正な操作です');
            }

        }

        function close() {
            conn.close();
        }

        open();

    </script>
</body>
</html>