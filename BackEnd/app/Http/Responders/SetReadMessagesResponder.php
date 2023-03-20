<?php

namespace App\Http\Responders;

use App\Http\Responders\BaseResponder;

class SetReadMessagesResponder extends BaseResponder {
    private $apiName = 'setReadMessages';

    public function __construct($expandException = null) {
        parent::__construct($this->apiName, $expandException);
    }
}