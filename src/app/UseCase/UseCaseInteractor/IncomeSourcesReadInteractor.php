<?php

namespace App\UseCase\UseCaseInteractor;

use App\UseCase\UseCaseInput\IncomeSourcesReadInput;
use App\UseCase\UseCaseOutput\IncomeSourcesReadOutput;
use App\Adapter\QueryService\IncomeSourcesQueryService;

class IncomeSourcesReadInteractor
{
    private $queryService;
    private $incomeSourcesInput;

    public function __construct(IncomeSourcesQueryService $queryService, IncomeSourcesReadInput $input)
    {
        $this->queryService = $queryService;
        $this->incomeSourcesInput = $input;
    }

    public function handle(): IncomeSourcesReadOutput {
        try {
            $incomeSources = $this->queryService->findAll();
            return new IncomeSourcesReadOutput($incomeSources);
        } catch (Exception $e) {
            throw new Exception("収入源の取得に失敗しました。エラー詳細: " . $e->getMessage());
        }
    }
}