<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>収入一覧</title>
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
          <li><a class="text-white hover:text-blue-800" href="#">支出TOP</a></li>
          <li><a class="text-white hover:text-blue-800" href="#">ログイン</a></li>
        </ul>
      </nav>
    </header>

    <div class="container p-4 bg-white rounded shadow-lg">
      <h1 class="text-3xl mb-4 text-center">収入</h1>
      <!-- 合計額 -->
      <div class="text-right mt-4">
        <span>合計: </span><span id="total-income">0</span><span> 円</span>
      </div>

      <!-- 新規作成ボタン -->
      <div class="mt-4 text-right">
        <a href="create.php" class="inline-block p-2 bg-green-500 text-white">収入を登録する</a>
      </div>

      <!-- 検索バー -->
      <div class="flex flex-col items-center mb-4">
        <p class="mb-2">絞り込み検索</p>
        <div class="flex items-center">
          <span class="mr-2">収入源：</span>
          <select id="income-source" class="mr-2 p-2">
            <option value="">すべてのカテゴリ</option>
            <option value="給与">給与</option>
            <option value="賞与">賞与</option>
            <!-- 他の収入源 -->
          </select>
          <input type="date" id="start-date" class="mr-2 p-2">
          <span class="align-middle">〜</span>
          <input type="date" id="end-date" class="mr-2 p-2">
          <button id="search-button" class="p-2 bg-blue-500 text-white">検索</button>
        </div>
      </div>

      <!-- 収入テーブル -->
      <table class="mx-auto w-full border-collapse border">
        <thead>
          <tr>
            <th class="border px-4 py-2">収入名</th>
            <th class="border px-4 py-2">金額</th>
            <th class="border px-4 py-2">日付</th>
            <th class="border px-4 py-2">編集</th>
            <th class="border px-4 py-2">削除</th>
          </tr>
        </thead>
        <tbody>
          <!-- ここにデータ -->
        </tbody>
      </table>

    </div>
  </div>
</body>
</html>
