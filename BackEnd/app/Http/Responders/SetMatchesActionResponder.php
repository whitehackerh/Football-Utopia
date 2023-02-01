<?php

namespace App\Http\Responders;

use App\Http\Responders\BaseResponder;

class SetMatchesActionResponder extends BaseResponder {
    private $apiName = 'setMatchesAction';

    public function __construct($expandException = null) {
        parent::__construct($this->apiName, $expandException);
    }
}
