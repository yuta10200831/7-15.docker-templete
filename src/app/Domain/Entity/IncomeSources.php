<?php

namespace App\Domain\Entity;

class IncomeSources
{
    private $userId;
    private $incomeSourcesName;

    public function __construct($userId, $incomeSourcesName)
    {
        $this->userId = $userId;
        $this->incomeSourcesName = $incomeSourcesName;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getIncomeSourcesName()
    {
        return $this->incomeSourcesName;
    }
}