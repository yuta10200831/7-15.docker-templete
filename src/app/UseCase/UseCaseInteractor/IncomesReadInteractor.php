<?php

namespace App\UseCase\UseCaseInteractor;

use App\UseCase\UseCaseInput\IncomesReadInput;
use  App\UseCase\UseCaseOutput\IncomesReadOutput;
use App\Adapter\QueryService\IncomesQueryService;

class IncomesReadInteractor
{
    private $incomesQueryService;
    private $incomesReadInput;

    public function __construct(IncomesQueryService $incomesQueryService, IncomesReadInput $input)
    {
        $this-> incomesQueryService = $incomesQueryService;
        $this->incomesReadInput = $input;
    }

    public function handle(): IncomesReadOutput {
      $incomeSourceId = $this->incomesReadInput->getIncomeSourceId();
      $startDate = $this->incomesReadInput->getStartDate();
      $endDate = $this->incomesReadInput->getEndDate();

      $incomes = $this->incomesQueryService->fetchIncomesFiltered($incomeSourceId, $startDate, $endDate);

      return new IncomesReadOutput(true, "収入情報の取得に成功しました", $incomes);
  }
}