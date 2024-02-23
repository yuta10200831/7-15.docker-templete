<?php

namespace App\UseCase\UseCaseOutput;

class IncomesOutput {
    private bool $success;
    private string $message;
    private ?int $incomeId;

    public function __construct(bool $success, string $message, ?int $incomeId = null) {
        $this->success = $success;
        $this->message = $message;
        $this->incomeId = $incomeId;
    }

    public function isSuccess(): bool {
        return $this->success;
    }

    public function getMessage(): string {
        return $this->message;
    }

    public function getIncomeId(): ?int {
        return $this->incomeId;
    }
}