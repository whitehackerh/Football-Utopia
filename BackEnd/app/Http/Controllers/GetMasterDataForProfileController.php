<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Validators\GetMasterDataForProfileValidator;
use App\Http\Services\GetMasterDataForProfileService;
use App\Http\Responders\GetMasterDataForProfileResponder;
use App\Exceptions\ExpandException;

class GetMasterDataForProfileController extends Controller {
    public function __invoke(Request $request) {
        try {
            $validator = new GetMasterDataForProfileValidator();
            $validator->validateApi($request);
            $service = new GetMasterDataForProfileService;
            $data = $service->service($request);
        } catch (ExpandException $e) {
            $responder = new GetMasterDataForProfileResponder($e);
            $responder->setResponse($e->getErrors());
            return $responder->getResponse();
        }
        $responder = new GetMasterDataForProfileResponder();
        $responder->setResponse($data);
        return $responder->getResponse();
    }
}