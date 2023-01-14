<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\GetProfilePictureOriginalValidator;
use App\Http\Services\GetProfilePictureOriginalService;
use App\Http\Responders\GetProfilePictureOriginalResponder;
use App\Exceptions\ExpandException;

class GetProfilePictureOriginalController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new GetProfilePictureOriginalValidator();
            $validator->validateApi($request);
            $service = new GetProfilePictureOriginalService;
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new GetProfilePictureOriginalResponder($e);
            $responder->setResponse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new GetProfilePictureOriginalResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}