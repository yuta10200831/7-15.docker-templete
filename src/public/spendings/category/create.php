<?php
session_start();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>カテゴリ追加</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.17/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex justify-center">
  <div class="mx-auto my-8 w-3/5">
    <header class="bg-blue-500 p-4 rounded-t shadow-lg">
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

    <div class="container p-4 bg-white rounded-b shadow-lg">
      <?php
      // エラーメッセージがあれば表示
      if (isset($_SESSION['error_message'])) {
        echo '<div class="bg-red-500 text-white p-3 mb-2">' . $_SESSION['error_message'] . '</div>';
        unset($_SESSION['error_message']);
      }
      ?>

      <h1 class="text-3xl mb-4 text-center">カテゴリ追加</h1>

      <form action="store.php" method="post">
        <div class="mb-4">
          <label>カテゴリ名：</label>
          <input type="text" name="categoryName" class="border p-2">
        </div>

        <div class="mb-4">
          <button type="submit" class="p-2 bg-blue-500 text-white">登録</button>
        </div>
      </form>

      <div>
        <a href="index.php" class="p-2 bg-gray-500 text-white">戻る</a>
      </div>
    </div>
  </div>
</body>

</html>