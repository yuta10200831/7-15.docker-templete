<?php
session_start();

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\UseCase\UseCaseInput\IncomeSourcesEditInput;
use App\UseCase\UseCaseInteractor\IncomeSourcesEditInteractor;
use App\Infrastructure\Dao\IncomeSourcesDao;
use App\Adapter\Repository\IncomeSourcesRepository;

$id = $_POST['id'] ?? null;
$name = trim($_POST['name'] ?? '');

if ($id === null || $name === '') {
    $_SESSION['error_message'] = 'IDと収入源名は必須です。';
    header("Location: edit.php?id=" . urlencode($id));
    exit();
}

try {
    $editInput = new IncomeSourcesEditInput($id, $name);
    $incomeSourcesDao = new IncomeSourcesDao();
    $repository = new IncomeSourcesRepository($incomeSourcesDao);
    $editInteractor = new IncomeSourcesEditInteractor($repository, $editInput);
    $result = $editInteractor->handle();

    if ($result->isSuccess()) {
        $_SESSION['success_message'] = $result->getMessage();
        header('Location: index.php');
        exit();
    } else {
        throw new Exception($result->getMessage());
    }
} catch (Exception $e) {
    $_SESSION['error_message'] = '更新処理に失敗しました: ' . $e->getMessage();
    header('Location: edit.php?id=' . urlencode($id));
    exit();
}