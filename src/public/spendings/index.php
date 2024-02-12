<?php
// PDOでDBに接続
$pdo = new PDO('mysql:host=mysql; dbname=kakeibo; charset=utf8', 'root', 'password');

// カテゴリデータを取得
$category_sql = "SELECT * FROM categories";
$category_stmt = $pdo->query($category_sql);
$categories = $category_stmt->fetchAll(PDO::FETCH_ASSOC);

// 検索条件を取得
$search_category_id = $_GET['category_id'] ?? null;
$search_start_date = $_GET['start_date'] ?? null;
$search_end_date = $_GET['end_date'] ?? null;

// SQLクエリを動的に組み立てて支出データを取得
$sql = "SELECT spendings.*, categories.name AS category_name FROM spendings INNER JOIN categories ON spendings.category_id = categories.id";
$params = [];

if (!empty($search_category_id)) {
  $sql .= " WHERE spendings.category_id = ?";
  $params[] = $search_category_id;
}

if (!empty($search_start_date)) {
  $sql .= (empty($params) ? " WHERE" : " AND") . " spendings.accrual_date >= ?";
  $params[] = $search_start_date;
}

if (!empty($search_end_date)) {
  $sql .= (empty($params) ? " WHERE" : " AND") . " spendings.accrual_date <= ?";
  $params[] = $search_end_date;
}

$sql .= " ORDER BY spendings.accrual_date DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$spendings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 合計を出す処理
$total_spendings = 0;
foreach ($spendings as $spending) {
    $total_spendings += $spending['amount'];
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
          <li><a class="text-white hover:text-blue-800" href="/incomes/index.php">収入TOP</a></li>
          <li><a class="text-white hover:text-blue-800" href="#">支出TOP</a></li>
          <li><a class="text-white hover:text-blue-800" href="#">ログイン</a></li>
        </ul>
      </nav>
    </header>

    <div class="container p-4 bg-white rounded shadow-lg">
      <h1 class="text-3xl mb-4 text-center">支出</h1>

      <!-- 合計額 -->
      <div class="text-right mt-4">
      <span>合計: </span><span id="total-spendings"><?php echo $total_spendings; ?></span><span> 円</span>
      </div>

      <!-- 新規作成ボタン -->
      <div class="mt-4 text-right">
        <a href="create.php" class="inline-block p-2 bg-green-500 text-white">支出を登録する</a>
      </div>

      <!-- 検索バー -->
      <div class="flex flex-col items-center mb-4">
        <p class="mb-2">絞り込み検索</p>
        <form action="" method="GET">
          <div class="flex items-center">
            <label for="income-source" class="mr-5 flex-shrink-0">カテゴリ：</label>
            <select id="categories" name="category_id" class="mt-1 p-2 w-1/2">
              <option value="">選択してください</option>
              <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['id']; ?>">
                  <?php echo htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8'); ?>
                </option>
              <?php endforeach; ?>
            </select>

            <input type="date" name="start_date" id="start-date" class="mr-2 p-2">
            <span class="align-middle">〜</span>
            <input type="date" name="end_date" id="end-date" class="mr-2 p-2">
            <button type="submit" id="search-button" class="p-2 bg-blue-500 text-white">検索</button>
          </div>
        </form>
      </div>

      <!-- 収入テーブル -->
      <table class="mx-auto w-full border-collapse border">
        <thead>
          <tr>
            <th class="border px-4 py-2">支出名</th>
            <th class="border px-4 py-2">カテゴリ</th>
            <th class="border px-4 py-2">金額</th>
            <th class="border px-4 py-2">日付</th>
            <th class="border px-4 py-2">編集</th>
            <th class="border px-4 py-2">削除</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($spendings as $spending): ?>
            <tr>
              <td class="border px-4 py-2"><?php echo htmlspecialchars($spending['name'], ENT_QUOTES, 'UTF-8'); ?></td>
              <td class="border px-4 py-2"><?php echo htmlspecialchars($spending['category_name'], ENT_QUOTES, 'UTF-8'); ?></td>
              <td class="border px-4 py-2"><?php echo htmlspecialchars($spending['amount'], ENT_QUOTES, 'UTF-8'); ?></td>
              <td class="border px-4 py-2"><?php echo htmlspecialchars($spending['accrual_date'], ENT_QUOTES, 'UTF-8'); ?></td>
              <td class="border px-4 py-2">
            <form action="edit.php" method="GET">
              <input type="hidden" name="id" value="<?php echo $spending['id']; ?>">
              <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                編集
              </button>
            </form>
            </td>
            <td class="border px-4 py-2">
              <form action="delete.php" method="GET">
                <input type="hidden" name="id" value="<?php echo $spending['id']; ?>">
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                  削除
                </button>
              </form>
            </td>
            </tr>

            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

    </div>
  </div>
</body>
</html>