<?php

namespace App\Adapter\QueryService;

use App\Domain\Port\IIncomesQuery;
use App\Infrastructure\Dao\IncomesDao;

class IncomesQueryService implements IIncomesQuery {
    private $incomesDao;

    public function __construct(IncomesDao $incomesDao) {
        $this->incomesDao = $incomesDao;
    }

    public function fetchIncomeSources(): array {
        return $this->incomesDao->fetchIncomeSources();
    }

    public function fetchIncomesFiltered($incomeSourceId, $startDate, $endDate) {
      return $this->incomesDao->fetchIncomesFiltered($incomeSourceId, $startDate, $endDate);
    }
}