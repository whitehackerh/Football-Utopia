<?php

namespace App\Http\Responders;

use App\Http\Responders\BaseResponder;

class GetLatestMessageListResponder extends BaseResponder {
    private $apiName = 'getLatestMessageList';

    public function __construct($expandException = null) {
        parent::__construct($this->apiName, $expandException);
    }
}
