<?php

namespace App\UseCase\UseCaseInput;

class SpendingsReadInput
{
    private $categoryId;
    private $startDate;
    private $endDate;

    public function __construct(?string $categoryId = null, ?string $startDate = null, ?string $endDate = null)
    {
        $this->categoryId = $categoryId !== null ? (int) $categoryId : null;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }
}