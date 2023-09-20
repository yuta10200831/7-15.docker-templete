<?php
$pdo = new PDO('mysql:host=mysql; dbname=kakeibo; charset=utf8', 'root', 'password');
$stmt = $pdo->query("SELECT * FROM spendings");
$income_sources = $stmt->fetchAll(PDO::FETCH_ASSOC);

// カテゴリデータを取得
$category_sql = "SELECT * FROM categories";
$category_stmt = $pdo->query($category_sql);
$categories = $category_stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>収入を登録</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.17/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex justify-center">

  <div class="mx-auto my-8 w-3/5">
    <!-- ヘッダーの表示 -->
    <header class="bg-blue-500 p-4">
      <nav>
        <ul class="flex justify-between">
          <li><a class="text-white hover:text-blue-800" href="/">HOME</a></li>
          <li><a class="text-white hover:text-blue-800" href="incomes/index.php">収入TOP</a></li>
          <li><a class="text-white hover:text-blue-800" href="index.php">支出TOP</a></li>
          <li><a class="text-white hover:text-blue-800" href="#">ログイン</a></li>
        </ul>
      </nav>
    </header>

    <div class="container p-4 bg-white rounded shadow-lg">
      <h1 class="text-3xl mb-4 text-center">支出登録</h1>

      <?php if (isset($_GET['error'])): ?>
      <div class="bg-red-500 text-white p-4 mb-4">
        <ul>
          <?php foreach (explode(', ', $_GET['error']) as $error): ?>
            <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endif; ?>

      <form action="store.php" method="POST">

        <div class="mb-4 flex items-center">
          <label for="name" class="block text-sm font-medium text-gray-600">支出名</label>
          <input type="text" id="name" name="name" class="mt-1 p-2 w-1/3">
        </div>

        <div class="mb-4">
          <label for="categories" class="block text-sm font-medium text-gray-600">カテゴリー：</label>
          <select id="categories" name="category_id" class="mt-1 p-2 w-1/2">
              <option value="">選択してください</option>
              <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['id']; ?>">
              <?php echo htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8'); ?>
              </option>
            <?php endforeach; ?>
          </select>
            <a href="category/index.php" class="ml-4 p-2 bg-green-500 text-white">カテゴリ一覧へ</a>
        </div>

        <div class="mb-4 flex items-center">
          <label for="amount" class="block text-sm font-medium text-gray-600">金額</label>
          <input type="text" id="amount" name="amount" class="mt-1 p-2 w-1/3">
          <span class="text-lg ml-2">円</span>
        </div>

        <div class="mb-4">
          <label for="date" class="block text-sm font-medium text-gray-600">日付</label>
          <input type="date" id="accrual_date" name="accrual_date" class="mt-1 p-2 w-1/2">
        </div>

        <div class="flex justify-between">
          <button type="submit" class="p-2 bg-blue-500 text-white">登録</button>
          <a href="index.php" class="p-2 bg-gray-500 text-white">戻る</a>
        </div>
      </form>

    </div>
  </div>
</body>
</html>