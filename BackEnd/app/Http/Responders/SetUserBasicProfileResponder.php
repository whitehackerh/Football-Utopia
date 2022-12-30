<?php

namespace App\Http\Responders;

use App\Http\Responders\BaseResponder;

class SetUserBasicProfileResponder extends BaseResponder {
    private $apiName = 'setUserBasicProfile';

    public function __construct($expandException = null) {
        parent::__construct($this->apiName, $expandException);
    }
}