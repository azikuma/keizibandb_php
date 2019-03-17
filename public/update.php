<?php 
require("dbconnect.php");



if (isset($_POST['push'])) {
  $name = $_POST['name'];
  $comment = $_POST['comment'];
  $id = $_POST['edit_id'];
  $stmt = $pdo->prepare("UPDATE board SET name=?,comment=? WHERE id=?");
  $stmt->execute(array($name, $comment, $id));
  header("Location: index.php");
}
?>