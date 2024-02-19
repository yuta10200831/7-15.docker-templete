<?php

namespace App\Adapter\QueryService;

use App\Infrastructure\Dao\IndexDao;
use App\Domain\Entity\Incomes;
use App\Domain\Entity\Spendings;
use App\Domain\Port\IIndexQuery;

class IndexQueryService implements IIndexQuery {
    private $indexDao;

    public function __construct(IndexDao $indexDao) {
        $this->indexDao = $indexDao;
    }

    public function getMonthlySummary($year): array {
        $summaryData = $this->indexDao->getMonthlySummary($year);
        $incomesEntities = [];

        foreach ($summaryData as $data) {
            $incomesEntities[] = new Incomes(
                $data['id'],
                $data['user_id'],
                $data['income_source_id'],
                $data['amount'],
                new \DateTime($data['accrual_date']),
                new \DateTime($data['created_at']),
                new \DateTime($data['updated_at'])
            );
        }

        return $incomesEntities;
    }

    public function getSpendingsWithFilter($year, $categoryId = null, $startDate = null, $endDate = null): array {
        return $this->indexDao->fetchSpendingsWithFilter($year, $categoryId, $startDate, $endDate);
    }

    public function getIncomesWithFilter($year, $categoryId = null, $startDate = null, $endDate = null): array {
      return $this->indexDao->fetchIncomesWithFilter($year, $categoryId, $startDate, $endDate);
  }

}