<?php

namespace App\Domain\Entity;

class Income
{
    private $userId;
    private $incomeSourceId;
    private $amount;
    private $accrualDate;

    public function __construct($userId, $incomeSourceId, $amount, $accrualDate)
    {
        $this->userId = $userId;
        $this->incomeSourceId = $incomeSourceId;
        $this->amount = $amount;
        $this->accrualDate = $accrualDate;
    }

    public function getUserId()
    {
        return $this->userId;
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