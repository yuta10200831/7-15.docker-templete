<?php

namespace App\Adapter\QueryService;

use App\Infrastructure\Dao\SpendingsDao;
use App\Infrastructure\Dao\IncomesDao;
use App\Domain\Port\IIndexQuery;

class IndexQueryService implements IIndexQuery {
    private $spendingsDao;
    private $incomesDao;

    public function __construct(SpendingsDao $spendingsDao, IncomesDao $incomesDao) {
        $this->spendingsDao = $spendingsDao;
        $this->incomesDao = $incomesDao;
    }

    public function getMonthlySummary($year): array {
        $monthlySummary = [];
        for ($month = 1; $month <= 12; $month++) {
            $totalIncome = $this->incomesDao->getTotalIncomesByMonthAndYear($year, $month);
            $totalSpend = $this->spendingsDao->getTotalSpendingsByMonthAndYear($year, $month);

            $monthlySummary[$month] = [
                'month' => $month,
                'total_income' => $totalIncome,
                'total_spending' => $totalSpend,
                'balance' => $totalIncome - $totalSpend,
            ];
        }
        return $monthlySummary;
    }

    public function getSpendingsWithFilter($year, $categoryId = null, $startDate = null, $endDate = null): array {
        return $this->spendingsDao->fetchSpendingsWithFilter($year, $categoryId, $startDate, $endDate);
    }

    public function getIncomesWithFilter($year, $categoryId = null, $startDate = null, $endDate = null): array {
        return $this->incomesDao->fetchIncomesWithFilter($year, $categoryId, $startDate, $endDate);
    }
}