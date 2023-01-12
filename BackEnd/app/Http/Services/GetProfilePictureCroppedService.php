<?php

namespace App\Http\Services;

use App\Http\Services\BaseService;
use App\Models\UsersModel;
use Illuminate\Http\Request;
use Exception;
use App\Exceptions\ExpandException;

class GetProfilePictureCroppedService extends BaseService {
    public function service(Request $request) {
        try {
            $data = [];
            $model = new UsersModel();
            $record = $model->getProfilePictureCropped($request->input('user_id'));
            if (!$record->count()) {
                $data['profilePictureCropped1'] = null;
                $data['profilePictureCropped2'] = null;
                $data['profilePictureCropped3'] = null;
            } else {
                $data['profilePictureCropped1'] = $record[0]->profile_picture_cropped_1;
                $data['profilePictureCropped2'] = $record[0]->profile_picture_cropped_2;
                $data['profilePictureCropped3'] = $record[0]->profile_picture_cropped_3;
            }
            return $data;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage, 400);
        }
    }
}