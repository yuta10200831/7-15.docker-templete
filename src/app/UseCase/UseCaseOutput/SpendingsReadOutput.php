<?php

namespace App\UseCase\UseCaseOutput;

class SpendingsReadOutput
{
    private $success;
    private $message;
    private $spendings;

    public function __construct(bool $success, string $message, array $spendings)
    {
        $this->success = $success;
        $this->message = $message;
        $this->spendings = $spendings;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getSpendings(): array
    {
        return $this->spendings;
    }
}