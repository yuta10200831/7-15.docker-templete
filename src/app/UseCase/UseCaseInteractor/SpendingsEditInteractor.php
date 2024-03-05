<?php

namespace App\UseCase\UseCaseInteractor;

use App\Domain\Port\ISpendingsEditCommand;
use App\Domain\Entity\Spendings;
use App\UseCase\UseCaseInput\SpendingsEditInput;
use App\UseCase\UseCaseOutput\SpendingsEditOutput;

class SpendingsEditInteractor {
    private ISpendingsEditCommand $spendingsEditCommand;
    private SpendingsEditInput $input;

    public function __construct(ISpendingsEditCommand $spendingsEditCommand, SpendingsEditInput $input) {
        $this->spendingsEditCommand = $spendingsEditCommand;
        $this->input = $input;
    }

    public function handle(): SpendingsEditOutput {
        $spendings = new Spendings(
            $this->input->id,
            $this->input->name,
            $this->input->categoryId,
            $this->input->amount,
            $this->input->accrualDate
        );

        try {
            $this->spendingsEditCommand->update($spendings);
            return new SpendingsEditOutput(true, "支出データの更新に成功しました。");
        } catch (\Exception $e) {
            return new SpendingsEditOutput(false, "支出データの更新に失敗しました。" . $e->getMessage());
        }
    }
}