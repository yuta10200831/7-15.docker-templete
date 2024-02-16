<?php

namespace App\Domain\ValueObject\Spendings;
use \Exception;

final class SpendingsName
{
    private $value;

    public function __construct(string $value)
    {
        if (mb_strlen($value) > 10) {
            throw new \Exception('支出名は10文字以内で入力お願いします');
        }

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}