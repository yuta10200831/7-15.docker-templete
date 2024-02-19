<?php

namespace App\Domain\Entity;

class Category
{
    private $id;
    private $name;
    private $userId;

    public function __construct($id, $name, $userId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->userId = $userId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getUserId()
    {
        return $this->userId;
    }
}