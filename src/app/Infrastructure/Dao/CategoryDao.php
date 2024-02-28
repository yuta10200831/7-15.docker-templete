<?php

namespace App\Infrastructure\Dao;

use PDO;
use PDOException;
use Exception;
use App\Domain\Entity\Category;

class CategoryDao {
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO('mysql:dbname=kakeibo;host=mysql;charset=utf8', 'root', 'password');
        } catch (PDOException $e) {
            throw new Exception('DB接続エラー: ' . $e->getMessage());
        }
    }

    public function saveCategory(Category $category): bool {
        $stmt = $this->pdo->prepare("INSERT INTO categories (user_id, name) VALUES (?, ?)");
        $result = $stmt->execute([
            $category->getUserId(),
            $category->getName()
        ]);

        if (!$result) {
            $errorInfo = $this->pdo->errorInfo();
            throw new Exception("カテゴリの保存に失敗しました。エラー詳細: " . $errorInfo[2]);
        }

        return $result;
    }

    public function isCategoryExists(string $name): bool {
        $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE name = :name");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch();
        return $result !== false;
    }

    public function fetchAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM categories");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}