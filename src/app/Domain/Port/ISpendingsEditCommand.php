<?php

namespace App\Domain\Port;

use App\Domain\Entity\Spendings;

interface ISpendingsEditCommand {
    public function update(Spendings $spendings): void;
}