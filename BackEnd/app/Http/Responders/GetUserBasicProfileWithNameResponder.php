<?php

namespace App\Http\Responders;

use App\Http\Responders\BaseResponder;

class GetUserBasicProfileWithNameResponder extends BaseResponder {
    private $apiName = 'getUserBasicProfileWithName';

    public function __construct($expandException = null) {
        parent::__construct($this->apiName, $expandException);
    }
}
