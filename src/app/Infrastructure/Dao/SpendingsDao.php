<?php

namespace App\Infrastructure\Dao;

use PDO;
use PDOException;
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

    public function fetchAllSpendings($categoryId = null, $startDate = null, $endDate = null) {
        $sql = "SELECT * FROM spendings WHERE 1=1";
        $params = [];

        if (!is_null($categoryId) && $categoryId !== '') {
            $sql .= " AND category_id = ?";
            $params[] = $categoryId;
        }

        if (!empty($startDate)) {
            $sql .= " AND accrual_date >= ?";
            $params[] = $startDate;
        }

        if (!empty($endDate)) {
            $sql .= " AND accrual_date <= ?";
            $params[] = $endDate;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategories() {
        $stmt = $this->pdo->query("SELECT * FROM categories");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchSpendingsByCategoryId($categoryId) {
        $stmt = $this->pdo->prepare("SELECT * FROM spendings WHERE category_id = ?");
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateSpending(int $id, string $name, int $category_id, float $amount, string $accrual_date) {
        $sql = "UPDATE spendings SET name = ?, category_id = ?, amount = ?, accrual_date = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute([$name, $category_id, $amount, $accrual_date, $id]);

        if (!$result) {
            throw new Exception("支出情報の更新に失敗しました。");
        }
    }

    public function fetchSpendingById(int $id) {
        $stmt = $this->pdo->prepare("SELECT * FROM spendings WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchSpendingWithCategoryById($id) {
        $sql = "SELECT s.*, c.name AS category_name
                FROM spendings s
                JOIN categories c ON s.category_id = c.id
                WHERE s.id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return $data;
        } else {
            return null;
        }
    }
}