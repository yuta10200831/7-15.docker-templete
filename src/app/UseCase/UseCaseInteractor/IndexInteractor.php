<?php

namespace App\UseCase\UseCaseInteractor;

use App\Adapter\QueryService\IndexQueryService;
use App\UseCase\UseCaseInput\IndexInput;
use App\UseCase\UseCaseOutput\IndexOutput;

class IndexInteractor {
    private $queryService;
    private $input;

    public function __construct(IndexQueryService $queryService, IndexInput $input) {
        $this->queryService = $queryService;
        $this->input = $input;
    }

    public function handle() {
        $year = $this->input->getYear();
        $monthlySummary = $this->queryService->getMonthlySummary($year);

        $success = !empty($monthlySummary);
        $message = $success ? 'データの取得に成功しました。' : 'データの取得に失敗しました。';

        return new IndexOutput($success, $message, $monthlySummary);
    }
}