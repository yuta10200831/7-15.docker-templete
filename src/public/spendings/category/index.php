<?php
session_start();

// DB接続
$pdo = new PDO('mysql:host=mysql; dbname=kakeibo; charset=utf8', 'root', 'password');

// SQL文でデータを取得
$stmt = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>カテゴリ一覧</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.17/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex justify-center">
  <div class="w-3/5">
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

    <!-- メインコンテンツ -->
    <div class="mx-auto my-8">
      <div class="container p-4 bg-white rounded shadow-lg">
        <h1 class="text-3xl mb-4 text-center">カテゴリ一覧</h1>
        <!-- 収入源を追加するボタン -->
        <div class="mb-4">
          <a href="create.php" class="p-2 bg-blue-500 text-white">カテゴリを追加する</a>
        </div>

        <!-- 収入源のリスト -->
        <table class="w-full mb-4">
          <thead>
            <tr>
              <th class="border px-4 py-2">カテゴリ</th>
              <th class="border px-4 py-2">編集</th>
              <th class="border px-4 py-2">削除</th>
            </tr>
          </thead>
          <tbody>
          <?php
            foreach ($categories as $category) {
              echo '<tr>';
              echo '<td class="border px-4 py-2">' . htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') . '</td>';
              echo '<td class="border px-4 py-2"><a href="edit.php?id=' . $category['id'] . '" class="p-2 bg-blue-500 text-white">編集</a></td>';
              echo '<td class="border px-4 py-2"><a href="delete.php?id=' . $category['id'] . '" class="p-2 bg-red-500 text-white">削除</a></td>';
              echo '</tr>';
          }
          ?>
          </tbody>
        </table>

        <!-- 戻るボタン -->
        <div>
          <a href="/spendings/create.php" class="p-2 bg-gray-500 text-white">戻る</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>