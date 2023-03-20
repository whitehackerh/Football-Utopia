<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\SetReadMessagesValidator;
use App\Http\Services\SetReadMessagesService;
use App\Http\Responders\SetReadMessagesResponder;
use App\Exceptions\ExpandException;

class SetReadMessagesController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new SetReadMessagesValidator();
            $validator->validateApi($request);
            $service = new SetReadMessagesService();
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new SetReadMessagesResponder($e);
            $responder->setResponse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new SetReadMessagesResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}