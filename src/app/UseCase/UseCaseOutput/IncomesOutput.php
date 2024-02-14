<?php

namespace App\UseCase\UseCaseOutput;

class IncomesOutput {
    private $success;
    private $message;
    private $incomeId;

    public function __construct($success, $message, $incomeId = null) {
        $this->success = $success;
        $this->message = $message;
        $this->incomeId = $incomeId;
    }

    public function isSuccess() {
        return $this->success;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getIncomeId() {
        return $this->incomeId;
    }
}