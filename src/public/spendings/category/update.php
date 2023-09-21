<?php
// POSTデータを受け取る
$id = $_POST['id'];
$name = $_POST['name'];

// DB接続
$pdo = new PDO('mysql:host=mysql; dbname=kakeibo; charset=utf8', 'root', 'password');

// 入力値が空だった場合
if (empty($name)) {
    header("Location: edit.php?id=$id&error=カテゴリ名が入力されていません");
    exit;
}

// 同じカテゴリ名がすでに存在する場合
$stmt = $pdo->prepare("SELECT * FROM categories WHERE name = :name AND id != :id");
$stmt->bindParam(':name', $name);
$stmt->bindParam(':id', $id);
$stmt->execute();
$existing_category = $stmt->fetch(PDO::FETCH_ASSOC);

if ($existing_category) {
    header("Location: edit.php?id=$id&error=このカテゴリ名はすでに存在しています");
    exit;
}

// 更新処理
$stmt = $pdo->prepare("UPDATE categories SET name = :name WHERE id = :id");
$stmt->bindParam(':name', $name);
$stmt->bindParam(':id', $id);
$stmt->execute();

header("Location: index.php");
?>
