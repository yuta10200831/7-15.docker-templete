<?php

namespace App\UseCase\UseCaseInput;

use App\Domain\ValueObject\Incomes\IncomesSourceId;
use App\Domain\ValueObject\Incomes\Amount;
use App\Domain\ValueObject\Incomes\AccrualDate;

class IncomesInput
{
    private $incomesSourceId;
    private $amount;
    private $accrualDate;

    public function __construct(IncomesSourceId $incomesSourceId, Amount $amount, AccrualDate $accrualDate)
    {
        $this->incomesSourceId = $incomesSourceId;
        $this->amount = $amount;
        $this->accrualDate = $accrualDate;
    }

    public function getIncomesSourceId(): IncomesSourceId
    {
        return $this->incomesSourceId;
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