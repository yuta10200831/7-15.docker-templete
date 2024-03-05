<?php

namespace App\Domain\Entity;

class Spendings
{
    private $id;
    private $spendingsName;
    private $category_id;
    private $amount;
    private $accrualDate;

    public function __construct($id, $spendingsName, $category_id, $amount, $accrualDate)
    {
        $this->id = $id;
        $this->spendingsName = $spendingsName;
        $this->category_id = $category_id;
        $this->amount = $amount;
        $this->accrualDate = $accrualDate;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSpendingsName()
    {
        return $this->spendingsName;
    }

    public function getCategoryId()
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