<?php

namespace App\UseCase\UseCaseInteractor;

use App\UseCase\UseCaseInput\SpendingsReadInput;
use App\UseCase\UseCaseOutput\SpendingsReadOutput;
use App\Adapter\QueryService\SpendingsQueryService;
use Exception;

class SpendingsReadInteractor {
    private $spendingsQueryService;
    private $spendingsReadInput;

    public function __construct(SpendingsQueryService $spendingsQueryService, SpendingsReadInput $input) {
        $this->spendingsQueryService = $spendingsQueryService;
        $this->spendingsReadInput = $input;
    }

    public function handle(): SpendingsReadOutput {
      try {
          $spendings = $this->spendingsQueryService->fetchAllSpendings(
              $this->spendingsReadInput->getCategoryId(),
              $this->spendingsReadInput->getStartDate(),
              $this->spendingsReadInput->getEndDate()
          );

          if (empty($spendings)) {
              return new SpendingsReadOutput(false, "データが見つかりませんでした。", []);
          }

          $categories = $this->spendingsQueryService->getCategories();
          $categoryNameMap = [];
          foreach ($categories as $category) {
              $categoryNameMap[$category['id']] = $category['name'];
          }

          $spendingsData = array_map(function ($spending) use ($categoryNameMap) {
              $spending['category_name'] = $categoryNameMap[$spending['category_id']] ?? 'カテゴリなし';
              return $spending;
          }, $spendings);

          return new SpendingsReadOutput(true, "データ取得に成功しました。", $spendingsData);
      } catch (Exception $e) {
          return new SpendingsReadOutput(false, "支出情報の取得に失敗しました。エラー詳細: " . $e->getMessage(), []);
      }
  }
}