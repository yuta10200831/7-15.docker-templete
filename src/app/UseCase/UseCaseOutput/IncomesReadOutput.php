<?php

namespace App\UseCase\UseCaseOutput;

class IncomesReadOutput {
    private $success;
    private $message;
    private $incomes;

    public function __construct(bool $success, string $message, array $incomes = []) {
        $this->success = $success;
        $this->message = $message;
        $this->incomes = $incomes;
    }

    public function isSuccess(): bool {
        return $this->success;
    }

    public function getMessage(): string {
        return $this->message;
    }

    public function getIncomes(): array {
        return $this->incomes;
    }
}