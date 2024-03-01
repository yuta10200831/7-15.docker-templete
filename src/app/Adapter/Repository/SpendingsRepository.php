<?php

namespace App\Adapter\Repository;

use App\Domain\Port\ISpendingsCommand;
use App\Domain\Port\ISpendingsEditCommand;
use App\Domain\Entity\Spendings;
use App\Infrastructure\Dao\SpendingsDao;

class SpendingsRepository implements ISpendingsCommand, ISpendingsEditCommand {
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

    public function update(Spendings $spendings): void {
        $id = $spendings->getId();
        $name = $spendings->getSpendingsName();
        $category_id = $spendings->getCategoryId();
        $amount = $spendings->getAmount();
        $accrual_date = $spendings->getAccrualDate();

        $this->spendingsDao->updateSpending($id, $name, $category_id, $amount, $accrual_date);
    }

    public function find(int $id): ?Spendings {
        $data = $this->spendingsDao->fetchSpendingById($id);
        if (!$data) {
            return null;
        }

        return new Spendings(
            $data['id'],
            $data['name'],
            $data['category_id'],
            $data['amount'],
            $data['accrual_date']
        );
    }
}