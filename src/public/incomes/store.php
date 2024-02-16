<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Domain\ValueObject\Incomes\IncomesSourceId;
use App\Domain\ValueObject\Incomes\Amount;
use App\Domain\ValueObject\Incomes\AccrualDate;
use App\UseCase\UseCaseInput\IncomesInput;
use App\UseCase\UseCaseInteractor\IncomesInteractor;
use App\Infrastructure\Redirect\Redirect;
use App\Adapter\Repository\IncomesRepository;
use App\Infrastructure\Dao\IncomesDao;

session_start();

if (!isset($_SESSION['user']['id'])) {
  $_SESSION['error_message'] = 'ログインが必要です。';
  Redirect::handler('/user/signin.php');
  exit;
}

$incomeSourceId = filter_input(INPUT_POST, 'income_source_id', FILTER_VALIDATE_INT);
$amount = filter_input(INPUT_POST, 'amount');
$accrualDate = filter_input(INPUT_POST, 'accrual_date');

if ($incomeSourceId === false || $incomeSourceId <= 0 || empty($amount) || empty($accrualDate)) {
    $_SESSION['error_message'] = '必要な情報が不足しています。';
    Redirect::handler('create.php');
    exit;
}

try {
    $incomesSourceIdVo = new IncomesSourceId($incomeSourceId);
    $amountVo = new Amount(floatval($amount));
    $accrualDateVo = new AccrualDate($accrualDate);

    $input = new IncomesInput($incomesSourceIdVo, $amountVo, $accrualDateVo);
    $incomesDao = new IncomesDao();
    $repository = new IncomesRepository($incomesDao);
    $interactor = new IncomesInteractor($repository, $input);
    $output = $interactor->handle();

    if (!$output->isSuccess()) {
        $_SESSION['error_message'] = $output->getMessage();
        Redirect::handler('create.php');
        exit;
    }

    $_SESSION['message'] = $output->getMessage();
    Redirect::handler('index.php');
} catch (\Exception $e) {
    $_SESSION['error_message'] = $e->getMessage();
    Redirect::handler('create.php');
    exit;
}