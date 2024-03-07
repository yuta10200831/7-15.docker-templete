<?php

namespace App\Adapter\QueryService;

use App\Domain\Port\ISpendingsQuery;
use App\Infrastructure\Dao\SpendingsDao;
use App\Domain\Entity\Spendings;

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

    public function find(int $id): ?Spendings {
        $data = $this->spendingsDao->fetchSpendingById($id);
        if (!$data) {
            return null;
        }

        return new Spendings(
            $data['id'],
            $data['name'],
            $data['category_id'],
            $data['amount'],
            $data['accrual_date']
        );
    }

    public function findWithCategory($id) {
        return $this->spendingsDao->fetchSpendingWithCategoryById($id);
    }
}