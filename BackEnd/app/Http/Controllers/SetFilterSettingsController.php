<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\SetFilterSettingsValidator;
use App\Http\Services\SetFilterSettingsService;
use App\Http\Responders\SetFilterSettingsResponder;
use App\Exceptions\ExpandException;

class SetFilterSettingsController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new SetFilterSettingsValidator();
            $validator->validateApi($request);
            $service = new SetFilterSettingsService;
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new SetFilterSettingsResponder($e);
            $responder->setResponse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new SetFilterSettingsResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}