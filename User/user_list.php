<!-- 登録ユーザー一覧（管理者専用） -->
<?php
//セッション開始
session_start();
//関数読み込み
include('../functions.php');
//セッション状態確認
check_session_id();

//DB接続
$pdo = connect_to_db();

// ユーザー情報
//SQL作成
$sql = "SELECT username, user_id , image, is_admin FROM users_table LEFT OUTER JOIN profile_table ON users_table.id = profile_table.user_id WHERE is_admin = 0;";
//SQL準備
$stmt = $pdo->prepare($sql);
//今回は"ユーザーが入力したデータ"を使用しないのでバインド変数は不要
//SQL実行
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
//SQL実行処理内容
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// //プロフィール画像取り込み
// //SQL作成
// $sql = "SELECT * FROM profile_table WHERE user_id = :user_id";
// //SQL準備
// $stmt = $pdo->prepare($sql);
// //バインド関数
// $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
// //SQL実行
// try {
//   $status = $stmt->execute();
// } catch (PDOException $e) {
//   echo json_encode(["sql error" => "{$e->getMessage()}"]);
//   exit();
// }
// //SQL実行処理内容
// $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

//繰り返し処理でHTML文に表示
// $output = "";
// foreach ($result as $record) {
//   $output .= "
//   <tr>
//     <td>{$record["username"]}</td>
//     <td>
//         <a href=user_edit.php?id={$record["id"]}>edit</a>
//       </td>
//       <td>
//         <a href=user_delete.php?id={$record["id"]}>delete</a>
//       </td>
//     </tr>";
// }
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザーリスト（管理画面）</title>
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/miyuki.css">
  <style>
    header {
      display: flex;
      justify-content: space-around;
      align-items: center;
      padding-top: 20px;
    }

    table {
      border-collapse: collapse;
      border-spacing: 0;
      width: 100%;
    }

    table tr {
      border-bottom: solid 1px #eee;
      cursor: pointer;
    }

    table tr.point:hover {
      background-color: #d4f0fd;
    }

    table th,
    table td {
      text-align: center;
      padding: 10px 0;
    }

    p{
      font-weight: bold;
    }

    .image {
      margin-right: 10px;
    }
  </style>
</head>


<body>
  <div class="container">
    <header>
      <!-- ヘッダー左 -->
      <div class="header-left">
        <h2>ユーザー管理画面</h2>
      </div>
      <!-- ヘッダー右 -->
      <div class="header-right">
        <a href="../login/logout.php">
          <img src="../img/logout.png" alt="" height="30px" class="image">
        </a>
        <a href="../takeshi/room_list.php">
          <img src="../img/home.png" alt="" height="30px">
        </a>
      </div>
    </header>
    <hr>


    <table>
      <tr>
        <th>User Image</th>
        <th>User Name</th>
      </tr>

      <?php foreach ($result as $record) { ?>
        <tr class="point">
          <!-- プロフィール画像 -->
          <td>
            <img src="<?= $record['image'] ?>" alt="" height="50px">
          </td>
          <!-- ユーザーネーム -->
          <td>
            <p>
              <?= $record['username'] ?>
            </p>
          </td>

          <!-- 編集 -->
          <td>
            <a href="./user_edit.php?id=<?= ($record['id']) ?>">Edit</a>
          </td>

          <!-- 削除 -->
          <td>
            <a href="./user_delete.php?id=<?= ($record['id']) ?>">Delete</a>
          </td>
        </tr>

      <?php } ?>
    </table>
  </div>

</body>

</html>