<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\SetProfilePictureValidator;
use App\Http\Services\SetProfilePictureService;
use App\Http\Responders\SetProfilePictureResponder;
use App\Exceptions\ExpandException;

class SetProfilePictureController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new SetProfilePictureValidator();
            $validator->validateApi($request);
            $service = new SetProfilePictureService();
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new SetProfilePictureResponder($e);
            $responder->setRepsonse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new SetProfilePictureResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}

