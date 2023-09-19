<?php
$pdo = new PDO('mysql:host=mysql; dbname=kakeibo; charset=utf8', 'root', 'password');

$stmt = $pdo->query("SELECT * FROM income_sources");
$income_sources = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->query("SELECT * FROM incomes");
$incomes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->query("SELECT incomes.*, income_sources.name AS income_source_name FROM incomes INNER JOIN income_sources ON incomes.income_source_id = income_sources.id");
$incomes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 合計を出す処理
$total_income = 0;
foreach ($incomes as $income) {
    $total_income += $income['amount'];
}

?>

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
          <li><a class="text-white hover:text-blue-800" href="#">収入TOP</a></li>
          <li><a class="text-white hover:text-blue-800" href="#">支出TOP</a></li>
          <li><a class="text-white hover:text-blue-800" href="#">ログイン</a></li>
        </ul>
      </nav>
    </header>

    <div class="container p-4 bg-white rounded shadow-lg">
      <h1 class="text-3xl mb-4 text-center">収入</h1>
      <!-- 合計額 -->
      <div class="text-right mt-4">
        <span>合計: </span><span id="total-income"><?php echo $total_income; ?></span><span> 円</span>
      </div>

      <!-- 新規作成ボタン -->
      <div class="mt-4 text-right">
        <a href="create.php" class="inline-block p-2 bg-green-500 text-white">収入を登録する</a>
      </div>

      <!-- 検索バー -->
      <div class="flex flex-col items-center mb-8">
        <p class="mb-2">絞り込み検索</p>
        <div class="flex items-center">
        <label for="income-source" class="mr-5 flex-shrink-0">収入源：</label>
          <select id="income-source" name="income_source_id" class="mt-1 p-2 w-1/2">
              <option value="">選択してください</option>
              <?php foreach ($income_sources as $income_source): ?>
                <option value="<?php echo $income_source['id']; ?>">
              <?php echo htmlspecialchars($income_source['name'], ENT_QUOTES, 'UTF-8'); ?>
              </option>
            <?php endforeach; ?>
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
        <?php foreach ($incomes as $income): ?>
          <tr>
            <td class="border px-4 py-2"><?php echo htmlspecialchars($income['income_source_name'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td class="border px-4 py-2"><?php echo htmlspecialchars($income['amount'], ENT_QUOTES, 'UTF-8'); ?>円</td>
            <td class="border px-4 py-2"><?php echo htmlspecialchars($income['accrual_date'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td class="border px-4 py-2"><a href="edit.php?id=<?php echo $income['id']; ?>" class="p-2 bg-blue-500 text-white">編集</a></td>
            <td class="border px-4 py-2"><a href="delete.php?id=<?php echo $income['id']; ?>" class="p-2 bg-red-500 text-white">削除</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      </table>

    </div>
  </div>
</body>
</html>
