<?php

namespace App\UseCase\UseCaseInteractor;

use App\Adapter\QueryService\IndexQueryService;
use App\UseCase\UseCaseInput\IndexInput;
use App\UseCase\UseCaseOutput\IndexOutput;
use App\Domain\Port\IIndexQuery;

class IndexInteractor implements IIndexQuery {
    private $indexQuery;
    private $input;

    public function __construct(IIndexQuery $indexQuery, IndexInput $input) {
        $this->indexQuery = $indexQuery;
        $this->input = $input;
    }

    public function getMonthlySummary(): IndexOutput {
        $year = $this->input->getYear();
        $monthlySummary = $this->queryService->getMonthlySummary($year);
        $success = !empty($monthlySummary);
        $message = $success ? 'Data retrieval successful.' : 'Failed to retrieve data.';

        return new IndexOutput($success, $message, $monthlySummary);
    }
}