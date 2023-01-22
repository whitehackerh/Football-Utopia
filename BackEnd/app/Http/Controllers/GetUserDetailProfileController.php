<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\GetUserDetailProfileValidator;
use App\Http\Services\GetUserDetailProfileService;
use App\Http\Responders\GetUserDetailProfileResponder;
use App\Exceptions\ExpandException;

class GetUserDetailProfileController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new GetUserDetailProfileValidator();
            $validator->validateApi($request);
            $service = new GetUserDetailProfileService;
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new GetUserDetailProfileResponder($e);
            $responder->setResponse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new GetUserDetailProfileResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}