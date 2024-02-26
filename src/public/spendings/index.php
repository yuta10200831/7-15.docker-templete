<?php
session_start();
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Infrastructure\Dao\SpendingsDao;
use App\Adapter\QueryService\SpendingsQueryService;
use App\UseCase\UseCaseInput\SpendingsReadInput;
use App\UseCase\UseCaseInteractor\SpendingsReadInteractor;

try {
    // 検索条件の取得
    $search_category_id = isset($_GET['category_id']) && $_GET['category_id'] !== '' ? intval($_GET['category_id']) : null;
    $search_start_date = isset($_GET['start_date']) && $_GET['start_date'] !== '' ? $_GET['start_date'] : null;
    $search_end_date = isset($_GET['end_date']) && $_GET['end_date'] !== '' ? $_GET['end_date'] : null;


    $spendingsDao = new SpendingsDao();
    $spendingsQueryService = new SpendingsQueryService($spendingsDao);
    $input = new SpendingsReadInput($search_category_id, $search_start_date, $search_end_date);
    $spendingsReadInteractor = new SpendingsReadInteractor($spendingsQueryService, $input);
    $output = $spendingsReadInteractor->handle();
    $spendings = $output->getSpendings();

    // カテゴリの取得
    $categories = $spendingsQueryService->getCategories();
    $categoryNameMap = [];
    foreach ($categories as $category) {
        $categoryNameMap[$category['id']] = $category['name'];
    }

    // 合計値の取得
    $totalSpendings = array_reduce($spendings, function ($sum, $spending) {
        return $sum + $spending['amount'];
    }, 0);
  } catch (Exception $e) {
    $_SESSION['errors'][] = "エラーが発生しました: " . $e->getMessage();
    header('Location: error.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>支出一覧</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.17/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex justify-center">
  <div class="mx-auto my-8 w-4/5">
    <header class="bg-blue-500 p-4">
      <nav>
        <ul class="flex justify-between">
          <li><a class="text-white hover:text-blue-800" href="/">HOME</a></li>
          <li><a class="text-white hover:text-blue-800" href="/incomes/index.php">収入TOP</a></li>
          <li><a class="text-white hover:text-blue-800" href="#">支出TOP</a></li>
          <li><?php if (isset($_SESSION['user']['name'])): ?><a class="text-white hover:text-blue-800"
              href="/user/logout.php">ログアウト</a><?php else: ?><a class="text-white hover:text-blue-800"
              href="/user/signin.php">ログイン</a><?php endif; ?></li>
        </ul>
      </nav>
    </header>

    <div class="mx-auto my-8 w-4/5">
      <?php if (isset($_SESSION['user']['name'])): ?><div class="text-center my-4">
        <h2 class="text-2xl text-blue-500">こんにちは、<?php echo htmlspecialchars($_SESSION['user']['name']); ?>さん</h2>
      </div><?php endif; ?>
      <h1 class="text-3xl mb-4 text-center">支出</h1>

      <div class="text-right mt-4"><span>合計: </span><span
          id="total-spendings"><?php echo $totalSpendings; ?></span><span> 円</span></div>
      <div class="mt-4 text-right"><a href="create.php" class="inline-block p-2 bg-green-500 text-white">支出を登録する</a>
      </div>

      <div class="flex flex-col items-center mb-4">
        <p class="mb-2">絞り込み検索</p>
        <form action="index.php" method="get">
          <div class="flex items-center">
            <label for="categories" class="mr-5 flex-shrink-0">カテゴリ：</label>
            <select id="categories" name="category_id" class="mt-1 p-2 w-1/2">
              <option value="">選択してください</option>
              <?php foreach ($categories as $category): ?>
              <option value="<?php echo $category['id']; ?>"
                <?php echo ($search_category_id === $category['id']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8'); ?></option>
              <?php endforeach; ?>
            </select>
            <input type="date" name="start_date" id="start-date" class="mr-2 p-2"
              value="<?php echo $search_start_date; ?>">
            <span class="align-middle">〜</span>
            <input type="date" name="end_date" id="end-date" class="mr-2 p-2" value="<?php echo $search_end_date; ?>">
            <button type="submit" id="search-button" class="p-2 bg-blue-500 text-white">検索</button>
          </div>
        </form>
      </div>

      <table class="mx-auto w-full border-collapse border border-gray-200">
        <thead>
          <tr class="bg-gray-200">
            <th class="border border-gray-700 px-4 py-2">支出名</th>
            <th class="border border-gray-700 px-4 py-2">カテゴリ</th>
            <th class="border border-gray-700 px-4 py-2">金額</th>
            <th class="border border-gray-700 px-4 py-2">日付</th>
            <th class="border border-gray-700 px-4 py-2">編集</th>
            <th class="border border-gray-700 px-4 py-2">削除</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($spendings as $spending): ?>
          <tr>
            <td class="border border-gray-200 px-4 py-2">
              <?php echo htmlspecialchars($spending['name'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td class="border border-gray-200 px-4 py-2">
              <?php echo htmlspecialchars($categoryNameMap[$spending['category_id']] ?? 'カテゴリなし', ENT_QUOTES, 'UTF-8'); ?>
            </td>
            <td class="border border-gray-200 px-4 py-2">
              <?php echo htmlspecialchars($spending['amount'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td class="border border-gray-200 px-4 py-2">
              <?php echo htmlspecialchars($spending['accrual_date'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td class="border border-gray-200 px-4 py-2">
              <form action="edit.php" method="GET"><input type="hidden" name="id"
                  value="<?php echo $spending['id']; ?>"><button type="submit"
                  class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">編集</button></form>
            </td>
            <td class="border border-gray-200 px-4 py-2">
              <form action="delete.php" method="GET"><input type="hidden" name="id"
                  value="<?php echo $spending['id']; ?>"><button type="submit"
                  class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">削除</button></form>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>