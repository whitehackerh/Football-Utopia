<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\GetMessagesValidator;
use App\Http\Services\GetMessagesService;
use App\Http\Responders\GetMessagesResponder;
use App\Exceptions\ExpandException;

class GetMessagesController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new GetMessagesValidator();
            $validator->validateApi($request);
            $service = new GetMessagesService;
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new GetMessagesResponder($e);
            $responder->setResponse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new GetMessagesResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}