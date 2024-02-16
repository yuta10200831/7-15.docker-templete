<?php

namespace App\Domain\ValueObject\Incomes;
use \Exception;

final class IncomeSourcesName
{
    private $value;

    public function __construct(string $value)
    {
        if (mb_strlen($value) > 10) {
            throw new \Exception('収入源名は10文字以内で入力お願いします');
        }

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}