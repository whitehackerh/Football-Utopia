<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\UpdateUserBasicProfileValidator;
use App\Http\Services\UpdateUserBasicProfileService;
use App\Http\Responders\UpdateUserBasicProfileResponder;
use App\Exceptions\ExpandException;

class UpdateUserBasicProfileController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new UpdateUserBasicProfileValidator();
            $validator->validateApi($request);
            $service = new UpdateUserBasicProfileService();
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new UpdateUserBasicProfileResponder($e);
            $responder->setResponse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new UpdateUserBasicProfileResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}