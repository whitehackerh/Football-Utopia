<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\SendMessageValidator;
use App\Http\Services\SendMessageService;
use App\Http\Responders\SendMessageResponder;
use App\Exceptions\ExpandException;

class SendMessageController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new SendMessageValidator();
            $validator->validateApi($request);
            $service = new SendMessageService;
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new SendMessageResponder($e);
            $responder->setResponse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new SendMessageResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}