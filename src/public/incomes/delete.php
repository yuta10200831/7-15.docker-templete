<?php
$pdo = new PDO('mysql:host=mysql; dbname=kakeibo; charset=utf8', 'root', 'password');
$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM incomes WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

header('Location: index.php');
?>
