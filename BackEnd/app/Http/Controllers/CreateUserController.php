<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CreateUserController extends Controller {
    public function __invoke(Request $request) {
        // return 1;
        //try {
            $validator = new CreateUserValidator();
            $validator->validate($request);
            $service = new CreateUserService();
            $data = $service->service($request);
        //}
        // catch {

        // }
        $responder = new CreateUserResponder();
        $responder->setData($data);
        return $responder->getResponse();
    }
}