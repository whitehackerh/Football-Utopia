<?php

namespace App\Http\Services;

use App\Http\Services\BaseService;
use App\Models\UsersModel;
use Illuminate\Http\Request;
use Exception;
use App\Exceptions\ExpandException;

class GetProfileIconService extends BaseService {
    public function service(Request $request) {
        try {
            $data = [];
            $model = new UsersModel();
            $record = $model->getProfileIcon($request->input('user_id'));
            if ($record->isEmpty()) {
                $data['profileIconPass'] = null;
            } else {
                $data['profileIconPass'] = $record[0]->profile_icon_pass;
            }
            return $data;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage, 400);
        }
    }
}