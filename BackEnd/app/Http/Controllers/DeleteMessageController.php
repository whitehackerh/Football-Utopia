<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\DeleteMessageValidator;
use App\Http\Services\DeleteMessageService;
use App\Http\Responders\DeleteMessageResponder;
use App\Exceptions\ExpandException;

class DeleteMessageController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new DeleteMessageValidator();
            $validator->validateApi($request);
            $service = new DeleteMessageService();
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new DeleteMessageResponder($e);
            $responder->setRepsonse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new DeleteMessageResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}