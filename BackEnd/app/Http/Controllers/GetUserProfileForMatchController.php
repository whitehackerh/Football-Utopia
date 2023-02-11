<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\GetUserProfileForMatchValidator;
use App\Http\Services\GetUserProfileForMatchService;
use App\Http\Responders\GetUserProfileForMatchResponder;
use App\Exceptions\ExpandException;

class GetUserProfileForMatchController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new GetUserProfileForMatchValidator();
            $validator->validateApi($request);
            $service = new GetUserProfileForMatchService;
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new GetUserProfileForMatchResponder($e);
            $responder->setResponse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new GetUserProfileForMatchResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}