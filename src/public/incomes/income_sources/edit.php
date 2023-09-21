<?php
session_start();

$error_message = '';
if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}

// GETからIDを取得
$id = $_GET['id'];

// DB接続
$pdo = new PDO('mysql:host=mysql; dbname=kakeibo; charset=utf8', 'root', 'password');

// IDを元にデータを取得
$stmt = $pdo->prepare("SELECT * FROM income_sources WHERE id = ?");
$stmt->execute([$id]);
$income_source = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>収入源編集</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.17/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex justify-center">
  <div class="w-full flex flex-col items-center">
    <!-- ヘッダーの表示 -->
    <header class="bg-blue-500 p-4 w-3/5">
      <nav>
        <ul class="flex justify-between">
          <li><a class="text-white hover:text-blue-800" href="/">HOME</a></li>
          <li><a class="text-white hover:text-blue-800" href="/incomes/index.php">収入TOP</a></li>
          <li><a class="text-white hover:text-blue-800" href="#">支出TOP</a></li>
          <li><a class="text-white hover:text-blue-800" href="#">ログイン</a></li>
        </ul>
      </nav>
    </header>
    <div class="w-3/5">
      <div class="mx-auto my-8">
        <div class="container p-4 bg-white rounded shadow-lg">
          <h1 class="text-3xl mb-4 text-center">編集</h1>
          <!-- エラーメッセージの表示 -->
          <?php if ($error_message): ?>
            <div class="bg-red-500 text-white p-4 rounded">
                <?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?>
            </div>
          <?php endif; ?>
          <!-- フォームの表示 -->
          <form action="update.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <label for="name">収入源：</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($income_source['name'], ENT_QUOTES, 'UTF-8'); ?>" class="p-2">
            <button type="submit" class="p-2 bg-green-500 text-white mt-4">更新</button>
          </form>
          <div class="mt-4">
            <a href="index.php" class="p-2 bg-gray-500 text-white">戻る</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
