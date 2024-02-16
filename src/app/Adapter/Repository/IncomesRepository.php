<?php

namespace App\Adapter\Repository;

use App\Domain\Port\IIncomesCommand;
use App\Domain\Entity\Incomes;
use App\Infrastructure\Dao\IncomesDao;

class IncomesRepository implements IIncomesCommand {
    private $incomesDao;

    public function __construct(IncomesDao $incomesDao) {
        $this->incomesDao = $incomesDao;
    }

    public function save(Incomes $incomes): void {
        $userId = $_SESSION['user']['id'] ?? null;

        if ($userId === null) {
            throw new \Exception("収入情報を登録するためにはログインが必要です。");
        }

        $this->incomesDao->save($incomes, $userId);
    }
}