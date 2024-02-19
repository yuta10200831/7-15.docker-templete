<?php

namespace App\UseCase\UseCaseOutput;

class IndexOutput {
    private $success;
    private $message;
    private $monthlySummary;

    public function __construct($success, $message, array $monthlySummary) {
        $this->success = $success;
        $this->message = $message;
        $this->monthlySummary = $monthlySummary;
    }

    public function isSuccess() {
        return $this->success;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getMonthlySummary() {
        return $this->monthlySummary;
    }
}