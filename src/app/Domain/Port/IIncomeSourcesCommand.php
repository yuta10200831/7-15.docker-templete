<?php

namespace App\Domain\Port;

use App\Domain\Entity\IncomeSources;

interface IIncomeSourcesCommand
{
    public function save(IncomeSources $incomeSources): void;
}