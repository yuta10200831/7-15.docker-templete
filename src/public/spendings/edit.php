<?php

session_start();

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Infrastructure\Dao\SpendingsDao;
use App\Adapter\Repository\SpendingsRepository;
use App\Adapter\QueryService\SpendingsQueryService;

$spendingsDao = new SpendingsDao();
$spendingsRepository = new SpendingsRepository($spendingsDao);
$spendingsQueryService = new SpendingsQueryService($spendingsDao);

$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);

$id = $_GET['id'] ?? null;

if ($id === null) {
    exit("IDが指定されていません。");
}

$spending = $spendingsQueryService->find($id);
$categories = $spendingsQueryService->getCategories();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>支出編集</title>
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
          <li><a class="text-white hover:text-blue-800" href="index.php">支出TOP</a></li>
          <li>
            <?php if (isset($_SESSION['user']['name'])) : ?>
            <a class="text-white hover:text-blue-800" href="/user/logout.php">ログアウト</a>
            <?php else : ?>
            <a class="text-white hover:text-blue-800" href="/user/signin.php">ログイン</a>
            <?php endif; ?>
          </li>
        </ul>
      </nav>
    </header>

    <div class="container p-4 bg-white rounded shadow-lg">
      <h1 class="text-3xl mb-4 text-center">支出編集</h1>
      <!-- ここにエラーメッセージを表示 -->
      <?php if (!empty($errors)) : ?>
      <div class="bg-red-100 p-4 mb-4 rounded">
        <?php foreach ($errors as $error) : ?>
        <p class="text-red-500"><?= $error ?></p>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
      <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($spending->getId(), ENT_QUOTES, 'UTF-8') ?>">

        <!-- 支出名フォーム -->
        <div class="mb-4">
          <label for="name">支出名：</label>
          <input type="text" id="name" name="name"
            value="<?= htmlspecialchars($spending->getName(), ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <select name="category_id" id="category">
          <?php foreach ($categories as $category): ?>
          <option value="<?= htmlspecialchars($category['id'], ENT_QUOTES, 'UTF-8') ?>"
            <?= $category['id'] == $spending->getCategory_id() ? 'selected' : '' ?>>
            <?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?>
          </option>
          <?php endforeach; ?>
        </select>

        <input type="text" id="amount" name="amount"
          value="<?= htmlspecialchars($spending->getAmount(), ENT_QUOTES, 'UTF-8') ?>">

        <input type="date" id="date" name="date"
          value="<?= htmlspecialchars($spending->getAccrualDate(), ENT_QUOTES, 'UTF-8') ?>">

        <!-- 更新ボタン -->
        <div class="text-right">
          <button type="submit" class="p-2 bg-blue-500 text-white">編集</button>
          <a href="index.php" class="p-2 bg-gray-400 text-white">戻る</a>
        </div>
      </form>
    </div>
  </div>

</body>

</html>