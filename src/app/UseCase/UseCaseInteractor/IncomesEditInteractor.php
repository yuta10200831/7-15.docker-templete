<?php

namespace App\UseCase\UseCaseInteractor;

use App\Adapter\Repository\IncomesRepository;
use App\UseCase\UseCaseInput\IncomesEditInput;
use App\UseCase\UseCaseOutput\IncomesEditOutput;
use App\Domain\Entity\Incomes;

class IncomesEditInteractor {
    private $incomesEditCommand;
    private $incomesEditInput;

    public function __construct(IncomesRepository $incomesEditCommand, IncomesEditInput $input) {
        $this->incomesEditCommand = $incomesEditCommand;
        $this->incomesEditInput = $input;
    }

    public function handle(): IncomesEditOutput {
        try {
            $id = $this->incomesEditInput->getId();
            $amount = $this->incomesEditInput->getAmount();
            $accrualDate = $this->incomesEditInput->getAccrualDate();
            $incomeSourceId = $this->incomesEditInput->getIncomeSourceId();

            $income = new Incomes($id, $incomeSourceId, $amount, $accrualDate);

            $this->incomesEditCommand->update($income);

            return new IncomesEditOutput(true, $income, "収入情報が正常に更新されました。");
        } catch (\Exception $e) {
            return new IncomesEditOutput(false, null, "更新に失敗しました: " . $e->getMessage());
        }
    }
}