<?php

namespace App\Http\Responders;

use App\Http\Responders\BaseResponder;

class SetProfileIconResponder extends BaseResponder {
    private $apiName = 'setProfileIcon';

    public function __construct($expandException = null) {
        parent::__construct($this->apiName, $expandException);
    }
}
