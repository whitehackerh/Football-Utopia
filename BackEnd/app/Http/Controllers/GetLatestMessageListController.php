<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\GetLatestMessageListValidator;
use App\Http\Services\GetLatestMessageListService;
use App\Http\Responders\GetLatestMessageListResponder;
use App\Exceptions\ExpandException;

class GetLatestMessageListController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new GetLatestMessageListValidator();
            $validator->validateApi($request);
            $service = new GetLatestMessageListService;
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new GetLatestMessageListResponder($e);
            $responder->setResponse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new GetLatestMessageListResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}