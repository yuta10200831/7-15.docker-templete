<?php

namespace App\Domain\Port;

use App\Domain\Entity\IncomeSources;

interface IIncomeSourcesEditCommand {
    public function update(IncomeSources $incomeSources): void;
}