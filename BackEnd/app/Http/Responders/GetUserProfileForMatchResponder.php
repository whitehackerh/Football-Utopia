<?php

namespace App\Http\Responders;

use App\Http\Responders\BaseResponder;

class GetUserProfileForMatchResponder extends BaseResponder {
    private $apiName = 'getUserProfileForMatch';

    public function __construct($expandException = null) {
        parent::__construct($this->apiName, $expandException);
    }
}
