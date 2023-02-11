<?php

namespace App\Http\Responders;

use App\Http\Responders\BaseResponder;

class SetMatchActionResponder extends BaseResponder {
    private $apiName = 'setMatchAction';

    public function __construct($expandException = null) {
        parent::__construct($this->apiName, $expandException);
    }
}
