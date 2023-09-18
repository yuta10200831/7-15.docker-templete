<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>収入を登録</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.17/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex justify-center">
  <div class="mx-auto my-8 w-3/5">
    <div class="container p-4 bg-white rounded shadow-lg">
      <h1 class="text-3xl mb-4 text-center">収入登録</h1>

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
        <div class="mb-4">
          <label for="income-source" class="block text-sm font-medium text-gray-600">収入源</label>
            <select id="income-source" name="income_source_id" class="mt-1 p-2 w-1/2">
              <option value="">選択してください</option>
              <option value="1">給与</option>
              <option value="2">賞与</option>
            </select>
            <a href="income_sources/index.php" class="ml-4 p-2 bg-green-500 text-white">収入源一覧へ</a>
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
