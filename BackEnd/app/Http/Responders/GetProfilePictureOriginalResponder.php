<?php

namespace App\Http\Responders;

use App\Http\Responders\BaseResponder;

class GetProfilePictureOriginalResponder extends BaseResponder {
    private $apiName = 'getProfilePictureOriginal';

    public function __construct($expandException = null) {
        parent::__construct($this->apiName, $expandException);
    }
}
