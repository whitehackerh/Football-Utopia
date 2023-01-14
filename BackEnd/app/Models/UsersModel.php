<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use App\Exceptions\ExpandException;
use Exception;

class UsersModel extends BaseModel {
    private $table = 'users';
    public function updateUsersBasicProfile($request) {
        try {
            DB::table($this->table)
                    ->where('id', $request->input('user_id'))
                    ->update([
                        'user_name' => $request->input('user_name'),
                        'name' => $request->input('name'),
                        'email' => $request->input('email'),
                        'age' => $request->input('age'),
                        'gender' => $request->input('gender'),
                        'nationality' => $request->input('nationality')
                    ]);
            return;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }

    public function getProfilePictureCropped($user_id) {
        try {
            $profilePictures = DB::table($this->table)
                ->where('id', $user_id)
                ->select('profile_picture_cropped_1', 'profile_picture_cropped_2', 'profile_picture_cropped_3')
                ->get();
            return $profilePictures;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }

    public function updateProfilePicture($user_id, $profilePictureCroppedColumn, $profilePictureOriginalColumn, $profilePictureCroppedPass, $profilePictureOriginalPass) {
        try {
            DB::table($this->table)
                ->where('id', $user_id)
                ->update([
                    $profilePictureCroppedColumn => $profilePictureCroppedPass,
                    $profilePictureOriginalColumn => $profilePictureOriginalPass
                ]);
            return;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }

    public function getProfilePictureOriginal($user_id, $profilePictureOriginalColumn) {
        try {
            $profilePictureOriginal = DB::table($this->table)
                ->where('id', $user_id)
                ->select($profilePictureOriginalColumn)
                ->get();
            return $profilePictureOriginal;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }
}