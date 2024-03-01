<?php

session_start();

use App\UseCase\UseCaseInput\SpendingEditInput;
use App\UseCase\UseCaseInput\SpendingEditInteractor;
use App\Infrastructure\Dao\SpendingsDao;
use App\Adapter\Repository\SpendingsRepository;

$editExpenseId = $_POST['id'] ?? 0;
$editExpenseName = $_POST['expense_name'] ?? '';
$editCategoryID = $_POST['category_id'] ?? 0;
$editAmount = $_POST['amount'] ?? 0.0;
$editAccrualDate = $_POST['expense_date'] ?? '';

$dao = new SpendingsDao();
$repository = new SpendingsRepository($dao);
$inputData = new SpendingEditInput($editExpenseId, $editExpenseName, $editCategoryID, $editAmount, $editAccrualDate);
$interactor = new SpendingEditInteractor($repository, $inputData);
$outputData = $interactor->handle();

if ($outputData->success) {
    header("Location: index.php");
    exit;
} else {
    $_SESSION['errors'] = ['update_error' => $outputData->message];
    header("Location: edit.php?id=" . $editExpenseId);
    exit;
}