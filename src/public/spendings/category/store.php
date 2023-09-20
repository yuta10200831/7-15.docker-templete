<?php

session_start();
$error_messages = [];

$categories = $_POST['categories'] ?? '';

// バリデーション
if (empty($categories)) {
    $error_messages[] = "カテゴリ名が入力されていません";
}

// DB接続
$pdo = new PDO('mysql:host=mysql;dbname=kakeibo;charset=utf8', 'root', 'password');

// 既に存在するカテゴリかどうかをチェック
$checkStmt = $pdo->prepare("SELECT * FROM categories WHERE name = :name");
$checkStmt->bindParam(':name', $categories, PDO::PARAM_STR);
$checkStmt->execute();

// カテゴリが既に存在する場合はエラーメッセージを設定
if ($checkStmt->fetch()) {
    $error_messages[] = "既に登録済みのカテゴリです";
}

// エラーメッセージが存在する場合はセッションに保存してリダイレクト
if (!empty($error_messages)) {
    $_SESSION['error'] = implode(', ', $error_messages);
    header('Location: create.php');
    exit;
}

// SQL文でデータを挿入
$stmt = $pdo->prepare("INSERT INTO categories (user_id, name) VALUES (0, :name)");
$stmt->bindParam(':name', $categories, PDO::PARAM_STR);

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
