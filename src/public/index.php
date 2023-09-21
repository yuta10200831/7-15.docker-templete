<?php
session_start();

$pdo = new PDO('mysql:host=mysql; dbname=kakeibo; charset=utf8', 'root', 'password');

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>トップページ</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.17/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
  <div class="mx-auto my-8 w-4/5">
    <header class="bg-blue-500 p-4">
      <nav>
        <ul class="flex justify-between">
          <li>
            <a class="text-white hover:text-blue-800" href="/">HOME</a>
          </li>
          <li>
            <a class="text-white hover:text-blue-800" href="incomes/index.php">収入TOP</a>
          </li>
          <li>
            <a class="text-white hover:text-blue-800" href="spendings/index.php">支出TOP</a>
          </li>
          <li>
            <?php if (isset($_SESSION['username'])): ?>
              <a class="text-white hover:text-blue-800" href="user/logout.php">ログアウト</a>
            <?php else: ?>
              <a class="text-white hover:text-blue-800" href="user/signin.php">ログイン</a>
            <?php endif; ?>
          </li>
        </ul>
      </nav>
    </header>

    <main class="p-4">
      <div class="text-center my-8">
        <h1 class="text-4xl mb-4">家計簿アプリ</h1>
      </div>
      <div class="my-4 flex justify-center items-center">
        <select id="year-select" class="border rounded p-2 mr-4">
          <option value="2021">2014</option>
          <option value="2021">2015</option>
          <option value="2021">2016</option>
          <option value="2021">2017</option>
          <option value="2021">2018</option>
          <option value="2021">2019</option>
          <option value="2021">2020</option>
          <option value="2021">2021</option>
          <option value="2021">2022</option>
          <option value="2022">2023</option>
        </select>
        <label for="year-select" class="mr-2">年の収支一覧</label>
        <button id="search-button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
          検索
        </button>
      </div>
      <table class="min-w-full table-auto mx-auto mt-8 border border-gray-300">
        <thead class="border-b-2">
          <tr>
            <th class="px-4 py-2">月</th>
            <th class="px-4 py-2">収入合計</th>
            <th class="px-4 py-2">支出合計</th>
            <th class="px-4 py-2">収支合計</th>
          </tr>
        </thead>
        <tbody>
          <!-- ここにデータを入れる -->
        </tbody>
      </table>
    </main>
  </div>
</body>
</html>
