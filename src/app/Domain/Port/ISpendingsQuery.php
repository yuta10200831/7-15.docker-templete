<?php

namespace App\Domain\Port;

use App\Domain\Entity\Spendings;

interface ISpendingsQuery {
    public function fetchAllSpendings($categoryId = null, $startDate = null, $endDate = null);
    public function fetchSpendingsWithFilter($categoryId = null, $startDate = null, $endDate = null);
    public function getCategories();
    public function fetchSpendingsByCategoryId($categoryId);
    public function find(int $id): ?Spendings;
    public function findWithCategory(int $id);
}