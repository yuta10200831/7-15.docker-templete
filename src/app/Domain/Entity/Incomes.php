<?php

namespace App\Domain\Entity;

class Incomes
{
    private $id;
    private $incomeSourceId;
    private $amount;
    private $accrualDate;

    public function __construct($id, $incomeSourceId, $amount, $accrualDate)
    {
        $this->id = $id;
        $this->incomeSourceId = $incomeSourceId;
        $this->amount = $amount;
        $this->accrualDate = $accrualDate;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
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