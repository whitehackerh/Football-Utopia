<?php

namespace App\Http\Responders;

use App\Http\Responders\BaseResponder;

class GetProfilePictureCroppedResponder extends BaseResponder {
    private $apiName = 'getProfilePictureCropped';

    public function __construct($expandException = null) {
        parent::__construct($this->apiName, $expandException);
    }
}
