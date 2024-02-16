<?php

namespace App\UseCase\UseCaseInput;

use App\Domain\ValueObject\Spendings\SpendingsName;
use App\Domain\ValueObject\Spendings\CategoryId;
use App\Domain\ValueObject\Incomes\Amount;
use App\Domain\ValueObject\Incomes\AccrualDate;

class SpendingsInput
{
    private $spendingsName;
    private $category_id;
    private $amount;
    private $accrualDate;

    public function __construct(SpendingsName $spendingsName, CategoryId $category_id, Amount $amount, AccrualDate $accrualDate)
    {
        $this->spendingsName = $spendingsName;
        $this->category_id = $category_id;
        $this->amount = $amount;
        $this->accrualDate = $accrualDate;
    }

    public function getSpendingsName(): SpendingsName
    {
        return $this->spendingsName;
    }

    public function getCategoryId(): CategoryId
    {
        return $this->category_id;
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }

    public function getAccrualDate(): AccrualDate
    {
        return $this->accrualDate;
    }
}