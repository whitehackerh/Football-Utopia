<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\GetProfilePictureCroppedValidator;
use App\Http\Services\GetProfilePictureCroppedService;
use App\Http\Responders\GetProfilePictureCroppedResponder;
use App\Exceptions\ExpandException;

class GetProfilePictureCroppedController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new GetProfilePictureCroppedValidator();
            $validator->validateApi($request);
            $service = new GetProfilePictureCroppedService;
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new GetProfilePictureCroppedResponder($e);
            $responder->setResponse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new GetProfilePictureCroppedResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}