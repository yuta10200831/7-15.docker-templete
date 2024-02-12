<?php
$id = $_GET['id'];

$pdo = new PDO('mysql:host=mysql; dbname=kakeibo; charset=utf8', 'root', 'password');

$stmt = $pdo->prepare("SELECT incomes.*, income_sources.name AS income_source_name FROM incomes INNER JOIN income_sources ON incomes.income_source_id = income_sources.id WHERE incomes.id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$income = $stmt->fetch(PDO::FETCH_ASSOC);

// 収入源取得
$stmt = $pdo->prepare("SELECT * FROM income_sources");
$stmt->execute();
$income_sources = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>収入編集</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.17/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex justify-center">

  <div class="mx-auto my-8 w-4/5">
    <!-- ヘッダーの表示 -->
    <header class="bg-blue-500 p-4">
      <nav>
        <ul class="flex justify-between">
          <li><a class="text-white hover:text-blue-800" href="/">HOME</a></li>
          <li><a class="text-white hover:text-blue-800" href="index.php">収入TOP</a></li>
          <li><a class="text-white hover:text-blue-800" href="#">支出TOP</a></li>
          <li>
            <?php if (isset($_SESSION['username'])): ?>
              <a class="text-white hover:text-blue-800" href="/user/logout.php">ログアウト</a>
            <?php else: ?>
              <a class="text-white hover:text-blue-800" href="/user/signin.php">ログイン</a>
            <?php endif; ?>
          </li>        </ul>
      </nav>
    </header>

    <div class="container p-4 bg-white rounded shadow-lg">
    <?php
      if (isset($_GET['error'])) {
        echo '<div class="bg-red-500 text-white p-4 rounded text-center w-full">';
        echo htmlspecialchars(urldecode($_GET['error']), ENT_QUOTES, 'UTF-8');
        echo '</div>';
      }
    ?>
      <h1 class="text-3xl mb-4 text-center">収入編集</h1>
      <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $income['id']; ?>">

      <!-- 収入源フォーム -->
      <div class="mb-4">
        <label for="income-source">収入源：</label>
        <select name="income_source_id" id="income-source">
          <?php foreach ($income_sources as $source): ?>
            <option value="<?php echo $source['id']; ?>"
              <?php if ($source['id'] === $income['income_source_id']) echo "selected"; ?>>
              <?php echo htmlspecialchars($source['name'], ENT_QUOTES, 'UTF-8'); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

        <!-- 金額フォーム -->
        <div class="mb-4">
          <label for="amount">金額</label>
          <input type="text" id="amount" name="amount" value="<?php echo htmlspecialchars($income['amount'], ENT_QUOTES, 'UTF-8'); ?>">
          <span>円</span>
        </div>

        <!-- 日付フォーム -->
        <div class="mb-4">
          <label for="date">日付</label>
          <input type="date" id="date" name="accrual_date" value="<?php echo htmlspecialchars($income['accrual_date'], ENT_QUOTES, 'UTF-8'); ?>">
        </div>

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
