<?php
session_start();

$name = $_POST['name'] ?? null;
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;
$password_confirm = $_POST['password_confirm'] ?? null;

if (!$name || !$email || !$password || !$password_confirm) {
  $_SESSION['error_message'] = 'EmailかPasswordの入力がありません';
  header('Location: signup.php');
  exit;
}

if ($password !== $password_confirm) {
  $_SESSION['error_message'] = 'パスワードが一致しません';
  header('Location: signup.php');
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>登録確認</title>
</head>
<body>
  <h1>以下の内容で登録してよろしいですか？</h1>
  <p>ユーザー名: <?php echo htmlspecialchars($name); ?></p>
  <p>メールアドレス: <?php echo htmlspecialchars($email); ?></p>
  <p>パスワード: <?php echo str_repeat('*', strlen($password)); ?></p>

  <!-- ここに送信ボタンと、hiddenフィールドでPOSTデータを次に送る -->
  <form action="signup_complete.php" method="post">
    <input type="hidden" name="name" value="<?php echo htmlspecialchars($name); ?>">
    <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
    <input type="hidden" name="password" value="<?php echo htmlspecialchars($password); ?>">
    <input type="hidden" name="password_confirm" value="<?php echo htmlspecialchars($password_confirm); ?>">
    <input type="submit" value="確認して登録">
  </form>
</body>
</html>
