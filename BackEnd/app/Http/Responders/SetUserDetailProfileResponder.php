<?php

namespace App\Http\Responders;

use App\Http\Responders\BaseResponder;

class SetUserDetailProfileResponder extends BaseResponder {
    private $apiName = 'setUserDetailProfile';

    public function __construct($expandException = null) {
        parent::__construct($this->apiName, $expandException);
    }
}
