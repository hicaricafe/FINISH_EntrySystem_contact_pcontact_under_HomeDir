<?php

require_once('config.php');
require_once('functions.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] != "POST") {
  // 投稿前

  // CSRF対策
  setToken();

} else {
  // 投稿後
  checkToken();

  $name = $_POST['name'];
  $email = $_POST['email'];
  $memo = $_POST['memo'];

  $error = array();

  // エラー処理
  if ($email == '') {
    $error['email'] = '社員番号を入力してください。';
  }
  if ($memo == '') {
    $error['memo'] = '内容を入力してください。';
  }

  if (empty($error)) {
    // DBに格納
    $dbh = connectDb();

    $sql = "insert into entries
    (name, email, memo, created, modified)
    values
    (:name, :email, :memo, now(), now())";
    $stmt = $dbh->prepare($sql);
    $params = array(
      ":name" => $name,
      ":email" => $email,
      ":memo" => $memo
    );
    $stmt->execute($params);

    // ありがとうページヘ
    header('Location: '.SITE_URL.'thanks.html');
    exit;

  }

}


?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>社内統括管理お問い合わせフォーム</title>
</head>
<body>
  <h3>社内統括管理お問い合わせフォーム</h3>
  <form method="POST" action="">
    <p>お名前：<input type="text" name="name" value="<?php echo h($name); ?>"></p>
    <p>
      社員番号*：<input type="text" name="email" value="<?php echo h($email); ?>">
      <?php if ($error['email']) { echo h($error['email']); } ?>
    </p>
    <p>内容*：</p>
    <p><textarea name="memo" cols="40" rows="5"><?php echo h($memo); ?></textarea></p>
    <?php if ($error['memo']) { echo h($error['memo']); } ?>

    <p><input type="submit" value="送信"></p>
    <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
  </form>
  <p><a href="<?php echo ADMIN_URL; ?>">管理者メニューへ</a></p>
</body>
</html>
