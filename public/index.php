<?php
require('dbconnect.php');

if (isset($_POST['new'])) {
  $name = $_POST['name'];
  $comment = $_POST['comment'];
  $stmt = $pdo->prepare("INSERT INTO board (name, comment) VALUES (:name, :comment)");
  $stmt->bindParam(':name', $name, PDO::PARAM_STR);
  $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
  $stmt->execute();
  $pdo->query($stmt);
  header("Location: " . $_SERVER['SCRIPT_NAME']);
}

if (isset($_POST['delete'])) {
  $id = $_POST['delete'];
  $stmt = $pdo->prepare("DELETE FROM board WHERE id = :id");
  $stmt->bindParam(':name', $name, PDO::PARAM_STR);
  $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
  $stmt->execute();
  header("Location: " . $_SERVER['SCRIPT_NAME']);
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>掲示板</title>
</head>
<body>
  <h1>掲示板</h1>
  <section>
    <h2>新規投稿</h2>
    <form action="" method="post">
      名前: <input type="text" name="name" value=""><br>
      本文: <input type="text" name="comment" value=""><br>
      <button type="submit" name="new">submit</button>
      <input type="hidden" name="token" value="<?= h(sha1(session_id())) ?>">
    </form>
  </section>
  <section>
    <h2>投稿一覧</h2>
    <?php
      $sql = "SELECT * FROM board ORDER BY id DESC";
      $rows = $pdo->query($sql);
    ?>
      <?php foreach ($rows as $row) : ?>
        <form action="" method="post">
          <?= h($row['comment']).'('.h($row['name']).')'; ?>
          <button type="submit" name="delete" value="<?= h($row['id']) ?>">削除</button>
        </form>
        <button><a href="edit.php?id=<?= $row['id']; ?>">編集</a></button>
        <br>
      <?php endforeach ; ?>
    
  </section>
</body>
</html>