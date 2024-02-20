<?php

namespace App\UseCase\UseCaseOutput;

class IncomeSourcesReadOutput
{
    private $incomeSources;

    public function __construct(array $incomeSources)
    {
        $this->incomeSources = $incomeSources;
    }

    public function getIncomeSources(): array
    {
        return $this->incomeSources;
    }
}