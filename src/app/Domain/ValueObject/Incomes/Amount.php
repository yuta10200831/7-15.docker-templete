<?php

namespace App\Domain\ValueObject\Incomes;

class Amount
{
    private $value;

    public function __construct(float $value)
    {
        if ($value < 0) {
            throw new \InvalidArgumentException('金額は0以上でなければなりません。');
        }
        $this->value = $value;
    }

    public function getValue(): float
    {
        return $this->value;
    }
}