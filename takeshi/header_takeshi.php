<!------- ヘッダー部分のphp --------------------------------------------->

<!-- ハンバーガーメニューの内容 -->
<div id="menu_contents">
  <div id="my_acount">
    <img src=<?= htmlspecialchars($_SESSION['imgUrl'], ENT_QUOTES) ?> class="profile_img">
    <div><?= htmlspecialchars($username, ENT_QUOTES) ?></div>
  </div>

  <div id="menu_list">
    <ul>
      <a href="../Profile/profile_page.php?key=<?= htmlspecialchars($_SESSION['user_id'], ENT_QUOTES) ?>">
        <li>マイプロフィール</li>
      </a>
      <a href="../Profile/profile_edit.php">
        <li>プロフィール編集</li>
      </a>
      <li>お気に入り</li>
      <li>設定</li>
      <li>ヘルプ</li>
    </ul>
    <!-- ログアウトボタン -->
    <div id="logout_btn">
      <a href="../login/logout.php">
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
    <img src=<?= htmlspecialchars($_SESSION['imgUrl'], ENT_QUOTES) ?> class="profile_img" id="my_img">
    <!-- ハンバーガーメニューボタン -->
    <div class="las la-bars" id="hamburger"></div>
  </div>

</header><!-- ヘッダー部分ここまで -->