<?php

namespace App\Http\Responders;

use App\Http\Responders\BaseResponder;

class GetMessagesResponder extends BaseResponder {
    private $apiName = 'getMessages';

    public function __construct($expandException = null) {
        parent::__construct($this->apiName, $expandException);
    }
}
