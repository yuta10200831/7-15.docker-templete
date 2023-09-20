<?php
session_start();

// セッションからエラーメッセージを取得して削除
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);

// 以下、元々のコード
$id = $_GET['id'];
$pdo = new PDO('mysql:host=mysql; dbname=kakeibo; charset=utf8', 'root', 'password');
$stmt = $pdo->prepare("SELECT * FROM spendings WHERE id = ?");
$stmt->execute([$id]);
$spending = $stmt->fetch(PDO::FETCH_ASSOC);

// カテゴリデータを取得
$category_sql = "SELECT * FROM categories";
$category_stmt = $pdo->query($category_sql);
$categories = $category_stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>支出編集</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.17/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex justify-center">

  <div class="mx-auto my-8 w-4/5">
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
      <h1 class="text-3xl mb-4 text-center">支出編集</h1>
        <!-- ここにエラーメッセージを表示 -->
        <?php if (!empty($errors)): ?>
          <div class="bg-red-100 p-4 mb-4 rounded">
            <?php foreach ($errors as $error): ?>
              <p class="text-red-500"><?= $error ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      <form action="update.php" method="POST">
        <!-- hidden ID field -->
        <input type="hidden" name="id" value="<?= $spending['id'] ?>">

        <!-- 支出名フォーム -->
        <div class="mb-4">
          <label for="expense-name">支出名：</label>
          <input type="text" id="expense-name" name="expense_name" value="<?= $spending['name'] ?>">
        </div>

        <!-- カテゴリーフォーム -->
        <div class="mb-4">
          <label for="category">カテゴリー：</label>
          <select name="category_id" id="category">
            <?php foreach ($categories as $category): ?>
              <option value="<?= $category['id'] ?>" <?= $category['id'] == $spending['category_id'] ? 'selected' : '' ?>>
                <?= $category['name'] ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- 金額フォーム -->
        <div class="mb-4">
          <label for="amount">金額</label>
          <input type="text" id="amount" name="amount" value="<?= $spending['amount'] ?>">
          <span>円</span>
        </div>

        <!-- 日付フォーム -->
        <div class="mb-4">
          <label for="date">日付</label>
          <input type="date" id="date" name="expense_date" value="<?= $spending['accrual_date'] ?>">
        </div>

        <!-- 更新ボタン -->
        <div class="text-right">
          <button type="submit" class="p-2 bg-blue-500 text-white">編集</button>
          <a href="index.php" class="p-2 bg-gray-400 text-white">戻る</a>
        </div>
      </form>
    </div>
  </div>

</body>
</html>
