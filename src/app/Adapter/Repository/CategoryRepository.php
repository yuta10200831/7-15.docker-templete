<?php

namespace App\Adapter\Repository;

use App\Domain\Port\ICategoryCommand;
use App\Domain\Port\ICategoryEditCommand;
use App\Domain\Entity\Category;
use App\Infrastructure\Dao\CategoryDao;

class CategoryRepository implements ICategoryCommand, ICategoryEditCommand {
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

    public function updateCategory(Category $category): bool {
        return $this->categoryDao->updateCategory($category);
    }

    public function findCategoryById(int $id): ?Category {
        return $this->categoryDao->findCategoryById($id);
    }

    public function execute(Category $category): bool {
        return $this->updateCategory($category);
    }
}