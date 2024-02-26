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

    public function fetchIncomesFiltered($incomeSourceId, $startDate, $endDate) {
        $sql = "SELECT incomes.*, income_sources.name AS income_source_name FROM incomes";
        $sql .= " JOIN income_sources ON incomes.income_source_id = income_sources.id WHERE 1=1";
        $params = [];

        if (!empty($incomeSourceId)) {
            $sql .= " AND incomes.income_source_id = ?";
            $params[] = $incomeSourceId;
        }

        if (!empty($startDate) && !empty($endDate)) {
            $sql .= " AND incomes.accrual_date BETWEEN ? AND ?";
            $params[] = $startDate;
            $params[] = $endDate;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}