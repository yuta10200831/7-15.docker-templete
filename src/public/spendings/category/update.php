<?php
session_start();

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\UseCase\UseCaseInput\CategoryEditInput;
use App\UseCase\UseCaseInteractor\CategoryEditInteractor;
use App\Adapter\Repository\CategoryRepository;
use App\Infrastructure\Dao\CategoryDao;

$id = $_POST['id'] ?? null;
$name = trim($_POST['name'] ?? '');

if (empty($id) || empty($name)) {
    throw new Exception("必要なデータが入力されていません。");
}

$userId = $_SESSION['user']['id'] ?? null;
if (!$userId) {
    throw new Exception("ユーザーIDが取得できません。");
}

try {
    $input = new CategoryEditInput($id, $name, $userId);
    $categoryDao = new CategoryDao();
    $categoryRepository = new CategoryRepository($categoryDao);
    $interactor = new CategoryEditInteractor($categoryRepository, $input);
    $result = $interactor->handle();

    var_dump($result);
    die;
    if ($result->isSuccess()) {
        header("Location: index.php?message=" . urlencode($result->getMessage()));
        exit;
    } else {
        throw new Exception($result->getMessage());
    }
} catch (Exception $e) {
    header("Location: edit.php?id=$id&error=" . urlencode($e->getMessage()));
    exit;
}
?>