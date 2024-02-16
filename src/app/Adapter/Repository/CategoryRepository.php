<?php

namespace App\Adapter\Repository;

use App\Domain\Port\ICategoryCommand;
use App\Domain\Entity\Category;
use App\Infrastructure\Dao\CategoryDao;

class CategoryRepository implements ICategoryCommand {
    private $categoryDao;

    public function __construct(CategoryDao $categoryDao) {
        $this->categoryDao = $categoryDao;
    }

    public function saveCategory(Category $category): bool {
      return $this->categoryDao->saveCategory($category);
  }
    public function isCategoryExists(string $name): bool {
        return $this->categoryDao->isCategoryExists($name);
    }
}