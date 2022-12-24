<?php

namespace App\Http\Services;

use App\Http\Services\BaseService;
use App\Models\UsersModel;
use Illuminate\Http\Request;
use Exception;
use App\Exceptions\ExpandException;

class UpdateUserBasicProfileService extends BaseService {
    public function service(Request $request) {
        try {
            $model = new UsersModel();
            $model->updateUsersBasicProfile($request);
            return null;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), 400);
        }
    }
}
