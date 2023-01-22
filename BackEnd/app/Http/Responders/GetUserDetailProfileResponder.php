<?php

namespace App\Http\Responders;

use App\Http\Responders\BaseResponder;

class GetUserDetailProfileResponder extends BaseResponder {
    private $apiName = 'getUserDetailProfile';

    public function __construct($expandException = null) {
        parent::__construct($this->apiName, $expandException);
    }
}
