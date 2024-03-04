<?php

namespace App\UseCase\UseCaseInteractor;

use App\Domain\Port\IIncomeSourcesEditCommand;
use App\UseCase\UseCaseInput\IncomeSourcesEditInput;
use App\UseCase\UseCaseOutput\IncomeSourcesEditOutput;
use App\Domain\Entity\IncomeSources;

class IncomeSourcesEditInteractor {
    private $incomeSourcesEditCommand;
    private $input;

    public function __construct(IIncomeSourcesEditCommand $incomeSourcesEditCommand, IncomeSourcesEditInput $input) {
        $this->incomeSourcesEditCommand = $incomeSourcesEditCommand;
        $this->input = $input;
    }

    public function handle(): IncomeSourcesEditOutput {
        $incomeSources = new IncomeSources($this->input->getId(), null, $this->input->getName());

        try {
            $this->incomeSourcesEditCommand->update($incomeSources);
            return new IncomeSourcesEditOutput(true, "収入源が正常に更新されました。");
        } catch (\Exception $e) {
            return new IncomeSourcesEditOutput(false, $e->getMessage());
        }
    }
}