<?php

namespace App\Domain\Port;

interface ISpendingsQuery {
    public function fetchAllSpendings($categoryId = null, $startDate = null, $endDate = null);
    public function fetchSpendingsWithFilter($categoryId = null, $startDate = null, $endDate = null);
    public function getCategories();
    public function fetchSpendingsByCategoryId($categoryId);
}