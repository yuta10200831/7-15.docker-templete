<?php

namespace App\UseCase\UseCaseInput;

class IncomesReadInput
{
    private ?int $incomeSourceId;
    private ?string $startDate;
    private ?string $endDate;

    public function __construct(?int $incomeSourceId = null, ?string $startDate = null, ?string $endDate = null)
    {
        $this->incomeSourceId = $incomeSourceId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function getIncomeSourceId(): ?int
    {
        return $this->incomeSourceId;
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