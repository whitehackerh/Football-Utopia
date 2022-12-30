<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\SetUserBasicProfileValidator;
use App\Http\Services\SetUserBasicProfileService;
use App\Http\Responders\SetUserBasicProfileResponder;
use App\Exceptions\ExpandException;

class SetUserBasicProfileController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new SetUserBasicProfileValidator();
            $validator->validateApi($request);
            $service = new SetUserBasicProfileService();
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new SetUserBasicProfileResponder($e);
            $responder->setResponse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new SetUserBasicProfileResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}