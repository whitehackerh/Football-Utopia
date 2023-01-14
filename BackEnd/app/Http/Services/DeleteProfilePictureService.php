<?php

namespace App\Http\Services;

use App\Http\Services\BaseService;
use App\Models\UsersModel;
use Illuminate\Http\Request;
use Exception;
use App\Exceptions\ExpandException;
use Illuminate\Support\Facades\Storage;

class DeleteProfilePictureService extends BaseService {
    public function service(Request $request) {
        try {
            $user_id = $request->input('user_id');
            $profilePictureNo = $request->input('profilePictureNo');
            $profilePictureDirectory = 'user/' . $user_id . '/profilePictures';
            $profilePictureCroppedName = 'profilePictureCropped' . $profilePictureNo . '.png';
            $profilePictureOriginalName = 'profilePictureOriginal' . $profilePictureNo . '.png';
            Storage::delete($profilePictureDirectory . '/' . $profilePictureCroppedName);
            Storage::delete($profilePictureDirectory . '/' . $profilePictureOriginalName);
            
            $profilePictureCroppedColumn = 'profile_picture_cropped_' . $profilePictureNo;
            $profilePictureOriginalColumn = 'profile_picture_original_' . $profilePictureNo;
            $model = new UsersModel();
            $model->updateProfilePicture($user_id, $profilePictureCroppedColumn, $profilePictureOriginalColumn, null, null);
            return null;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), 400);
        }
    }
}