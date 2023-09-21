<?php
// DB接続
$pdo = new PDO('mysql:host=mysql; dbname=kakeibo; charset=utf8', 'root', 'password');

// idで指定された収入源を削除
$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM income_sources WHERE id = ?");
$stmt->execute([$id]);

// index.phpにリダイレクト
header('Location: index.php');
?>
