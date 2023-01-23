<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\GetUserBasicProfileWithNameValidator;
use App\Http\Services\GetUserBasicProfileWithNameService;
use App\Http\Responders\GetUserBasicProfileWithNameResponder;
use App\Exceptions\ExpandException;

class GetUserBasicProfileWithNameController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new GetUserBasicProfileWithNameValidator();
            $validator->validateApi($request);
            $service = new GetUserBasicProfileWithNameService;
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new GetUserBasicProfileWithNameResponder($e);
            $responder->setResponse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new GetUserBasicProfileWithNameResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}