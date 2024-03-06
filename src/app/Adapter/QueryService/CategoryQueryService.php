<?php

namespace App\Adapter\QueryService;

use App\Domain\Port\ICategoryQuery;
use App\Infrastructure\Dao\CategoryDao;

class CategoryQueryService implements ICategoryQuery {
    private $categoryDao;

    public function __construct(CategoryDao $categoryDao) {
        $this->categoryDao = $categoryDao;
    }

    public function fetchAll(): array {
        return $this->categoryDao->fetchAll();
    }

    public function getCategories(): array {
        return $this->fetchAll();
    }
}