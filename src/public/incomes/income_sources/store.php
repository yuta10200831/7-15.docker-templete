<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Domain\ValueObject\Incomes\IncomeSourcesName;
use App\UseCase\UseCaseInput\IncomeSourcesInput;
use App\UseCase\UseCaseInteractor\IncomeSourcesInteractor;
use App\Infrastructure\Redirect\Redirect;
use App\Adapter\Repository\IncomeSourcesRepository;
use App\Infrastructure\Dao\IncomeSourcesDao;

session_start();

$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);

try {
    $incomeSourcesName = new IncomeSourcesName($name);
    $incomeSourcesInput = new IncomeSourcesInput($incomeSourcesName);
    $incomeSourcesDao = new IncomeSourcesDao();
    $repository = new IncomeSourcesRepository($incomeSourcesDao);
    $interactor = new IncomeSourcesInteractor($repository, $incomeSourcesInput);
    $output = $interactor->handle();

    if (!$output->isSuccess()) {
        $_SESSION['error_message'] = $output->getMessage();
        Redirect::handler('create.php');
        exit;
    }

    $_SESSION['message'] = $output->getMessage();
    Redirect::handler('index.php');
} catch (\Exception $e) {
    $_SESSION['error_message'] = '収入源の登録に失敗しました: ' . $e->getMessage();
    Redirect::handler('create.php');
    exit;
}