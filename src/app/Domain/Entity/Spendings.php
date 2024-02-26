<?php

namespace App\Domain\Entity;

class Spendings
{
    private $spendingsName;
    private $category_id;
    private $amount;
    private $accrualDate;

    public function __construct($spendingsName, $category_id, $amount, $accrualDate)
    {
        $this->spendingsName = $spendingsName;
        $this->category_id = $category_id;
        $this->amount = $amount;
        $this->accrualDate = $accrualDate;
    }

    public function getSpendingsName()
    {
        return $this->spendingsName;
    }

    public function getCategory_id()
    {
        return $this->category_id;
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