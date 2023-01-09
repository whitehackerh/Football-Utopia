<?php

namespace App\Http\Responders;

use App\Http\Responders\BaseResponder;

class GetProfileIconResponder extends BaseResponder {
    private $apiName = 'getProfileIcon';

    public function __construct($expandException = null) {
        parent::__construct($this->apiName, $expandException);
    }
}
