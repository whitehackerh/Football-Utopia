<?php

namespace App\Http\Responders;

use App\Http\Responders\BaseResponder;

class DeleteMessageResponder extends BaseResponder {
    private $apiName = 'deleteMessage';

    public function __construct($expandException = null) {
        parent::__construct($this->apiName, $expandException);
    }
}
