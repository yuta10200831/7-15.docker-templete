<?php

namespace App\UseCase\UseCaseInteractor;

use App\Domain\Port\ISpendingsEditCommand;
use App\Domain\Entity\Spendings;
use App\UseCase\UseCaseInput\SpendingEditInput;
use App\UseCase\UseCaseInput\SpendingEditOutput;

class SpendingEditInteractor {
    private ISpendingsEditCommand $spendingsEditCommand;
    private SpendingEditInput $input;

    public function __construct(ISpendingsEditCommand $spendingsEditCommand, SpendingEditInput $input) {
        $this->spendingsEditCommand = $spendingsEditCommand;
        $this->input = $input;
    }

    public function handle(): SpendingEditOutput {
        $spendings = new Spendings(
            $this->input->id,
            $this->input->name,
            $this->input->categoryId,
            $this->input->amount,
            $this->input->accrualDate
        );

        try {
            $this->spendingsEditCommand->update($spendings);
            return new SpendingEditOutput(true, "支出データの更新に成功しました。");
        } catch (\Exception $e) {
            return new SpendingEditOutput(false, "支出データの更新に失敗しました。" . $e->getMessage());
        }
    }
}