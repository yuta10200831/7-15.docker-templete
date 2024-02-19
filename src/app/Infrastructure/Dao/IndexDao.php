<?php

namespace App\Infrastructure\Dao;

use PDO;
use PDOException;
use App\Domain\Entity\Spendings;
use App\Domain\Entity\Incomes;

class IndexDao {
    private $pdo;

    public function __construct() {
        $dsn = 'mysql:dbname=kakeibo;host=mysql;charset=utf8';
        $username = 'root';
        $password = 'password';
        try {
            $this->pdo = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            error_log('DB connection error: ' . $e->getMessage());
            throw new \Exception('Database connection error.');
        }
    }

    public function getMonthlySummary($year) {
      $monthlySummary = [];
      for ($month = 1; $month <= 12; $month++) {
          // 収入の合計を取得
          $incomeStmt = $this->pdo->prepare("SELECT SUM(amount) as total_income FROM incomes WHERE YEAR(accrual_date) = :year AND MONTH(accrual_date) = :month");
          $incomeStmt->execute([':year' => $year, ':month' => $month]);
          $incomeResult = $incomeStmt->fetch(PDO::FETCH_ASSOC);
          $totalIncome = $incomeResult['total_income'] ?? 0;

          // 支出の合計を取得
          $spendingStmt = $this->pdo->prepare("SELECT SUM(amount) as total_spend FROM spendings WHERE YEAR(accrual_date) = :year AND MONTH(accrual_date) = :month");
          $spendingStmt->execute([':year' => $year, ':month' => $month]);
          $spendingResult = $spendingStmt->fetch(PDO::FETCH_ASSOC);
          $totalSpend = $spendingResult['total_spend'] ?? 0;

          // 月ごとのサマリーを配列に追加
          $monthlySummary[$month] = [
              'month' => $month,
              'total_income' => $totalIncome,
              'total_spending' => $totalSpend,
              'balance' => $totalIncome - $totalSpend,
          ];
      }
      return $monthlySummary;
  }

  public function fetchSpendingsWithFilter($year, $categoryId, $startDate, $endDate): array {
    $query = "SELECT * FROM spendings WHERE YEAR(accrual_date) = :year";

    if ($categoryId !== null) {
        $query .= " AND category_id = :categoryId";
    }
    if ($startDate !== null) {
        $query .= " AND accrual_date >= :startDate";
    }
    if ($endDate !== null) {
        $query .= " AND accrual_date <= :endDate";
    }

    $stmt = $this->pdo->prepare($query);

    $stmt->bindParam(':year', $year);
    if ($categoryId !== null) {
        $stmt->bindParam(':categoryId', $categoryId);
    }
    if ($startDate !== null) {
        $stmt->bindParam(':startDate', $startDate);
    }
    if ($endDate !== null) {
        $stmt->bindParam(':endDate', $endDate);
    }

    $stmt->execute();
    $results = $stmt->fetchAll();

    $spendingsEntities = [];
    foreach ($results as $result) {
        $spendingsEntities[] = new Spendings(
            $result['id'],
            $result['category_id'],
            $result['amount'],
            new \DateTime($result['accrual_date']),
          );
    }

    return $spendingsEntities;
}

    public function fetchIncomesWithFilter($year, $categoryId, $startDate, $endDate): array {
      $query = "SELECT * FROM incomes WHERE YEAR(accrual_date) = :year";

      if ($categoryId !== null) {
          $query .= " AND category_id = :categoryId";
      }
      if ($startDate !== null) {
          $query .= " AND accrual_date >= :startDate";
      }
      if ($endDate !== null) {
          $query .= " AND accrual_date <= :endDate";
      }

      $stmt = $this->pdo->prepare($query);

      $stmt->bindParam(':year', $year);
      if ($categoryId !== null) {
          $stmt->bindParam(':categoryId', $categoryId);
      }
      if ($startDate !== null) {
          $stmt->bindParam(':startDate', $startDate);
      }
      if ($endDate !== null) {
          $stmt->bindParam(':endDate', $endDate);
      }

      $stmt->execute();
      $results = $stmt->fetchAll();

      $incomesEntities = [];
      foreach ($results as $result) {
          $incomesEntities[] = new Incomes(
              $result['income_source_id'],
              $result['amount'],
              new \DateTime($result['accrual_date']),
          );
      }

      return $incomesEntities;
    }
}