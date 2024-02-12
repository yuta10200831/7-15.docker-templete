<?php
session_start();

$selected_year = $_GET['selected_year'] ?? date('Y');

$pdo = new PDO('mysql:host=mysql; dbname=kakeibo; charset=utf8', 'root', 'password');

$sql = "
SELECT
  MONTH(accrual_date) AS month,
  SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) AS total_income,
  SUM(CASE WHEN type = 'spending' THEN amount ELSE 0 END) AS total_spend
FROM (
  SELECT accrual_date, amount, 'income' AS type FROM incomes
  UNION ALL
  SELECT accrual_date, amount, 'spending' AS type FROM spendings
) AS combined
WHERE YEAR(accrual_date) = ?
GROUP BY MONTH(accrual_date)
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$selected_year]);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 1から12までの月で初期化
$months = range(1, 12);
$fixed_data = [];

foreach ($months as $month) {
  $fixed_data[$month] = ['month' => $month, 'total_income' => 0, 'total_spend' => 0];
}

foreach ($data as $row) {
  $month = $row['month'];
  $fixed_data[$month] = $row;
}

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
          <li><a class="text-white hover:text-blue-800" href="/">HOME</a></li>
          <li><a class="text-white hover:text-blue-800" href="incomes/index.php">収入TOP</a></li>
          <li><a class="text-white hover:text-blue-800" href="spendings/index.php">支出TOP</a></li>
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
        <form action="index.php" method="get">
          <select name="selected_year" id="year-select" class="border rounded p-2 mr-4">
            <option value="2021" <?php if($selected_year == "2021") echo "selected"; ?>>2021</option>
            <option value="2022" <?php if($selected_year == "2022") echo "selected"; ?>>2022</option>
            <option value="2023" <?php if($selected_year == "2023") echo "selected"; ?>>2023</option>
          </select>
          <label for="year-select" class="mr-2">年の収支一覧</label>
          <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">検索</button>
        </form>
      </div>
      <table class="min-w-full table-auto mx-auto mt-8 border border-gray-300 shadow-lg">
        <thead class="bg-gray-200">
          <tr>
            <th class="px-4 py-2 border">月</th>
            <th class="px-4 py-2 border">収入</th>
            <th class="px-4 py-2 border">支出</th>
            <th class="px-4 py-2 border">収支</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($fixed_data as $row): ?>
            <tr class="hover:bg-gray-100">
              <td class="border px-4 py-2 text-center"><?php echo $row['month']; ?></td>
              <td class="border px-4 py-2 text-center"><?php echo number_format($row['total_income']); ?>円</td>
              <td class="border px-4 py-2 text-center"><?php echo number_format($row['total_spend']); ?>円</td>
              <td class="border px-4 py-2 text-center"><?php echo number_format($row['total_income'] - $row['total_spend']); ?>円</td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </main>
  </div>
</body>
</html>
