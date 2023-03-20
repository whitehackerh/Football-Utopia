<?php

namespace App\Http\Responders;

use App\Http\Responders\BaseResponder;

class GetUnreadMessagesResponder extends BaseResponder {
    private $apiName = 'getUnreadMessages';

    public function __construct($expandException = null) {
        parent::__construct($this->apiName, $expandException);
    }
}
