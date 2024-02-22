<?php

namespace App\UseCase\UseCaseInteractor;

use App\Domain\Port\ICategoryQuery;
use App\UseCase\UseCaseInput\CategoryReadInput;
use App\UseCase\UseCaseOutput\CategoryReadOutput;

class CategoryReadInteractor
{
    private ICategoryQuery $categoryQuery;
    private CategoryReadInput $input;

    public function __construct(ICategoryQuery $categoryQuery, CategoryReadInput $input)
    {
        $this->categoryQuery = $categoryQuery;
        $this->input = $input;
    }

    public function handle(): CategoryReadOutput
    {
        try {
            $categories = $this->categoryQuery->fetchAll();

            if (empty($categories)) {
                return new CategoryReadOutput(false, "該当するカテゴリが見つかりませんでした。");
            }

            return new CategoryReadOutput(true, "カテゴリの取得に成功しました。", $categories);
        } catch (\Exception $e) {
            return new CategoryReadOutput(false, "カテゴリの取得中にエラーが発生しました: " . $e->getMessage());
        }
    }
}