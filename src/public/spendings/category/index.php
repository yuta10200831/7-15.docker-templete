<?php
session_start();
require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Infrastructure\Dao\CategoryDao;
use App\Adapter\QueryService\CategoryQueryService;
use App\UseCase\UseCaseInput\CategoryReadInput;
use App\UseCase\UseCaseInteractor\CategoryReadInteractor;
use App\UseCase\UseCaseOutput\CategoryReadOutput;

try {
    $categoryDao = new CategoryDao();
    $queryService = new CategoryQueryService($categoryDao);
    $categoryInput = new CategoryReadInput('');
    $categoryInteractor = new CategoryReadInteractor($queryService, $categoryInput);
    $output = $categoryInteractor->handle();

    $categories = $output->getCategories();
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
  <title>カテゴリ一覧</title>
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
            <?php if (isset($_SESSION['user']['name'])): ?>
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
      <h1 class="text-3xl mb-4 text-center">カテゴリ一覧</h1>
      <!-- カテゴリを追加するボタン -->
      <div class="mb-4">
        <a href="create.php" class="p-2 bg-blue-500 text-white">カテゴリを追加する</a>
      </div>

      <!-- カテゴリのリスト -->
      <table class="mx-auto w-full border-collapse border border-gray-200">
        <thead>
          <tr>
            <th class="border border-gray-700 px-4 py-2">カテゴリ</th>
            <th class="border border-gray-700 px-4 py-2">編集</th>
            <th class="border border-gray-700 px-4 py-2">削除</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($categories as $category): ?>
          <tr>
            <td class="border border-gray-200 px-4 py-2">
              <?php echo htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td class="border border-gray-200 px-4 py-2">
              <a href="edit.php?id=<?php echo $category['id']; ?>" class="p-2 bg-blue-500 text-white">編集</a>
            </td>
            <td class="border border-gray-200 px-4 py-2">
              <a href="delete.php?id=<?php echo $category['id']; ?>" class="p-2 bg-red-500 text-white">削除</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <!-- 戻るボタン -->
      <div>
        <a href="/spendings/create.php" class="p-2 bg-gray-500 text-white">戻る</a>
      </div>
    </div>
  </div>
  </div>
</body>

</html>