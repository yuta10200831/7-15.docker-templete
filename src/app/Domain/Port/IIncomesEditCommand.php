<?php

namespace App\Domain\Port;

use App\Domain\Entity\Incomes;

interface IIncomesEditCommand {
    public function edit($id, Incomes $income): void;
}