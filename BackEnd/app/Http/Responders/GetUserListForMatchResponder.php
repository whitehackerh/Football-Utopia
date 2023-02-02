<?php

namespace App\Http\Responders;

use App\Http\Responders\BaseResponder;

class GetUserListForMatchResponder extends BaseResponder {
    private $apiName = 'getUserListForMatch';

    public function __construct($expandException = null) {
        parent::__construct($this->apiName, $expandException);
    }
}
