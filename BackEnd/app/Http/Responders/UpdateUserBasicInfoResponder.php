<?php

namespace App\Http\Responders;

use App\Http\Responders\BaseResponder;

class UpdateUserBasicInfoResponder extends BaseResponder {
    private $apiName = 'updateUserBasicInfo';

    public function __construct($expandException = null) {
        parent::__construct($this->apiName, $expandException);
    }
}