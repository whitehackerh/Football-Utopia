<?php

namespace App\Http\Responders;

use App\Http\Responders\BaseResponder;

class SetFilterSettingsResponder extends BaseResponder {
    private $apiName = 'setFilterSettings';

    public function __construct($expandException = null) {
        parent::__construct($this->apiName, $expandException);
    }
}
