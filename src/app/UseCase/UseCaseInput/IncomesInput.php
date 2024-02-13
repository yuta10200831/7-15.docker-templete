<?php

namespace App\Application\UseCase\Input;

use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\IncomeSourceId;
use App\Domain\ValueObject\Amount;
use App\Domain\ValueObject\AccrualDate;

class IncomesInput
{
    private $userId;
    private $incomeSourceId;
    private $amount;
    private $accrualDate;

    public function __construct(UserId $userId, IncomeSourceId $incomeSourceId, Amount $amount, AccrualDate $accrualDate)
    {
        $this->userId = $userId;
        $this->incomeSourceId = $incomeSourceId;
        $this->amount = $amount;
        $this->accrualDate = $accrualDate;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getIncomeSourceId(): IncomeSourceId
    {
        return $this->incomeSourceId;
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