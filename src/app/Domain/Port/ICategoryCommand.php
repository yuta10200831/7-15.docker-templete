<?php

namespace App\Domain\Port;

use App\Domain\Entity\Category;

interface ICategoryCommand
{
    public function saveCategory(Category $category): bool;
    public function isCategoryExists(string $name): bool;
}