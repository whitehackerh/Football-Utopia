<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\GetUserListForMatchesValidator;
use App\Http\Services\GetUserListForMatchesService;
use App\Http\Responders\GetUserListForMatchesResponder;
use App\Exceptions\ExpandException;

class GetUserListForMatchesController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new GetUserListForMatchesValidator();
            $validator->validateApi($request);
            $service = new GetUserListForMatchesService;
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new GetUserListForMatchesResponder($e);
            $responder->setResponse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new GetUserListForMatchesResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}