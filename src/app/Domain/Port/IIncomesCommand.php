<?php

namespace App\Application\Port;

use App\Domain\Entity\Income;

interface IIncomesCommand
{
    public function saveIncome(Incomes $income): void;
}