<?php

namespace App\Http\Services;

use App\Http\Services\BaseService;
use App\Models\UsersModel;
use Illuminate\Http\Request;
use Exception;
use App\Exceptions\ExpandException;

class GetProfilePictureOriginalService extends BaseService {
    public function service(Request $request) {
        try {
            $data = [];
            $model = new UsersModel();
            $profilePictureNumber = $request->input('profilePictureNumber');
            $profilePictureOriginalColumn = 'profile_picture_original_' . $profilePictureNumber;
            $record = $model->getProfilePictureOriginal($request->input('user_id'), $profilePictureOriginalColumn);
            if ($record->count()) {
                $data['profilePictureOriginal'] = $record[0]->$profilePictureOriginalColumn;
            } else {
                $data['profilePictureOriginal'] = null;
            }
            return $data;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), 400);
        }
    }
}