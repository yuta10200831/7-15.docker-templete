<?php

namespace App\Domain\Entity;

class Incomes
{
    private $incomeSourceId;
    private $amount;
    private $accrualDate;

    public function __construct($incomeSourceId, $amount, $accrualDate)
    {
        $this->incomeSourceId = $incomeSourceId;
        $this->amount = $amount;
        $this->accrualDate = $accrualDate;
    }

    public function getIncomeSourceId()
    {
        return $this->incomeSourceId;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getAccrualDate()
    {
        return $this->accrualDate;
    }
}