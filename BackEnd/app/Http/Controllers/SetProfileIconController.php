<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\SetProfileIconValidator;
use App\Http\Services\SetProfileIconService;
use App\Http\Responders\SetProfileIconResponder;
use App\Exceptions\ExpandException;

class SetProfileIconController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new SetProfileIconValidator();
            $validator->validateApi($request);
            $service = new SetProfileIconService();
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new SetProfileIconResponder($e);
            $responder->setRepsonse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new SetProfileIconResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}

