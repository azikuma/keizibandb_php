<?php
require ("dbconnect.php");

if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])){
  $id = $_REQUEST['id'];

  $memos = $pdo->prepare('select * from board where id=?');
  $memos->execute(array($id));
  $memo = $memos->fetch();
}



?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>編集画面 </title>
</head>
<body>
<h1>掲示板</h1>
  <section>
    <h2>編集</h2>
    <form action="update.php" method="post">
      名前: <input type="text" name="name" value="<?= h($memo['name']) ?>"><br>
      本文: <input type="text" name="comment" value="<?= h($memo['comment']) ?>"><br>
      <input type="hidden" name="edit_id" value="<?= $memo['id']; ?>">
      <button type="submit" name="push">submit</button>
    </form>
  </section>
</body>
</html>