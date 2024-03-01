<?php

session_start();

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Domain\ValueObject\Incomes\AccrualDate;
use App\Domain\ValueObject\Incomes\Amount;
use App\Domain\ValueObject\Incomes\IncomesSourceId;
use App\UseCase\UseCaseInput\IncomesEditInput;
use App\Infrastructure\Dao\IncomesDao;
use App\Adapter\Repository\IncomesRepository;
use App\UseCase\UseCaseInteractor\IncomesEditInteractor;

$id = $_POST['id'] ?? null;
$amount = $_POST['amount'] ?? '';
$accrualDate = $_POST['accrual_date'] ?? '';
$incomeSourceId = $_POST['income_source_id'] ?? '';

if (is_null($id) || empty($amount) || empty($accrualDate) || empty($incomeSourceId)) {
    $_SESSION['errors'] = ['必要な情報をすべて入力してください。'];
    header("Location: edit.php?id=" . urlencode($id));
    exit;
}

try {
  $amountVO = new Amount((float)$amount);
  $amountValue = $amountVO->getValue();
  $accrualDateVO = new \DateTime($accrualDate);
  $incomeSourceIdVO = new IncomesSourceId((int)$incomeSourceId);
  $incomeSourceIdValue = $incomeSourceIdVO->getValue();
  $input = new IncomesEditInput((int)$id, $amountValue, $accrualDateVO, $incomeSourceIdValue);

  $incomesDao = new IncomesDao();
  $incomesRepository = new IncomesRepository($incomesDao);
  $incomesEditInteractor = new IncomesEditInteractor($incomesRepository, $input);
  $output = $incomesEditInteractor->handle();

  $_SESSION['success'] = '収入情報が正常に更新されました。';
  header('Location: index.php');
  exit;
} catch (Exception $e) {
  $_SESSION['errors'] = [$e->getMessage()];
  header("Location: edit.php?id=" . urlencode($id));
  exit;
}