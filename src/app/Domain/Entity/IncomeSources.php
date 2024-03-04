<?php

namespace App\Domain\Entity;

class IncomeSources
{
    private $id;
    private $userId;
    private $incomeSourcesName;

    public function __construct($id, $userId, $incomeSourcesName)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->incomeSourcesName = $incomeSourcesName;
    }

    public function getId()
    {
        return $this->id;
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