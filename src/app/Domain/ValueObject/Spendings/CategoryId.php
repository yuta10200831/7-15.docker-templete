<?php

namespace App\Domain\ValueObject\Spendings;

class CategoryId
{
    private $value;

    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException("カテゴリIDは正の整数でなければなりません。");
        }
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}