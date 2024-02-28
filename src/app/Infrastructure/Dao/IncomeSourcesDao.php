<?php

namespace App\Infrastructure\Dao;

use PDO;
use PDOException;
use Exception;
use App\Domain\Entity\IncomeSources;

class IncomeSourcesDao {
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO('mysql:dbname=kakeibo;host=mysql;charset=utf8', 'root', 'password');
        } catch (PDOException $e) {
            throw new Exception('DB接続エラー: ' . $e->getMessage());
        }
    }

    public function save(IncomeSources $incomeSources) {
        $stmt = $this->pdo->prepare("INSERT INTO income_sources (user_id, name) VALUES (?, ?)");
        $result = $stmt->execute([
            $incomeSources->getUserId(),
            $incomeSources->getIncomeSourcesName()
        ]);

        if (!$result) {
            $errorInfo = $this->pdo->errorInfo();
            throw new Exception("収入源の保存に失敗しました。エラー詳細: " . $errorInfo[2]);
        }
    }

    public function findAll(): array {
        $sql = "SELECT id, user_id, name FROM income_sources";
        $stmt = $this->pdo->query($sql);

        if ($stmt === false) {
            throw new Exception("クエリの実行に失敗しました。");
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update(IncomeSources $incomeSources): void {
        $stmt = $this->pdo->prepare("UPDATE income_sources SET name = :name WHERE id = :id");
        $result = $stmt->execute([
            ':id' => $incomeSources->getId(),
            ':name' => $incomeSources->getIncomeSourcesName()
        ]);

        if (!$result) {
            throw new Exception("収入源の更新に失敗しました。");
        }
    }

    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM income_sources WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}