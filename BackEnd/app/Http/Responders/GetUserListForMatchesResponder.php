<?php

namespace App\Http\Responders;

use App\Http\Responders\BaseResponder;

class GetUserListForMatchesResponder extends BaseResponder {
    private $apiName = 'getUserListForMatches';

    public function __construct($expandException = null) {
        parent::__construct($this->apiName, $expandException);
    }
}
