<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\SetUserDetailProfileValidator;
use App\Http\Services\SetUserDetailProfileService;
use App\Http\Responders\SetUserDetailProfileResponder;
use App\Exceptions\ExpandException;

class SetUserDetailProfileController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new SetUserDetailProfileValidator();
            $validator->validateApi($request);
            $service = new SetUserDetailProfileService;
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new SetUserDetailProfileResponder($e);
            $responder->setResponse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new SetUserDetailProfileResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}