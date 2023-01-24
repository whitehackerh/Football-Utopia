<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\GetFilterSettingsValidator;
use App\Http\Services\GetFilterSettingsService;
use App\Http\Responders\GetFilterSettingsResponder;
use App\Exceptions\ExpandException;

class GetFilterSettingsController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new GetFilterSettingsValidator();
            $validator->validateApi($request);
            $service = new GetFilterSettingsService;
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new GetFilterSettingsResponder($e);
            $responder->setResponse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new GetFilterSettingsResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}