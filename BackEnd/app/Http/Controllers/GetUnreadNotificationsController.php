<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\GetUnreadNotificationsValidator;
use App\Http\Services\GetUnreadNotificationsService;
use App\Http\Responders\GetUnreadNotificationsResponder;
use App\Exceptions\ExpandException;

class GetUnreadNotificationsController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new GetUnreadNotificationsValidator();
            $validator->validateApi($request);
            $service = new GetUnreadNotificationsService;
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new GetUnreadNotificationsResponder($e);
            $responder->setResponse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new GetUnreadNotificationsResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}