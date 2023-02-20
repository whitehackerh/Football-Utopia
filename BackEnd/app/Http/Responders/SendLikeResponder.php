<?php

namespace App\Http\Responders;

use App\Http\Responders\BaseResponder;

class SendLikeResponder extends BaseResponder {
    private $apiName = 'sendLike';

    public function __construct($expandException = null) {
        parent::__construct($this->apiName, $expandException);
    }
}
