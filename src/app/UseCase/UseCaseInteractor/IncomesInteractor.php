<?php

namespace App\UseCase\UseCaseInteractor;

use App\Domain\Entity\Incomes;
use App\Domain\Port\IIncomesCommand;
use App\UseCase\UseCaseInput\IncomesInput;
use App\UseCase\UseCaseOutput\IncomesOutput;

class IncomesInteractor {
    private $incomesCommand;
    private $input;

    public function __construct(IIncomesCommand $incomesCommand, IncomesInput $input) {
        $this->incomesCommand = $incomesCommand;
        $this->input = $input;
    }

    public function handle(): IncomesOutput {
        try {
            $incomes = new Incomes(
                null,
                $this->input->getIncomesSourceId()->getValue(),
                $this->input->getAmount()->getValue(),
                $this->input->getAccrualDate()->getValue()
            );

            $this->incomesCommand->save($incomes);

            return new IncomesOutput(true, "収入情報が正常に登録されました。");
        } catch (\Exception $e) {
            return new IncomesOutput(false, "収入情報の登録に失敗しました: " . $e->getMessage());
        }
    }
}