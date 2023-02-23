<?php

namespace App\Http\Responders;

use App\Http\Responders\BaseResponder;

class GetUnreadNotificationsResponder extends BaseResponder {
    private $apiName = 'getUnreadNotifications';

    public function __construct($expandException = null) {
        parent::__construct($this->apiName, $expandException);
    }
}
