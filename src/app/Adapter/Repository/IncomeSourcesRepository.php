<?php

namespace App\Adapter\Repository;

use App\Domain\Port\IIncomeSourcesCommand;
use App\Domain\Port\IIncomeSourcesEditCommand;
use App\Domain\Entity\IncomeSources;
use App\Infrastructure\Dao\IncomeSourcesDao;

class IncomeSourcesRepository implements IIncomeSourcesCommand, IIncomeSourcesEditCommand {
    private $incomeSourcesDao;

    public function __construct(IncomeSourcesDao $incomeSourcesDao) {
        $this->incomeSourcesDao = $incomeSourcesDao;
    }

    public function save(IncomeSources $incomeSources): void {
        $this->incomeSourcesDao->save($incomeSources);
    }

    public function update(IncomeSources $incomeSources): void {
        $this->incomeSourcesDao->update($incomeSources);
    }
}