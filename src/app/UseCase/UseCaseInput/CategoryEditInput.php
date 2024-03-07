<?php

namespace App\UseCase\UseCaseInput;

class CategoryEditInput
{
    private $id;
    private $name;
    private $userId;

    public function __construct(int $id, string $name, int $userId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->userId = $userId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}