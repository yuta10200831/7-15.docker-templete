<?php

namespace App\Adapter\Repository;

use App\Domain\Port\ISpendingsCommand;
use App\Domain\Entity\Spendings;
use App\Infrastructure\Dao\SpendingsDao;

class SpendingsRepository implements ISpendingsCommand {
    private $spendingsDao;

    public function __construct(SpendingsDao $spendingsDao) {
        $this->spendingsDao = $spendingsDao;
    }

    public function save(Spendings $spendings): void {
    $userId = $_SESSION['user']['id'] ?? null;

        if ($userId === null) {
            throw new \Exception("収入情報を登録するためにはログインが必要です。");
        }

        $this->spendingsDao->save($spendings, $userId);
    }
}