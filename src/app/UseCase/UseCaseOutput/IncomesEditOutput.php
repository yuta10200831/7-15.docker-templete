<?php

namespace App\UseCase\UseCaseOutput;

use App\Domain\Entity\Incomes;

class IncomesEditOutput {
    private $success;
    private $income;
    private $message;

    public function __construct(bool $success, ?Incomes $income, string $message) {
        $this->success = $success;
        $this->income = $income;
        $this->message = $message;
    }

    public function isSuccess(): bool {
        return $this->success;
    }

    public function getIncome(): ?Incomes {
        return $this->income;
    }

    public function getMessage(): string {
        return $this->message;
    }
}