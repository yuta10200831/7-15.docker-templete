<?php
session_start();
require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Infrastructure\Dao\IncomeSourcesDao;
use App\Adapter\QueryService\IncomeSourcesQueryService;
use App\Domain\ValueObject\User\UserId;
use App\UseCase\UseCaseInput\IncomeSourcesReadInput;
use App\UseCase\UseCaseInteractor\IncomeSourcesReadInteractor;

$userId = new UserId($_SESSION['user']['id']);

try {
    $input = new IncomeSourcesReadInput($userId);
    $incomeSourcesDao = new IncomeSourcesDao();
    $queryService = new IncomeSourcesQueryService($incomeSourcesDao);
    $interactor = new IncomeSourcesReadInteractor($queryService, $input);
    $output = $interactor->handle();

    $incomeSources = $output->getIncomeSources();
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
  <title>収入源一覧</title>
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

    <!-- メインコンテンツ -->
    <div class="mx-auto my-8 w-4/5">
      <div class="container p-4 bg-white rounded shadow-lg">
        <h1 class="text-3xl mb-4 text-center">収入源一覧</h1>
        <!-- 収入源を追加するボタン -->
        <div class="mb-4">
          <a href="create.php" class="p-2 bg-blue-500 text-white">収入源を追加する</a>
        </div>

        <!-- 収入源のリスト -->
        <table class="mx-auto w-full border-collapse border border-gray-200">
          <thead>
            <tr class="bg-gray-200">
              <th class="border px-4 py-2">収入源</th>
              <th class="border px-4 py-2">編集</th>
              <th class="border px-4 py-2">削除</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (!empty($incomeSources)) {
                foreach ($incomeSources as $incomeSource) {
                    echo '<tr>';
                    echo '<td class="border px-4 py-2">' . htmlspecialchars($incomeSource->getIncomeSourcesName(), ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td class="border px-4 py-2"><a href="edit.php?id=' . htmlspecialchars($incomeSource->getUserId(), ENT_QUOTES, 'UTF-8') . '" class="p-2 bg-blue-500 text-white">編集</a></td>';
                    echo '<td class="border px-4 py-2"><a href="delete.php?id=' . htmlspecialchars($incomeSource->getUserId(), ENT_QUOTES, 'UTF-8') . '" class="p-2 bg-red-500 text-white">削除</a></td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="3">データがありません</td></tr>';
            }
            ?>
          </tbody>
        </table>

        <!-- 戻るボタン -->
        <div>
          <a href="/incomes/create.php" class="p-2 bg-gray-500 text-white">戻る</a>
        </div>
      </div>
    </div>
  </div>
</body>

</html>