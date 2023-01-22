<?php

nameSpace App\Http\Services;

use App\Http\Services\BaseService;
use Illuminate\Http\Request;
use Exception;
use App\Exceptions\ExpandException;
use App\Models\UsersDetailModel;

class SetUserDetailProfileService extends BaseService {
    public function service(Request $request) {
        try {
            $model = new UsersDetailModel();
            $model->updateUsersDetail($request->all());
            return null;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage, 400);
        }
    }
}