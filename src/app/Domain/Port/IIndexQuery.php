<?php

namespace App\Domain\Port;

interface IIndexQuery {
    public function getMonthlySummary($year): array;
    public function getSpendingsWithFilter($year, $categoryId = null, $startDate = null, $endDate = null): array;
}