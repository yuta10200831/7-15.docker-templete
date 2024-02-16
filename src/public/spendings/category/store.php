<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Domain\ValueObject\Spendings\CategoryName;
use App\UseCase\UseCaseInput\CategoryInput;
use App\UseCase\UseCaseInteractor\CategoryInteractor;
use App\Adapter\Repository\CategoryRepository;
use App\Infrastructure\Dao\CategoryDao;
use App\Infrastructure\Redirect\Redirect;

session_start();

$categoryNameInput = $_POST['categoryName'] ?? '';

if (empty($categoryNameInput)) {
    $_SESSION['error_message'] = "カテゴリ名が入力されていません。";
    Redirect::handler('create.php');
    exit;
}

try {
    $categoryName = new CategoryName($categoryNameInput);
    $input = new CategoryInput($categoryName);
    $categoryDao = new CategoryDao();
    $repository = new CategoryRepository($categoryDao);
    $interactor = new CategoryInteractor($repository, $input);

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