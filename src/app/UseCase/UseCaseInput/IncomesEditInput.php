<?php

namespace App\UseCase\UseCaseInput;

class IncomesEditInput {
    private int $id;
    private float $amount;
    private \DateTime $accrualDate;
    private int $incomeSourceId;

    public function __construct(int $id, float $amount, \DateTime $accrualDate, int $incomeSourceId) {
        $this->id = $id;
        $this->amount = $amount;
        $this->accrualDate = $accrualDate;
        $this->incomeSourceId = $incomeSourceId;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getAmount(): float {
        return $this->amount;
    }

    public function getAccrualDate(): \DateTime {
        return $this->accrualDate;
    }

    public function getIncomeSourceId(): int {
        return $this->incomeSourceId;
    }
}