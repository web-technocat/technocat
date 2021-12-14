'use strict'
//ファイル共通のjs

//------メニューボタンの動き-----------------------------//

//初期設定
$('#mask').hide(); //メニュー背景隠す
$('#menu_contents').hide(); //メニュー中身隠す

//ハンバーガーボタンを押したら発動
$('#hamburger').on('click', function () {
  $('#mask').show(); //メニュー背景表示
  $('#menu_contents').show(400); //メニュー中身表示
});

//背景をクリックしたら発動
$('#mask').on('click', function () {
  $('#mask').hide(); //メニュー背景隠す
  $('#menu_contents').hide(); //メニュー中身隠す
});

