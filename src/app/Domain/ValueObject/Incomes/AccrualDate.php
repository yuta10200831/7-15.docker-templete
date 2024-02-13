<?php

namespace App\Domain\ValueObject\Incomes;

class AccrualDate
{
    private $value;

    public function __construct(string $value)
    {
        if (!$this->isValidDate($value)) {
            throw new \InvalidArgumentException("不正な日付フォーマットです。");
        }
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function isValidDate(string $date): bool
    {
        return (bool)preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) && strtotime($date) !== false;
    }
}