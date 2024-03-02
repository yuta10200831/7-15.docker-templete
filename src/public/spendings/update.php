<?php

session_start();

require_once __DIR__ . '/../../vendor/autoload.php';

use App\UseCase\UseCaseInput\SpendingEditInput;
use App\UseCase\UseCaseInteractor\SpendingEditInteractor;
use App\Infrastructure\Dao\SpendingsDao;
use App\Adapter\Repository\SpendingsRepository;

$spendingId = $_POST['id'] ?? null;
$name = $_POST['name'] ?? '';
$categoryId = $_POST['category_id'] ?? null;
$amount = $_POST['amount'] ?? 0.0;
$date = $_POST['date'] ?? '';

if (is_null($spendingId)) {
    throw new Exception("支出IDが指定されていません。");
}

try {
    $dao = new SpendingsDao();
    $repository = new SpendingsRepository($dao);
    $inputData = new SpendingEditInput($spendingId, $name, $categoryId, $amount, $date);
    $interactor = new SpendingEditInteractor($repository, $inputData);

    $outputData = $interactor->handle();

    if ($outputData->success) {
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['errors'] = ['update_error' => $outputData->message];
        header("Location: edit.php?id=" . $spendingId);
        exit;
    }
} catch (Exception $e) {
    $_SESSION['errors'] = ['exception' => "支出の更新処理中にエラーが発生しました: " . $e->getMessage()];
    header("Location: edit.php?id=" . (isset($spendingId) ? $spendingId : ''));
    exit;
}