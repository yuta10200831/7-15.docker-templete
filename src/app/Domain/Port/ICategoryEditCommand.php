<?php

namespace App\Domain\Port;

use App\Domain\Entity\Category;

interface ICategoryEditCommand {
    public function execute(Category $category): bool;
}