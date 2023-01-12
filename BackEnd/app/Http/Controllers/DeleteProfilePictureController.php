<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\DeleteProfilePictureValidator;
use App\Http\Services\DeleteProfilePictureService;
use App\Http\Responders\DeleteProfilePictureResponder;
use App\Exceptions\ExpandException;

class DeleteProfilePictureController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new DeleteProfilePictureValidator();
            $validator->validateApi($request);
            $service = new DeleteProfilePictureService();
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new DeleteProfilePictureResponder($e);
            $responder->setRepsonse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new DeleteProfilePictureResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}