<?php

namespace App\Infrastructure\Dao;

use PDO;
use Exception;
use App\Domain\Entity\Incomes;

class IncomesDao {
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO('mysql:dbname=kakeibo;host=mysql;charset=utf8', 'root', 'password');
        } catch (PDOException $e) {
            throw new Exception('DB接続エラー: ' . $e->getMessage());
        }
    }

    public function save(Incomes $incomes, int $userId) {
        $stmt = $this->pdo->prepare("INSERT INTO incomes (user_id, income_source_id, amount, accrual_date) VALUES (?, ?, ?, ?)");
        $result = $stmt->execute([
            $userId,
            $incomes->getIncomeSourceId(),
            $incomes->getAmount(),
            $incomes->getAccrualDate()
        ]);

        if (!$result) {
            throw new Exception("収入の保存に失敗しました。");
        }
    }

    public function fetchIncomeSources() {
        $stmt = $this->pdo->query("SELECT * FROM income_sources");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchIncomesWithFilter($year, $categoryId = null, $startDate = null, $endDate = null) {
        $query = "SELECT * FROM incomes WHERE YEAR(accrual_date) = :year";
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

        // 収入の合計を取得するメソッド
    public function getTotalIncomesByMonthAndYear($year, $month) {
        $stmt = $this->pdo->prepare("SELECT SUM(amount) as total_income FROM incomes WHERE YEAR(accrual_date) = :year AND MONTH(accrual_date) = :month");
        $stmt->execute([':year' => $year, ':month' => $month]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['total_income'] : 0;
    }
}