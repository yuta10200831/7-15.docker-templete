<?php

namespace App\Domain\Port;

interface ICategoryQuery {
    public function fetchAll(): array;
}