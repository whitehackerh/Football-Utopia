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
            $profilePictureNumber = $request->input('profilePictureNumber');
            $profilePictureDirectory = 'profilePictures/' . $user_id;
            $profilePictureCroppedName = 'profilePictureCropped' . $profilePictureNumber . '.png';
            $profilePictureOriginalName = 'profilePictureOriginal' . $profilePictureNumber . '.png';
            Storage::delete($profilePictureDirectory . '/' . $profilePictureCroppedName);
            Storage::delete($profilePictureDirectory . '/' . $profilePictureOriginalName);
            
            $profilePictureCroppedColumn = 'profile_picture_cropped_' . $profilePictureNumber;
            $profilePictureOriginalColumn = 'profile_picture_original_' . $profilePictureNumber;
            $model = new UsersModel();
            $model->updateProfilePicture($user_id, $profilePictureCroppedColumn, $profilePictureOriginalColumn, null, null);
            return null;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), 400);
        }
    }
}