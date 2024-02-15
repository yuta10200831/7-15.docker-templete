<?php

namespace App\UseCase\UseCaseInteractor;

use App\Domain\Entity\IncomeSources;
use App\Domain\Port\IIncomeSourcesCommand;
use App\UseCase\UseCaseInput\IncomeSourcesInput;
use App\UseCase\UseCaseOutput\IncomeSourcesOutput;

class IncomeSourcesInteractor {
    private $incomeSourcesCommand;
    private $input;

    public function __construct(IIncomeSourcesCommand $incomeSourcesCommand, IncomeSourcesInput $input) {
        $this->incomeSourcesCommand = $incomeSourcesCommand;
        $this->input = $input;
    }

    public function handle(): IncomeSourcesOutput {
        try {
        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) {
            throw new Exception('ユーザーIDが取得できません。');
        }

        $incomeSources = new IncomeSources(
            $userId,
            $this->input->getIncomeSourcesName()->value()
        );

            $this->incomeSourcesCommand->save($incomeSources);

            return new IncomeSourcesOutput(true, "収入源情報が正常に登録されました。");
        } catch (\Exception $e) {
            return new IncomeSourcesOutput(false, "収入源情報の登録に失敗しました: " . $e->getMessage());
        }
    }
}