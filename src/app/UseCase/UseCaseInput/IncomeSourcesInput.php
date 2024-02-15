<?php

namespace App\UseCase\UseCaseInput;

use App\Domain\ValueObject\Incomes\IncomeSourcesName;

class IncomeSourcesInput
{
    private $incomeSourcesName;

    public function __construct(IncomeSourcesName $incomeSourcesName)
    {
        $this->incomeSourcesName = $incomeSourcesName;
    }

    public function getIncomeSourcesName(): IncomeSourcesName
    {
        return $this->incomeSourcesName;
    }
}