<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\SetMatchesActionValidator;
use App\Http\Services\SetMatchesActionService;
use App\Http\Responders\SetMatchesActionResponder;
use App\Exceptions\ExpandException;

class SetMatchesActionController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new SetMatchesActionValidator();
            $validator->validateApi($request);
            $service = new SetMatchesActionService;
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new SetMatchesActionResponder($e);
            $responder->setResponse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new SetMatchesActionResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}