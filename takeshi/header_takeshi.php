<!-- ハンバーガーメニューの内容 -->
<div id="menu_contents">
  <div id="my_acount">
    <img src="./img/null.png" class="profile_img">
    <div><?= htmlspecialchars($username, ENT_QUOTES) ?></div>
  </div>

  <div id="menu_list">
    <ul>
      <li>プロフィール編集</li>
      <li>hoge</li>
      <li>hoge</li>
      <li>hoge</li>
    </ul>
    <!-- ログアウトボタン -->
    <div id="logout_btn">
      <a href="todo_logout.php">
        <div>logout</div>
      </a>
    </div>

  </div>
</div>
<!-- menu_contentsここまで -->

<!-- ハンバーガーメニューの背景 -->
<div id="mask">
  <!-- クローズボタン -->
  <div class="las la-times" id="clese_btn"></div>
</div>

<!-- ヘッダー部分 -->
<header>
  <!-- ヘッダー左側 -->
  <div id="header_left">
    <h1 id="main_title_y"><?= htmlspecialchars($title, ENT_QUOTES) ?></h1>
  </div>

  <!-- ヘッダー右側 -->
  <div id="header_right">
    <!-- プロフィール画像表示部分 -->
    <img src="./img/null.png" class="profile_img" id="my_img">
    <!-- ハンバーガーメニューボタン -->
    <div class="las la-bars" id="hamburger"></div>
  </div>

</header><!-- ヘッダー部分ここまで -->