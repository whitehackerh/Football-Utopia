<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\SendLikeValidator;
use App\Http\Services\SendLikeService;
use App\Http\Responders\SendLikeResponder;
use App\Exceptions\ExpandException;

class SendLikeController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new SendLikeValidator();
            $validator->validateApi($request);
            $service = new SendLikeService;
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new SendLikeResponder($e);
            $responder->setResponse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new SendLikeResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}