<?php

namespace App\Domain\Port;

use App\Domain\Entity\Incomes;

interface IIncomesEditCommand {
    public function update(Incomes $income): void;
}