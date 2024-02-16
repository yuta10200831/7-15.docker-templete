<?php

namespace App\UseCase\UseCaseInteractor;

use App\Domain\Port\ISpendingsCommand;
use App\UseCase\UseCaseInput\SpendingsInput;
use App\UseCase\UseCaseOutput\SpendingsOutput;
use App\Domain\Entity\Spendings;

class SpendingsInteractor {
    private $spendingsCommand;
    private $input;

    public function __construct(ISpendingsCommand $spendingsCommand, SpendingsInput $input) {
        $this->spendingsCommand = $spendingsCommand;
        $this->input = $input;
    }

    public function handle(): SpendingsOutput {
      try {
        $spendings = new Spendings(
            $this->input->getSpendingsName()->value(),
            $this->input->getCategoryId()->getValue(),
            $this->input->getAmount()->getValue(),
            $this->input->getAccrualDate()->getValue()
        );

        $this->spendingsCommand->save($spendings);

        return new SpendingsOutput(true, "支出情報が正常に登録されました。");
      } catch (\Exception $e) {
        return new SpendingsOutput(false, "支出情報の登録に失敗しました: " . $e->getMessage());
      }
    }
}