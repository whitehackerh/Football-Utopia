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

    public function getProfileIcon($user_id) {
        try {
            $profileIcon = DB::table($this->table)
                ->where('id', $user_id)
                ->select('profile_icon_pass')
                ->get();
            return $profileIcon;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }

    public function updateProfileIcon($user_id, $profileIconPass) {
        try {
            DB::table($this->table)
                ->where('id', $user_id)
                ->update([
                    'profile_icon_pass' => $profileIconPass
                ]);
            return;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }
}