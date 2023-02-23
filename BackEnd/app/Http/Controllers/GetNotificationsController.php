<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\GetNotificationsValidator;
use App\Http\Services\GetNotificationsService;
use App\Http\Responders\GetNotificationsResponder;
use App\Exceptions\ExpandException;

class GetNotificationsController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new GetNotificationsValidator();
            $validator->validateApi($request);
            $service = new GetNotificationsService;
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new GetNotificationsResponder($e);
            $responder->setResponse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new GetNotificationsResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}