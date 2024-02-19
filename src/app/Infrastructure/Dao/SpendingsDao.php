<?php

namespace App\Infrastructure\Dao;

use PDO;
use Exception;
use App\Domain\Entity\Spendings;

class SpendingsDao {
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO('mysql:dbname=kakeibo;host=mysql;charset=utf8', 'root', 'password');
        } catch (PDOException $e) {
            throw new Exception('DB接続エラー: ' . $e->getMessage());
        }
    }

    public function save(Spendings $spendings, int $userId) {
        $stmt = $this->pdo->prepare("INSERT INTO spendings (user_id, name, category_id, amount, accrual_date) VALUES (?, ?, ?, ?, ?)");
        $result = $stmt->execute([
            $userId,
            $spendings->getSpendingsName(),
            $spendings->getCategory_id(),
            $spendings->getAmount(),
            $spendings->getAccrualDate()
        ]);

        if (!$result) {
            throw new Exception("支出情報の保存に失敗しました。");
        }
    }
}