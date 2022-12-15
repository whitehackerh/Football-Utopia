<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\UpdateUserBasicInfoValidator;
use App\Http\Services\UpdateUserBasicInfoService;
use App\Http\Responders\UpdateUserBasicInfoResponder;
use App\Exceptions\ExpandException;

class UpdateUserBasicInfoController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new UpdateUserBasicInfoValidator();
            $validator->validateApi($request);
            $service = new UpdateUserBasicInfoService();
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new UpdateUserBasicInfoResponder($e);
            $responder->setResponse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new UpdateUserBasicInfoResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}