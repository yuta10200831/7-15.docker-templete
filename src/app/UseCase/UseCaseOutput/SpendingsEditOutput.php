<?php

namespace App\UseCase\UseCaseOutput;

class SpendingsEditOutput {
    public bool $success;
    public string $message;

    public function __construct(bool $success, string $message) {
        $this->success = $success;
        $this->message = $message;
    }

    public function isSuccess() {
        return $this->success;
    }

    public function getMessage() {
        return $this->message;
    }
}