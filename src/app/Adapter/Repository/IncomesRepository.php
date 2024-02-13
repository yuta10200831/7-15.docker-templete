<?php

namespace App\Adapter\Repository;

use App\Application\Port\IIncomesCommand;
use App\Domain\Entity\Income;
use App\Infrastructure\Dao\IncomesDao;

class MySqlIncomeRepository implements IncomesRepository
{
    private $incomesDao;

    public function __construct(IncomesDao $incomesDao)
    {
      $this->incomesDao = $incomesDao;
    }

    public function save(Income $income): void
    {
        $this->incomesCommand->saveIncome($income);
    }
}