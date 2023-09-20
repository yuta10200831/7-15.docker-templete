<?php
session_start();  // セッションを開始

$errors = [];

// ガード節でPOSTデータがあるかチェック
if (empty($_POST['expense_name'])) {
  $errors['expense_name'] = '支出名が入力されていません';
}
if (empty($_POST['amount'])) {
  $errors['amount'] = '金額が入力されていません';
}
if (empty($_POST['expense_date'])) {
  $errors['expense_date'] = '日付が入力されていません';
}
if (empty($_POST['category_id'])) {
  $errors['category_id'] = 'カテゴリが入力されていません';
}

if (!empty($errors)) {
  $_SESSION['errors'] = $errors;
  header("Location: edit.php?id=" . $_POST['id']);
  exit;
}

// 以下、DB処理（ここはそのまま）
$id = $_POST['id'];
$name = $_POST['expense_name'];
$category_id = $_POST['category_id'];
$amount = $_POST['amount'];
$accrual_date = $_POST['expense_date'];

$pdo = new PDO('mysql:host=mysql; dbname=kakeibo; charset=utf8', 'root', 'password');
$stmt = $pdo->prepare("UPDATE spendings SET name = ?, category_id = ?, amount = ?, accrual_date = ? WHERE id = ?");
$result = $stmt->execute([$name, $category_id, $amount, $accrual_date, $id]);


header("Location: index.php");
exit;
