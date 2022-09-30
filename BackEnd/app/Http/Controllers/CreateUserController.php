<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CreateUserController extends Controller {
    public function __invoke(Request $request) {
        return 1;
    }
}