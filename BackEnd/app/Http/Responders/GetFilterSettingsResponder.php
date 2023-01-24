<?php

namespace App\Http\Responders;

use App\Http\Responders\BaseResponder;

class GetFilterSettingsResponder extends BaseResponder {
    private $apiName = 'getFilterSettings';

    public function __construct($expandException = null) {
        parent::__construct($this->apiName, $expandException);
    }
}
