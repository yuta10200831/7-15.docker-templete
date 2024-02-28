<?php

namespace App\UseCase\UseCaseInput;

class IncomesEditInput {
    private $id;
    private $amount;
    private $accrualDate;
    private $incomeSourceId;

    public function __construct($id, $amount, $accrualDate, $incomeSourceId) {
        $this->id = $id;
        $this->amount = $amount;
        $this->accrualDate = $accrualDate;
        $this->incomeSourceId = $incomeSourceId;
    }

    public function getId() {
        return $this->id;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function getAccrualDate() {
        return $this->accrualDate;
    }

    public function getIncomeSourceId() {
        return $this->incomeSourceId;
    }
}