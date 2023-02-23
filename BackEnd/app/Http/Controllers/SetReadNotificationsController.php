<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\SetReadNotificationsValidator;
use App\Http\Services\SetReadNotificationsService;
use App\Http\Responders\SetReadNotificationsResponder;
use App\Exceptions\ExpandException;

class SetReadNotificationsController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new SetReadNotificationsValidator();
            $validator->validateApi($request);
            $service = new SetReadNotificationsService();
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new SetReadNotificationsResponder($e);
            $responder->setResponse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new SetReadNotificationsResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}