<?php

namespace App\Http\Responders;

use App\Http\Responders\BaseResponder;

class DeleteProfilePictureResponder extends BaseResponder {
    private $apiName = 'deleteProfilePicture';

    public function __construct($expandException = null) {
        parent::__construct($this->apiName, $expandException);
    }
}
