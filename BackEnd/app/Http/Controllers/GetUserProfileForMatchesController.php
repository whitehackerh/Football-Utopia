<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\GetUserProfileForMatchesValidator;
use App\Http\Services\GetUserProfileForMatchesService;
use App\Http\Responders\GetUserProfileForMatchesResponder;
use App\Exceptions\ExpandException;

class GetUserProfileForMatchesController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new GetUserProfileForMatchesValidator();
            $validator->validateApi($request);
            $service = new GetUserProfileForMatchesService;
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new GetUserProfileForMatchesResponder($e);
            $responder->setResponse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new GetUserProfileForMatchesResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}