<?php

namespace App\Http\Responders;

use App\Http\Responders\BaseResponder;

class GetMatchHistoryResponder extends BaseResponder {
    private $apiName = 'getMatchHistory';

    public function __construct($expandException = null) {
        parent::__construct($this->apiName, $expandException);
    }
}
