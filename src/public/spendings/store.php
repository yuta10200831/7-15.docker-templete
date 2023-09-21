<?php

// エラーメッセージを保存する配列
$error_messages = [];

// POSTで送られてきたデータを取得
$name = $_POST['name'] ?? null;
$category_id = $_POST['category_id'] ?? null;
$amount = $_POST['amount'] ?? null;
$accrual_date = $_POST['accrual_date'] ?? null;

// バリデーション
if (empty($name)) $error_messages[] = "支出名が入力されていません";
if (empty($category_id)) $error_messages[] = "カテゴリーが選択されていません";
if (empty($amount)) $error_messages[] = "金額が入力されていません";
if (empty($accrual_date)) $error_messages[] = "日付が選択されていません";

// エラーがあればリダイレクトして終了
if (!empty($error_messages)) {
  header("Location: create.php?error=" . urlencode(implode(', ', $error_messages)));
  exit;
}

// DB接続
$pdo = new PDO('mysql:host=mysql; dbname=kakeibo; charset=utf8', 'root', 'password');

// DBへの保存
$stmt = $pdo->prepare("INSERT INTO spendings (user_id, name, category_id, amount, accrual_date) VALUES (?, ?, ?, ?, ?)");
$result = $stmt->execute([0, $name, $category_id, $amount, $accrual_date]);

// 保存失敗した場合リダイレクトして終了
if (!$result) {
  header("Location: create.php?error=登録失敗");
  exit;
}

// 保存成功
header("Location: index.php");
exit;