<?php

namespace App\UseCase\UseCaseInput;

use App\Domain\ValueObject\Spendings\CategoryName;

class CategoryInput
{
    private $categoryName;

    public function __construct(CategoryName $categoryName)
    {
        $this->categoryName = $categoryName;
    }

    public function getCategoryName(): CategoryName
    {
        return $this->categoryName;
    }
}