<?php

namespace App\Http\Responders;

use App\Http\Responders\BaseResponder;

class GetNotificationsResponder extends BaseResponder {
    private $apiName = 'getNotifications';

    public function __construct($expandException = null) {
        parent::__construct($this->apiName, $expandException);
    }
}
