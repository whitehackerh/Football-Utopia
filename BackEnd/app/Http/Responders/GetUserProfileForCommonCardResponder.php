<?php

namespace App\Http\Responders;

use App\Http\Responders\BaseResponder;

class GetUserProfileForCommonCardResponder extends BaseResponder {
    private $apiName = 'getUserProfileForCommonCard';

    public function __construct($expandException = null) {
        parent::__construct($this->apiName, $expandException);
    }
}
