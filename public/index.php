<?php
//コメント

function h($str) {
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

$db = parse_url($_SERVER['CLEARDB_DATABASE_URL']);
$db['dbname'] = ltrim($db['path'], '/');
$dsn = "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8";

try {
  // connect
  $pdo = new PDO($dsn, $db['user'], $db['pass']);
  $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


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