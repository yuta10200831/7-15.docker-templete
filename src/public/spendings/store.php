<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Domain\ValueObject\Spendings\SpendingsName;
use App\Domain\ValueObject\Spendings\CategoryId;
use App\Domain\ValueObject\Incomes\Amount;
use App\Domain\ValueObject\Incomes\AccrualDate;
use App\UseCase\UseCaseInput\SpendingsInput;
use App\UseCase\UseCaseInteractor\SpendingsInteractor;
use App\Adapter\Repository\SpendingsRepository;
use App\Infrastructure\Dao\SpendingsDao;
use App\Infrastructure\Redirect\Redirect;

session_start();

$spendingsName = filter_input(INPUT_POST, 'name');
$category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
$amount = filter_input(INPUT_POST, 'amount');
$accrualDate = filter_input(INPUT_POST, 'accrual_date');

try {
    $spendingsNameVo = new SpendingsName($spendingsName);
    $categoryIdVo = new CategoryId($category_id);
    $amountVo = new Amount(floatval($amount));
    $accrualDateVo = new AccrualDate($accrualDate);

    $input = new SpendingsInput($spendingsNameVo, $categoryIdVo, $amountVo, $accrualDateVo);
    $spendingsDao = new SpendingsDao();
    $repository = new SpendingsRepository($spendingsDao);
    $interactor = new SpendingsInteractor($repository, $input);

    $output = $interactor->handle();

    if (!$output->isSuccess()) {
        $_SESSION['error_message'] = $output->getMessage();
        Redirect::handler('create.php');
        exit;
    }

    $_SESSION['message'] = $output->getMessage();
    Redirect::handler('index.php');
} catch (\Exception $e) {
    $_SESSION['error_message'] = "処理中にエラーが発生しました: " . $e->getMessage();
    Redirect::handler('create.php');
    exit;
}