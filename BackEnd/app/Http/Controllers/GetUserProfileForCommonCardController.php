<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\GetUserProfileForCommonCardValidator;
use App\Http\Services\GetUserProfileForCommonCardService;
use App\Http\Responders\GetUserProfileForCommonCardResponder;
use App\Exceptions\ExpandException;

class GetUserProfileForCommonCardController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new GetUserProfileForCommonCardValidator();
            $validator->validateApi($request);
            $service = new GetUserProfileForCommonCardService;
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new GetUserProfileForCommonCardResponder($e);
            $responder->setResponse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new GetUserProfileForCommonCardResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}