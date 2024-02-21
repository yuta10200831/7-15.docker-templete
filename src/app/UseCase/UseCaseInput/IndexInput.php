<?php

namespace App\UseCase\UseCaseInput;

class IndexInput {
    private $year;

    public function __construct($year) {
        $this->year = $year;
    }

    public function getYear() {
        return $this->year;
    }
}