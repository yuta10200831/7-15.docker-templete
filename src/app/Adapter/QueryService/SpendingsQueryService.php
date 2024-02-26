<?php

namespace App\Adapter\QueryService;

use App\Domain\Port\ISpendingsQuery;
use App\Infrastructure\Dao\SpendingsDao;

class SpendingsQueryService implements ISpendingsQuery {
    private $spendingsDao;

    public function __construct(SpendingsDao $spendingsDao) {
        $this->spendingsDao = $spendingsDao;
    }

    public function fetchAllSpendings($categoryId = null, $startDate = null, $endDate = null) {
        return $this->spendingsDao->fetchAllSpendings($categoryId, $startDate, $endDate);
    }

    public function fetchSpendingsWithFilter($categoryId = null, $startDate = null, $endDate = null) {
        return $this->spendingsDao->fetchSpendingsWithFilter($categoryId, $startDate, $endDate);
    }

    public function getCategories() {
        return $this->spendingsDao->getCategories();
    }

    public function fetchSpendingsByCategoryId($categoryId) {
        return $this->spendingsDao->fetchSpendingsByCategoryId($categoryId);
    }
}