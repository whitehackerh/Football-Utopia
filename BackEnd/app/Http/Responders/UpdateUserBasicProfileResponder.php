<?php

namespace App\Http\Responders;

use App\Http\Responders\BaseResponder;

class UpdateUserBasicProfileResponder extends BaseResponder {
    private $apiName = 'updateUserBasicProfile';

    public function __construct($expandException = null) {
        parent::__construct($this->apiName, $expandException);
    }
}