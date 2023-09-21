<?php

session_start();
$error_messages = [];

$income_source = $_POST['income_source'] ?? '';

// バリデーション
if (empty($income_source)) {
    $error_messages[] = "収入源が入力されていません";
}

if (!empty($error_messages)) {
    $_SESSION['error'] = implode(', ', $error_messages);
    header('Location: create.php');
    exit;
}

// DB接続
$pdo = new PDO('mysql:host=mysql;dbname=kakeibo;charset=utf8', 'root', 'password');

// SQL文でデータを挿入
$stmt = $pdo->prepare("INSERT INTO income_sources (user_id, name) VALUES (0, :name)");
$stmt->bindParam(':name', $income_source, PDO::PARAM_STR);

// SQL実行
if (!$stmt->execute()) {
    $_SESSION['error'] = "エラーが発生しました";
    header('Location: create.php');
    exit;
}

// 成功時の処理（エラーメッセージをクリア）
unset($_SESSION['error']);
header('Location: index.php');
exit;
