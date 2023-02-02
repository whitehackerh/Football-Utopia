<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\SetMatchActionValidator;
use App\Http\Services\SetMatchActionService;
use App\Http\Responders\SetMatchActionResponder;
use App\Exceptions\ExpandException;

class SetMatchActionController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new SetMatchActionValidator();
            $validator->validateApi($request);
            $service = new SetMatchActionService;
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new SetMatchActionResponder($e);
            $responder->setResponse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new SetMatchActionResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}