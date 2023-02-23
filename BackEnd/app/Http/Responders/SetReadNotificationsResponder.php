<?php

namespace App\Http\Responders;

use App\Http\Responders\BaseResponder;

class SetReadNotificationsResponder extends BaseResponder {
    private $apiName = 'setReadNotifications';

    public function __construct($expandException = null) {
        parent::__construct($this->apiName, $expandException);
    }
}