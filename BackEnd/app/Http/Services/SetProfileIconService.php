<?php

namespace App\Http\Services;

use App\Http\Services\BaseService;
use App\Http\Services\Utils\ServiceUtil;
use App\Models\UsersModel;
use Illuminate\Http\Request;
use Exception;
use App\Exceptions\ExpandException;
use Illuminate\Support\Facades\Storage;

class SetProfileIconService extends BaseService {
    public function service(Request $request) {
        try {
            $user_id = $request->input('user_id');
            $profileIconDirectory = 'user/' . $user_id . '/profileIcon';
            $fileName = 'profileIcon.png';
            ServiceUtil::existsDirectory($profileIconDirectory);
            Storage::putFileAs($profileIconDirectory, $request->file('image'), $fileName);
            $model = new UsersModel();
            $model->updateProfileIcon($user_id, $profileIconDirectory . '/' . $fileName);
            return null;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), 400);
        }
    }
}