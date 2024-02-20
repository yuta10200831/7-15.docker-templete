<?php

namespace App\Domain\Port;

interface IIncomesQuery {
    public function fetchIncomeSources(): array;
}