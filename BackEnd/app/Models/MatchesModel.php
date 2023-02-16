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

    public function getMatchHistory($user_id, $fromNum, $toNum) {
        try {
            $name = DB::table('users')
                ->select('name')
                ->where('id', $user_id)
                ->get();
            $name = $name[0]->name;
            
            $records = DB::table('matches')
                ->select('matches.*', 'users.name', 'users.profile_picture_cropped_1', 'users.profile_picture_cropped_2', 'users.profile_picture_cropped_3', 'ranked_dates.date_num')
                ->join(DB::raw("(SELECT date_trunc('day', created_at) as created_date, ROW_NUMBER() OVER (ORDER BY date_trunc('day', created_at) DESC) AS date_num FROM matches WHERE from_user_id = $user_id GROUP BY date_trunc('day', created_at)) as ranked_dates"), function($join) {
                    $join->on(DB::raw("date_trunc('day', matches.created_at)"), '=', 'ranked_dates.created_date');
                })
                ->join('users', function($join) use ($user_id, $name) {
                    $join->on(function($join) use ($user_id) {
                        $join->on('matches.from_user_id', '=', 'users.id')
                            ->orOn('matches.to_user_id', '=', 'users.id');
                    })
                    ->where('matches.from_user_id', '=', $user_id)
                    ->where('users.name', '!=', $name);
                })
                ->whereBetween('ranked_dates.date_num', [$fromNum, $toNum])
                ->orderBy('created_at', 'desc')
                ->get();
            return $records;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }
}