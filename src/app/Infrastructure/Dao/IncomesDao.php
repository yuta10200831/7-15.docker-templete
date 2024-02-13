<?php

namespace App\Infrastructure\Dao;

use \PDO;
use \Exception;
use App\Domain\Entity\Income;

class IncomesDao
{
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO(
                'mysql:dbname=kakeibo;host=mysql;charset=utf8',
                'root',
                'password'
            );
        } catch (\PDOException $e) {
            throw new Exception('DB接続エラー: ' . $e->getMessage());
        }
    }

    public function save(Income $income)
    {
        $stmt = $this->pdo->prepare("INSERT INTO incomes (user_id, income_source_id, amount, accrual_date) VALUES (?, ?, ?, ?)");
        $result = $stmt->execute([
            $income->getUserId(),
            $income->getIncomeSourceId(),
            $income->getAmount(),
            $income->getAccrualDate()
        ]);

        if (!$result) {
            throw new Exception("Incomeの保存に失敗しました。");
        }
    }
}