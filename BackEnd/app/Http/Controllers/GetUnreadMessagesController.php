<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\GetUnreadMessagesValidator;
use App\Http\Services\GetUnreadMessagesService;
use App\Http\Responders\GetUnreadMessagesResponder;
use App\Exceptions\ExpandException;

class GetUnreadMessagesController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new GetUnreadMessagesValidator();
            $validator->validateApi($request);
            $service = new GetUnreadMessagesService;
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new GetUnreadMessagesResponder($e);
            $responder->setResponse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new GetUnreadMessagesResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}