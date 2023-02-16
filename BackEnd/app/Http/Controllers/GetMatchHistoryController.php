<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\GetMatchHistoryValidator;
use App\Http\Services\GetMatchHistoryService;
use App\Http\Responders\GetMatchHistoryResponder;
use App\Exceptions\ExpandException;

class GetMatchHistoryController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new GetMatchHistoryValidator();
            $validator->validateApi($request);
            $service = new GetMatchHistoryService;
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new GetMatchHistoryResponder($e);
            $responder->setResponse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new GetMatchHistoryResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}