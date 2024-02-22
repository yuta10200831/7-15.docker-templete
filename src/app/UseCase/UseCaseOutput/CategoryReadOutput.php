<?php

namespace App\UseCase\UseCaseOutput;

class CategoryReadOutput
{
    private bool $success;
    private string $message;
    private array $categories;

    public function __construct(bool $success, string $message, array $categories = [])
    {
        $this->success = $success;
        $this->message = $message;
        $this->categories = $categories;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }
}