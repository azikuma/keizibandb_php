<?php

function h($str) {
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

define('DB_USERNAME', 'b86818c060ec83');
define('DB_PASSWORD', '9074b583');
define('PDO_DSN', 'mysql:dbhost=us-cdbr-iron-east-03.cleardb.net;dbname=heroku_b93c4fe3677875d');

try {
  // connect
  $pdo = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //
} catch (PDOException $e) {
  echo $e->getMessage();
  exit;
}

if (isset($_POST['push'])) {
  $name = $_POST['name'];
  $comment = $_POST['comment'];
  $stmt = $pdo->prepare("INSERT INTO board (name, comment) VALUES (:name, :comment)");
  $stmt->bindParam(':name', $name, PDO::PARAM_STR);
  $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
  $stmt->execute();
  $pdo->query($stmt);
  header("Location: " . $_SERVER['PHP_SELF']);
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
      <button type="submit" name="push">submit</button>
      <input type="hidden" name="token" value="<?= h(sha1(session_id())) ?>">
    </form>
  </section>
  <section>
    <h2>投稿一覧</h2>
    <?php
      $sql = "SELECT * FROM board ORDER BY id DESC";
      $rows = $pdo->query($sql);
      foreach ($rows as $row) {
        echo h($row['comment']).'('.h($row['name']).')';
        echo '<br>';
      }
    ?>
  </section>
</body>
</html>