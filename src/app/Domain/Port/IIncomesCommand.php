<?php

namespace App\Domain\Port;

use App\Domain\Entity\Incomes;

interface IIncomesCommand
{
    public function save(Incomes $income): void;
}