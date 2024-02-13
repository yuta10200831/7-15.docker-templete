<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Domain\ValueObject\incomes\incomesSourceId;
use App\Domain\ValueObject\incomes\Amount;
use App\Domain\ValueObject\incomes\AccrualDate;
use App\UseCase\UseCaseInput\RegisterincomesInput;
use App\UseCase\UseCaseInteractor\RegisterincomesInteractor;
use App\Infrastructure\Redirect\Redirect;
use App\Adapter\Repository\incomesRepository;
use App\Infrastructure\Dao\incomesDao;

session_start();

$incomesSourceId = filter_input(INPUT_POST, 'incomesSourceId');
$amount = filter_input(INPUT_POST, 'amount');
$accrualDate = filter_input(INPUT_POST, 'accrualDate');

if (empty($incomesSourceId) || empty($amount) || empty($accrualDate)) {
    $_SESSION['error_message'] = '必要な情報をすべて入力してください。';
    Redirect::handler('create.php');
    exit;
}

try {
    $incomesSourceIdObj = new incomessSourceId($incomesSourceId);
    $amountObj = new Amount($amount);
    $accrualDateObj = new AccrualDate($accrualDate);

    $input = new incomessInput($incomesSourceIdObj, $amountObj, $accrualDateObj);
    $incomesDao = new incomessDao();
    $repository = new incomessRepository($incomesDao);
    $incomesInteractor = new incomessInteractor($input, $repository);
    $output = $incomesInteractor->handle();

    if (!$output->isSuccess()) {
        $_SESSION['error_message'] = $output->getMessage();
        Redirect::handler('create.php');
        exit;
    }

    $_SESSION['message'] = $output->getMessage();
    Redirect::handler('index.php');
} catch (Exception $e) {
    $_SESSION['error_message'] = $e->getMessage();
    Redirect::handler('create.php');
    exit;
}