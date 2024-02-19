<?php

session_start();
require_once __DIR__ . '/../vendor/autoload.php';

use App\Adapter\QueryService\IndexQueryService;
use App\Infrastructure\Dao\IndexDao;

$selected_year = $_GET['selected_year'] ?? date('Y');

try {
    $indexDao = new IndexDao();
    $indexQueryService = new IndexQueryService($indexDao);

    $search_category_id = $_GET['category_id'] ?? null;
    $search_start_date = $_GET['start_date'] ?? null;
    $search_end_date = $_GET['end_date'] ?? null;

    $spendings = $indexQueryService->getSpendingsWithFilter($selected_year, $search_category_id, $search_start_date, $search_end_date);
    $incomes = $indexQueryService->getIncomesWithFilter($selected_year, $search_category_id, $search_start_date, $search_end_date);

    $total_spendings = array_sum(array_map(function($spending) {
        return $spending->getAmount();
    }, $spendings));

    $total_incomes = array_sum(array_map(function($income) {
        return $income->getAmount();
    }, $incomes));

    $fixed_data = [];
    foreach ($spendings as $spending) {
        $month = $spending->getAccrualDate()->format('Y-m');
        if (!isset($fixed_data[$month])) {
            $fixed_data[$month] = ['month' => $month, 'total_income' => 0, 'total_spend' => 0];
        }
        $fixed_data[$month]['total_spend'] += $spending->getAmount();
    }

    foreach ($incomes as $income) {
        $month = $income->getAccrualDate()->format('Y-m');
        if (!isset($fixed_data[$month])) {
            $fixed_data[$month] = ['month' => $month, 'total_income' => 0, 'total_spend' => 0];
        }
        $fixed_data[$month]['total_income'] += $income->getAmount();
    }

} catch (Exception $e) {
    $_SESSION['errors'][] = $e->getMessage();
    header('Location: error.php');
    exit;
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
            <?php if (isset($_SESSION['user']['name'])): ?>
            <a class="text-white hover:text-blue-800" href="user/logout.php">ログアウト</a>
            <?php else: ?>
            <a class="text-white hover:text-blue-800" href="user/signin.php">ログイン</a>
            <?php endif; ?>
          </li>
        </ul>
      </nav>
    </header>
    <main class="p-4">
      <?php if (isset($_SESSION['user']['name'])): ?>
      <div class="text-center my-4">
        <h2 class="text-2xl text-blue-500">こんにちは、<?php echo htmlspecialchars($_SESSION['user']['name']); ?>さん</h2>
      </div>
      <?php endif; ?>
      <div class="text-center my-8">
        <h1 class="text-4xl mb-4">家計簿アプリ</h1>
      </div>
      <div class="my-4 flex justify-center items-center">
        <form action="index.php" method="get">
          <select name="selected_year" id="year-select" class="border rounded p-2 mr-4">
            <option value="2023" <?php if($selected_year == "2023") echo "selected"; ?>>2023</option>
            <option value="2022" <?php if($selected_year == "2022") echo "selected"; ?>>2022</option>
            <option value="2021" <?php if($selected_year == "2021") echo "selected"; ?>>2021</option>
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
          <?php foreach ($fixed_data as $data): ?>
          <tr class="hover:bg-gray-100">
            <td class="border px-4 py-2 text-center"><?php echo htmlspecialchars($data['month']); ?></td>
            <td class="border px-4 py-2 text-center">
              <?php echo htmlspecialchars(number_format($data['total_income'])); ?>円</td>
            <td class="border px-4 py-2 text-center">
              <?php echo htmlspecialchars(number_format($data['total_spend'])); ?>円</td>
            <td class="border px-4 py-2 text-center">
              <?php echo htmlspecialchars(number_format($data['total_income'] - $data['total_spend'])); ?>円
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </main>
  </div>
</body>

</html>