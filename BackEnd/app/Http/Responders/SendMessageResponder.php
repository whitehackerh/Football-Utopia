<?php

namespace App\Http\Responders;

use App\Http\Responders\BaseResponder;

class SendMessageResponder extends BaseResponder {
    private $apiName = 'sendMessage';

    public function __construct($expandException = null) {
        parent::__construct($this->apiName, $expandException);
    }
}
