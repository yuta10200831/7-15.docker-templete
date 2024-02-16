<?php

namespace App\Domain\Port;

use App\Domain\Entity\Spendings;

interface ISpendingsCommand
{
    public function save(Spendings $spendings): void;
}