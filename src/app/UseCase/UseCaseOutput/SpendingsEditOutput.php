<?php

namespace App\UseCase\UseCaseOutput;

class SpendingEditOutput {
    public bool $success;
    public string $message;

    public function __construct(bool $success, string $message) {
        $this->success = $success;
        $this->message = $message;
    }
}