<?php

namespace App\Exceptions;

use Exception;

class ExpandException extends Exception {
    private $errors;

    public function __construct($errors, $code) {
        if (is_string($errors)) {
            $error[] = $errors;
            $this->errors = $error;
        } else {
            $this->errors = $errors;
        }
        parent::__construct(reset($this->errors), $code);
    }

    public function getErrors() {
        return $this->errors;
    }
}