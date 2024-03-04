<?php

namespace App\Adapter\Repository;

use App\Domain\Port\IIncomesCommand;
use App\Domain\Port\IIncomesEditCommand;
use App\Domain\Entity\Incomes;
use App\Infrastructure\Dao\IncomesDao;
use App\Domain\ValueObject\Incomes\Amount;
use App\Domain\ValueObject\Incomes\AccrualDate;
use Exception;

class IncomesRepository implements IIncomesCommand, IIncomesEditCommand {
    private $incomesDao;

    public function __construct(IncomesDao $incomesDao) {
        $this->incomesDao = $incomesDao;
    }

    public function save(Incomes $incomes): void {
        $userId = $_SESSION['user']['id'] ?? null;

        if ($userId === null) {
            throw new Exception("収入情報を登録するためにはログインが必要です。");
        }

        $this->incomesDao->save($incomes, $userId);
    }

    public function update(Incomes $income): void {
        $id = $income->getId();
        $amount = $income->getAmount();
        $accrualDate = $income->getAccrualDate();
        $incomeSourceId = $income->getIncomeSourceId();

        $this->incomesDao->update($income);
    }
}