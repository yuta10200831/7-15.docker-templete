<?php
session_start();  // セッション開始

// POSTからデータを取得
$id = $_POST['id'];
$name = $_POST['name'];

// 名前のバリデーション
if (empty($name)) {
    $_SESSION['error_message'] = '収入源名が入力されていません。';
    header('Location: edit.php?id=' . $id);
    exit();
}

// POSTからデータを取得、確認
if (!isset($_POST['id']) || !isset($_POST['name'])) {
  header('Location: error.php');
  exit();
}

// DB接続
$pdo = new PDO('mysql:host=mysql; dbname=kakeibo; charset=utf8', 'root', 'password');

// 更新処理
$stmt = $pdo->prepare("UPDATE income_sources SET name = ? WHERE id = ?");
$stmt->execute([$name, $id]);

// index.phpにリダイレクト
header('Location: index.php');
exit();
?>
