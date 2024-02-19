<?php

namespace App\UseCase\UseCaseInteractor;

use App\Domain\Port\ICategoryCommand;
use App\UseCase\UseCaseInput\CategoryInput;
use App\UseCase\UseCaseOutput\CategoryOutput;
use App\Domain\Entity\Category;

class CategoryInteractor
{
    private $categoryCommand;
    private $input;

    public function __construct(ICategoryCommand $categoryCommand, CategoryInput $input)
    {
        $this->categoryCommand = $categoryCommand;
        $this->input = $input;
    }

    public function handle(): CategoryOutput
    {
        $categoryNameValue = $this->input->getCategoryName()->value();
        $userId = $_SESSION['user']['id'] ?? null;

        if ($userId === null) {
            return new CategoryOutput(false, "ユーザーIDが見つかりません。");
        }

        if ($this->categoryCommand->isCategoryExists($categoryNameValue)) {
            return new CategoryOutput(false, "このカテゴリは既に存在します。");
        }

        $category = new Category(null, $categoryNameValue, $userId);

        $result = $this->categoryCommand->saveCategory($category);
        if ($result) {
            return new CategoryOutput(true, "カテゴリが正常に保存されました。");
        } else {
            return new CategoryOutput(false, "カテゴリの保存に失敗しました。");
        }
    }
}