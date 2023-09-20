<?php

// エラーメッセージを保存する配列
$error_messages = [];

// POSTで送られてきたデータを取得
$id = $_POST['id'] ?? null;
$amount = $_POST['amount'] ?? null;
$accrual_date = $_POST['accrual_date'] ?? null;
$income_source_id = $_POST['income_source_id'] ?? null;

// バリデーション
if (empty($id)) $error_messages[] = "IDがありません";
if (empty($amount)) $error_messages[] = "金額が入力されていません";
if (empty($accrual_date)) $error_messages[] = "日付が選択されていません";
if (empty($income_source_id)) $error_messages[] = "収入源が選択されていません";

// エラーがあればリダイレクトして終了
if (!empty($error_messages)) {
  header("Location: edit.php?id=$id&error=" . urlencode(implode(', ', $error_messages)));
  exit;
}

// DB接続
$pdo = new PDO('mysql:host=mysql; dbname=kakeibo; charset=utf8', 'root', 'password');

// DBへの保存
$stmt = $pdo->prepare("UPDATE incomes SET amount = ?, accrual_date = ?, income_source_id = ? WHERE id = ?");
$result = $stmt->execute([$amount, $accrual_date, $income_source_id, $id]);

// 保存失敗した場合リダイレクトして終了
if (!$result) {
  header("Location: edit.php?id=$id&error=更新失敗");
  exit;
}

// 保存成功
header("Location: index.php");
exit;
?>
