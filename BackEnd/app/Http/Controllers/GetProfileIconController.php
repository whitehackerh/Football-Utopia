<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\GetProfileIconValidator;
use App\Http\Services\GetProfileIconService;
use App\Http\Responders\GetProfileIconResponder;
use App\Exceptions\ExpandException;

class GetProfileIconController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new GetProfileIconValidator();
            $validator->validateApi($request);
            $service = new GetProfileIconService;
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new GetProfileIconResponder($e);
            $responder->setResponse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new GetProfileIconResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}