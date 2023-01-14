<?php

namespace App\Http\Services;

use App\Http\Services\BaseService;
use App\Http\Services\Utils\ServiceUtil;
use App\Models\UsersModel;
use Illuminate\Http\Request;
use Exception;
use App\Exceptions\ExpandException;
use Illuminate\Support\Facades\Storage;

class SetProfilePictureService extends BaseService {
    public function service(Request $request) {
        try {
            $user_id = $request->input('user_id');
            $profilePictureNumber = $request->input('profilePictureNumber');
            $profilePictureDirectory = 'user/' . $user_id . '/profilePictures';
            $profilePictureCroppedName = 'profilePictureCropped' . $profilePictureNumber . '.png';
            $profilePictureOriginalName = 'profilePictureOriginal' . $profilePictureNumber . '.png';
            ServiceUtil::existsDirectory($profilePictureDirectory);
            Storage::putFileAs($profilePictureDirectory, $request->file('croppedPicture'), $profilePictureCroppedName);
            Storage::putFileAs($profilePictureDirectory, $request->file('originalPicture'), $profilePictureOriginalName);
            
            $profilePictureCroppedColumn = 'profile_picture_cropped_' . $profilePictureNumber;
            $profilePictureOriginalColumn = 'profile_picture_original_' . $profilePictureNumber;
            $model = new UsersModel();
            $model->updateProfilePicture($user_id, $profilePictureCroppedColumn, $profilePictureOriginalColumn, $profilePictureDirectory . '/' . $profilePictureCroppedName, $profilePictureDirectory . '/' . $profilePictureOriginalName);
            return null;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), 400);
        }
    }
}