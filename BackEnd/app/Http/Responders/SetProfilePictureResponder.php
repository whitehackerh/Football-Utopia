<?php

namespace App\Http\Responders;

use App\Http\Responders\BaseResponder;

class SetProfilePictureResponder extends BaseResponder {
    private $apiName = 'setProfilePicture';

    public function __construct($expandException = null) {
        parent::__construct($this->apiName, $expandException);
    }
}
