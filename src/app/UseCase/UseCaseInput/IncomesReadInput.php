<?php

namespace App\UseCase\UseCaseInput;

class IncomesReadInput
{
    private $incomeSourceId;
    private $startDate;
    private $endDate;

    public function __construct($incomeSourceId, $startDate, $endDate)
    {
        $this->incomeSourceId = $incomeSourceId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function getIncomeSourceId()
    {
        return $this->incomeSourceId;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }
}