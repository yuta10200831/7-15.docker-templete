<?php

namespace App\UseCase\UseCaseInteractor;

use App\UseCase\UseCaseInput\CategoryEditInput;
use App\UseCase\UseCaseOutput\CategoryOutput;
use App\Domain\Entity\Category;
use App\Domain\Port\ICategoryRepository;
use App\Adapter\Repository\CategoryRepository;

class CategoryEditInteractor
{
    private $categoryRepository;
    private $input;

    public function __construct(CategoryRepository $categoryRepository, CategoryEditInput $input)
    {
        $this->categoryRepository = $categoryRepository;
        $this->input = $input;
    }

    public function handle(): CategoryOutput
    {
        try {
            $category = new Category(
                $this->input->getId(),
                $this->input->getName(),
                $this->input->getUserId()
            );

            return new CategoryOutput(true, "カテゴリが更新されました");

        } catch (\Exception $e) {
            return new CategoryOutput(false, "カテゴリの更新に失敗しました: " . $e->getMessage());
        }
    }
}