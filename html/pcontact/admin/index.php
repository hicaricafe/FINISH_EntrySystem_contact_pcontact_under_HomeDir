<?php

require_once('../config.php');
require_once('../functions.php');

$dbh = connectDb();

$entries = array();

$sql = "select * from entries where status = 'active' order by created desc";

foreach ($dbh->query($sql) as $row) {
  array_push($entries, $row);
}

// var_dump($entries);
// exit;


?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>お問合せ一覧</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
</head>
<body>
  <h1>データ一覧</h1>
  <p><span id="num"><?php echo count($entries); ?></span>件あります。</p>
  <ul>
    <?php foreach ($entries as $entry) : ?>
      <li id="entry_<?php echo h($entry['id']); ?>">
        <?php echo h($entry['email']); ?>
        <a href="edit.php?id=<?php echo h($entry['id']); ?>">[編集]</a>
        <span class="deleteLink" data-id="<?php echo h($entry['id']); ?>">[削除]</span>
      </li>
    <?php endforeach; ?>
  </ul>
  <style>
  .deleteLink {
    color: blue;
    cursor: pointer;
  }
  </style>
  <p><a href="<?php echo SITE_URL; ?>">お問合せフォームへ</a></p>
  <script>
  $(function() {
    $('.deleteLink').click(function() {
      if (confirm("削除してもよろしいですか？")) {
        var num = $('#num').text();
        num--;
        $.post('./delete.php', {
          id: $(this).data('id')
        }, function(rs) {
          $('#entry_' + rs).fadeOut(800);
          $('#num').text(num);
        });
      }
    });
  });
</script>
</body>
</html>
