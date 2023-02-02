<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\GetUserListForMatchValidator;
use App\Http\Services\GetUserListForMatchService;
use App\Http\Responders\GetUserListForMatchResponder;
use App\Exceptions\ExpandException;

class GetUserListForMatchController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new GetUserListForMatchValidator();
            $validator->validateApi($request);
            $service = new GetUserListForMatchService;
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new GetUserListForMatchResponder($e);
            $responder->setResponse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new GetUserListForMatchResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}