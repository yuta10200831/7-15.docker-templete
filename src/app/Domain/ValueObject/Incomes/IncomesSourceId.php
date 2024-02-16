<?php

namespace App\Domain\ValueObject\Incomes;

class IncomesSourceId
{
    private $value;

    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException("収入源IDは正の整数でなければなりません。");
        }
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}