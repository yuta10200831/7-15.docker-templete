<?php

namespace App\UseCase\UseCaseInput;

class SpendingsEditInput {
    public int $id;
    public string $name;
    public int $categoryId;
    public float $amount;
    public string $accrualDate;

    public function __construct(int $id, string $name, int $categoryId, float $amount, string $accrualDate) {
        $this->id = $id;
        $this->name = $name;
        $this->categoryId = $categoryId;
        $this->amount = $amount;
        $this->accrualDate = $accrualDate;
    }
}