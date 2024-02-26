<?php
namespace App\Domain\Port;

use App\Domain\Entity\IncomeSources;

interface IIncomeSourcesQuery
{
    public function findAll(): array;
}