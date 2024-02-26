<?php
session_start();
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Infrastructure\Dao\IncomesDao;
use App\Adapter\QueryService\IncomesQueryService;
use App\UseCase\UseCaseInput\IncomesReadInput;
use App\UseCase\UseCaseInteractor\IncomesReadInteractor;

$incomesDao = new IncomesDao();
$incomesQueryService = new IncomesQueryService($incomesDao);

// 検索条件を取得
$search_income_source_id = $_GET['income_source_id'] ?? null;
$search_start_date = $_GET['start_date'] ?? null;
$search_end_date = $_GET['end_date'] ?? null;

$input = new IncomesReadInput($search_income_source_id, $search_start_date, $search_end_date);

$incomesReadInteractor = new IncomesReadInteractor($incomesQueryService, $input);
$output = $incomesReadInteractor->handle();
$incomes = $output->getIncomes();
$incomeSources = $incomesQueryService->fetchIncomeSources();

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
          <li><a class="text-white hover:text-blue-800" href="/spendings/index.php">支出TOP</a></li>
          <li>
            <?php if (isset($_SESSION['user']['name'])): ?>
            <a class="text-white hover:text-blue-800" href="/user/logout.php">ログアウト</a>
            <?php else: ?>
            <a class="text-white hover:text-blue-800" href="/user/signin.php">ログイン</a>
            <?php endif; ?>
          </li>
        </ul>
      </nav>
    </header>


    <div class="mx-auto my-8 w-4/5">
      <?php if (isset($_SESSION['user']['name'])): ?>
      <div class="text-center my-4">
        <h2 class="text-2xl text-blue-500">こんにちは、<?php echo htmlspecialchars($_SESSION['user']['name']); ?>さん</h2>
      </div>
      <?php endif; ?>
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
      <form action="index.php" method="GET">
        <div class="flex flex-col items-center mb-8">
          <p class="mb-2">絞り込み検索</p>
          <div class="flex items-center">
            <label for="income-source" class="mr-5 flex-shrink-0">収入源：</label>
            <select id="income-source" name="income_source_id" class="mt-1 p-2 w-1/2">
              <option value="">選択してください</option>
              <?php foreach ($incomeSources as $incomeSource): ?>
              <option value="<?php echo $incomeSource['id']; ?>">
                <?php echo htmlspecialchars($incomeSource['name'], ENT_QUOTES, 'UTF-8'); ?>
              </option>
              <?php endforeach; ?>
            </select>
            <input type="date" name="start_date" id="start-date" class="mr-2 p-2">
            <span class="align-middle">〜</span>
            <input type="date" name="end_date" id="end-date" class="mr-2 p-2">
            <button type="submit" id="search-button" class="p-2 bg-blue-500 text-white">検索</button>
          </div>
        </div>
      </form>

      <!-- 収入テーブル -->
      <table class="mx-auto w-full border-collapse border border-gray-200">
        <thead>
          <tr class="bg-gray-200">
            <th class="border border-gray-700 px-4 py-2">収入名</th>
            <th class="border border-gray-700 px-4 py-2">金額</th>
            <th class="border border-gray-700 px-4 py-2">日付</th>
            <th class="border border-gray-700 px-4 py-2">編集</th>
            <th class="border border-gray-700 px-4 py-2">削除</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($incomes as $income): ?>
          <tr>
            <td class="border border-gray-200 px-4 py-2">
              <?php echo htmlspecialchars($income['income_source_name'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td class="border border-gray-200 px-4 py-2">
              <?php echo htmlspecialchars($income['amount'], ENT_QUOTES, 'UTF-8'); ?>円</td>
            <td class="border border-gray-200 px-4 py-2">
              <?php echo htmlspecialchars($income['accrual_date'], ENT_QUOTES, 'UTF-8'); ?>
            </td>
            <td class="border border-gray-200 px-4 py-2"><a href="edit.php?id=<?php echo $income['id']; ?>"
                class="p-2 bg-blue-500 text-white">編集</a></td>
            <td class="border border-gray-200 px-4 py-2"><a href="delete.php?id=<?php echo $income['id']; ?>"
                class="p-2 bg-red-500 text-white">削除</a></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

    </div>
  </div>
</body>

</html>