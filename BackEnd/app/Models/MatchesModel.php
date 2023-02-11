<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use App\Exceptions\ExpandException;
use Exception;
use App\Enums\MatchAction;

class MatchesModel extends BaseModel {
    private $table = 'matches';

    public function getTodaysMatchesCount($user_id) {
        try {
            $count = DB::table($this->table)
                ->where(DB::raw("to_char(created_at, 'yyyy/mm/dd')"), '=', DB::raw("to_char(current_date, 'yyyy/mm/dd')"))
                ->where('from_user_id', $user_id)
                ->count();
            return $count;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }

    public function setAction($from_user_id, $to_user_id, $action) {
        try {
            DB::table($this->table)
            ->insert([
                [
                    'from_user_id' => $from_user_id,
                    'to_user_id' => $to_user_id,
                    'action' => $action,
                    'created_at' => now()
                ]
            ]);
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }

    public function isMatch($from_user_id, $to_user_id) {
        try {
            return DB::table($this->table)
                ->where('from_user_id', $from_user_id)
                ->where('to_user_id', $to_user_id)
                ->where('action', MatchAction::YES)
                ->exists();
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }
}