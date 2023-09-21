<?php
session_start();

// URLからIDを取得
$id = $_GET['id'];

// DB接続
$pdo = new PDO('mysql:host=mysql; dbname=kakeibo; charset=utf8', 'root', 'password');

// IDに一致するカテゴリデータを取得
$stmt = $pdo->prepare("SELECT * FROM categories WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$category = $stmt->fetch(PDO::FETCH_ASSOC);

// ガード節でカテゴリがない場合はindex.phpにリダイレクト
if (!$category) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>カテゴリ編集</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.17/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex justify-center">
  <div class="mx-auto my-8 w-3/5">
    <!-- ヘッダーの表示 -->
    <header class="bg-blue-500 p-4">
      <nav>
        <ul class="flex justify-between">
          <li><a class="text-white hover:text-blue-800" href="/">HOME</a></li>
          <li><a class="text-white hover:text-blue-800" href="/incomes/index.php">収入TOP</a></li>
          <li><a class="text-white hover:text-blue-800" href="/spendings/index.php">支出TOP</a></li>
          <li>
            <?php if (isset($_SESSION['username'])): ?>
              <a class="text-white hover:text-blue-800" href="/user/logout.php">ログアウト</a>
            <?php else: ?>
              <a class="text-white hover:text-blue-800" href="/user/signin.php">ログイン</a>
            <?php endif; ?>
          </li>
        </ul>
      </nav>
    </header>

    <div class="container p-4 bg-white rounded shadow-lg">
      <?php if (isset($_GET['error'])): ?>
        <div class="bg-red-500 text-white p-4 rounded text-center w-full">
          <?php echo htmlspecialchars(urldecode($_GET['error']), ENT_QUOTES, 'UTF-8'); ?>
        </div>
      <?php endif; ?>

      <h1 class="text-3xl mb-4 text-center">編集</h1>
      <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $category['id']; ?>">

        <div class="mb-4">
          <label for="category-name">カテゴリ名：</label>
          <input type="text" id="category-name" name="name" value="<?php echo htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8'); ?>">
        </div>

        <div class="text-right">
          <button type="submit" class="p-2 bg-blue-500 text-white">更新</button>
          <a href="index.php" class="p-2 bg-gray-400 text-white">戻る</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
