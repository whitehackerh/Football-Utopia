<?php

namespace App\Http\Services;

use App\Http\Services\BaseService;
use App\Models\UsersModel;
use Illuminate\Http\Request;
use Exception;
use App\Exceptions\ExpandException;

class UpdateUserBasicInfoService extends BaseService {
    public function service(Request $request) {
        try {
            $model = new UsersModel();
            $model->updateUsersBasicInfo($request);
            return null;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), 400);
        }
    }
}
