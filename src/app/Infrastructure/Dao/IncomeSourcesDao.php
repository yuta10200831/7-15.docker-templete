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

}