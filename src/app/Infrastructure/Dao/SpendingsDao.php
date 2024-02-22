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

    public function fetchSpendingsWithFilter($year, $categoryId = null, $startDate = null, $endDate = null) {
        $query = "SELECT * FROM spendings WHERE YEAR(accrual_date) = :year";
        $params = [':year' => $year];

        if ($categoryId !== null) {
            $query .= " AND category_id = :categoryId";
            $params[':categoryId'] = $categoryId;
        }
        if ($startDate !== null) {
            $query .= " AND accrual_date >= :startDate";
            $params[':startDate'] = $startDate;
        }
        if ($endDate !== null) {
            $query .= " AND accrual_date <= :endDate";
            $params[':endDate'] = $endDate;
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

        // 支出の合計を取得するメソッド
    public function getTotalSpendingsByMonthAndYear($year, $month) {
        $stmt = $this->pdo->prepare("SELECT SUM(amount) as total_spend FROM spendings WHERE YEAR(accrual_date) = :year AND MONTH(accrual_date) = :month");
        $stmt->execute([':year' => $year, ':month' => $month]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['total_spend'] : 0;
    }
}