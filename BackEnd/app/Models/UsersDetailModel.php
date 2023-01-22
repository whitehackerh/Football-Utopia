<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use App\Exceptions\ExpandException;
use Exception;

class UsersDetailModel extends BaseModel {
    private $table = 'users_detail';

    public function getRecords($user_id) {
        try {
            $record = DB::table("$this->table as u")
                ->select(
                    'u.looking_for_id', 'lf.name as looking_for_name',
                    'u.league1_id', 'le1.name as league1_name',
                    'u.league2_id', 'le2.name as league2_name',
                    'u.league3_id', 'le3.name as league3_name',
                    'u.clubteam1_id', 'cl1.name as clubteam1_name',
                    'u.clubteam2_id', 'cl2.name as clubteam2_name',
                    'u.clubteam3_id', 'cl3.name as clubteam3_name',
                    'u.player1_id', 'pl1.name as player1_name',
                    'u.player2_id', 'pl2.name as player2_name',
                    'u.player3_id', 'pl3.name as player3_name',
                    'u.coach1_id', 'co1.name as coach1_name',
                    'u.coach2_id', 'co2.name as coach2_name',
                    'u.coach3_id', 'co3.name as coach3_name',
                    'u.position1_id', 'po1.name as position1_name',
                    'u.position2_id', 'po2.name as position2_name',
                    'u.position3_id', 'po3.name as position3_name',
                    'u.favorite_part_id', 'fp.name as favorite_part_name',
                    'u.football_game_id', 'fg.name as football_game_name',
                    'u.playing_experience', 'u.about_me'
                )
                ->where('user_id', $user_id)
                ->leftJoin('looking_for as lf', function($join) {
                    $join->on('lf.id', '=', 'u.looking_for_id');
                })
                ->leftJoin('leagues as le1', function($join) {
                    $join->on('le1.id', '=', 'u.league1_id');
                })
                ->leftJoin('leagues as le2', function($join) {
                    $join->on('le2.id', '=', 'u.league2_id');
                })
                ->leftJoin('leagues as le3', function($join) {
                    $join->on('le3.id', '=', 'u.league3_id');
                })
                ->leftJoin('clubteams as cl1', function($join) {
                    $join->on('cl1.id', '=', 'u.clubteam1_id');
                })
                ->leftJoin('clubteams as cl2', function($join) {
                    $join->on('cl2.id', '=', 'u.clubteam2_id');
                })
                ->leftJoin('clubteams as cl3', function($join) {
                    $join->on('cl3.id', '=', 'u.clubteam3_id');
                })
                ->leftJoin('players as pl1', function($join) {
                    $join->on('pl1.id', '=', 'u.player1_id');
                })
                ->leftJoin('players as pl2', function($join) {
                    $join->on('pl2.id', '=', 'u.player2_id');
                })
                ->leftJoin('players as pl3', function($join) {
                    $join->on('pl3.id', '=', 'u.player3_id');
                })
                ->leftJoin('coaches as co1', function($join) {
                    $join->on('co1.id', '=', 'u.coach1_id');
                })
                ->leftJoin('coaches as co2', function($join) {
                    $join->on('co2.id', '=', 'u.coach2_id');
                })
                ->leftJoin('coaches as co3', function($join) {
                    $join->on('co3.id', '=', 'u.coach3_id');
                })
                ->leftJoin('positions as po1', function($join) {
                    $join->on('po1.id', '=', 'u.position1_id');
                })
                ->leftJoin('positions as po2', function($join) {
                    $join->on('po2.id', '=', 'u.position2_id');
                })
                ->leftJoin('positions as po3', function($join) {
                    $join->on('po3.id', '=', 'u.position3_id');
                })
                ->leftJoin('favorite_parts as fp', function($join) {
                    $join->on('fp.id', '=', 'u.favorite_part_id');
                })
                ->leftJoin('football_games as fg', function($join) {
                    $join->on('fg.id', '=', 'u.football_game_id');
                })
                ->get();
            return $record;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }

    public function updateUsersDetail($request) {
        try {
            DB::table($this->table)
                ->updateOrInsert(
                    ['user_id' => $request['user_id']],
                    [
                        'looking_for_id' => $request['looking_for'],
                        'league1_id' => $request['favorite_leagues']['favorite_league'],
                        'league2_id' => $request['favorite_leagues']['second_favorite_league'],
                        'league3_id' => $request['favorite_leagues']['third_favorite_league'],
                        'clubteam1_id' => $request['favorite_clubteams']['favorite_clubteam'],
                        'clubteam2_id' => $request['favorite_clubteams']['second_favorite_clubteam'],
                        'clubteam3_id' => $request['favorite_clubteams']['third_favorite_clubteam'],
                        'player1_id' => $request['favorite_players']['favorite_player'],
                        'player2_id' => $request['favorite_players']['second_favorite_player'],
                        'player3_id' => $request['favorite_players']['third_favorite_player'],
                        'coach1_id' => $request['favorite_coaches']['favorite_coach'],
                        'coach2_id' => $request['favorite_coaches']['second_favorite_coach'],
                        'coach3_id' => $request['favorite_coaches']['third_favorite_coach'],
                        'position1_id' => $request['favorite_positions']['favorite_position'],
                        'position2_id' => $request['favorite_positions']['second_favorite_position'],
                        'position3_id' => $request['favorite_positions']['third_favorite_position'],
                        'favorite_part_id' => $request['favorite_part'],
                        'football_game_id' => $request['favorite_football_game'],
                        'playing_experience' => $request['playing_experience'],
                        'about_me' => $request['about_me']
                    ]
                );
            return;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }
}