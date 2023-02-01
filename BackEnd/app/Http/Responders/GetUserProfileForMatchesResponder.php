<?php

namespace App\Http\Responders;

use App\Http\Responders\BaseResponder;

class GetUserProfileForMatchesResponder extends BaseResponder {
    private $apiName = 'getUserProfileForMatches';

    public function __construct($expandException = null) {
        parent::__construct($this->apiName, $expandException);
    }
}
