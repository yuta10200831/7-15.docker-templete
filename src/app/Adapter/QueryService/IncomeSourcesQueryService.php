<?php

namespace App\Adapter\QueryService;

use App\Infrastructure\Dao\IncomeSourcesDao;
use App\Domain\Port\IIncomeSourcesQuery;
use App\Domain\Entity\IncomeSources;

class IncomeSourcesQueryService implements IIncomeSourcesQuery {
    private $incomeSourcesDao;

    public function __construct(IncomeSourcesDao $incomeSourcesDao) {
        $this->incomeSourcesDao = $incomeSourcesDao;
    }

    public function findAll(): array {
        try {
            $incomeSourcesData = $this->incomeSourcesDao->findAll();
            $incomeSourcesList = [];
            foreach ($incomeSourcesData as $data) {
                $incomeSourcesList[] = new IncomeSources(
                    $data['user_id'],
                    $data['name']
                );
            }
            return $incomeSourcesList;
        } catch (Exception $e) {
            throw new Exception("収入源の取得に失敗しました。エラー詳細: " . $e->getMessage());
        }
    }
}