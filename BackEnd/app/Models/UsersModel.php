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

    public function getRecordsWithName($user_id) {
        try {
            $record = DB::table("$this->table as u")
                ->select(
                    'u.gender', 'ge.name as gender_name',
                    'u.nationality', 'na.name as nationality_name'
                )
                ->where('u.id', $user_id)
                ->leftJoin('gender as ge', function($join) {
                    $join->on('ge.id', '=', 'u.gender');
                })
                ->leftJoin('nations as na', function($join) {
                    $join->on('na.id', '=', 'u.nationality');
                })
                ->get();
            return $record;
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

    public function getSelfProfileAndFilter($user_id) {
        try {
            $record = DB::table($this->table)
                ->select('users.id', 'users.age', 'users.gender', 'users.nationality',
                    'ud.looking_for_id as ud_looking_for_id', 'ud.league1_id as ud_league1_id',
                    'ud.league2_id as ud_league2_id', 'ud.league3_id as ud_league3_id',
                    'ud.clubteam1_id as ud_clubteam1_id', 'ud.clubteam2_id as ud_clubteam2_id',
                    'ud.clubteam3_id as ud_clubteam3_id',
                    'ud.player1_id as ud_player1_id', 'ud.player2_id as ud_player2_id', 
                    'ud.player3_id as ud_player3_id',
                    'ud.coach1_id as ud_coach1_id', 'ud.coach2_id as ud_coach2_id',
                    'ud.coach3_id as ud_coach3_id',
                    'ud.position1_id as ud_position1_id', 'ud.position2_id as ud_position2_id',
                    'ud.position3_id as ud_position3_id',
                    'ud.favorite_part_id as ud_favorite_part_id', 'ud.football_game_id as ud_football_game_id',
                    'ud.playing_experience as ud_playing_experience',
                    'fs.looking_for_id as fs_looking_for_id', 'fs.min_age', 'fs.max_age',
                    'fs.gender_id', 'fs.nation_id',
                    'fs.league1_id as fs_league1_id', 'fs.league2_id as fs_league2_id',
                    'fs.league3_id as fs_league3_id',
                    'fs.clubteam1_id as fs_clubteam1_id', 'fs.clubteam2_id as fs_clubteam2_id',
                    'fs.clubteam3_id as fs_clubteam3_id',
                    'fs.player1_id as fs_player1_id', 'fs.player2_id as fs_player2_id', 
                    'fs.player3_id as fs_player3_id',
                    'fs.coach1_id as fs_coach1_id', 'fs.coach2_id as fs_coach2_id',
                    'fs.coach3_id as fs_coach3_id',
                    'fs.position1_id as fs_position1_id', 'fs.position2_id as fs_position2_id',
                    'fs.position3_id as fs_position3_id',
                    'fs.favorite_part_id as fs_favorite_part_id', 'fs.football_game_id as fs_football_game_id',
                    'fs.playing_experience as fs_playing_experience')
                ->leftJoin('users_detail as ud', function($join) {
                    $join->on('ud.user_id', '=', 'users.id');
                })
                ->leftJoin('filter_settings as fs', function($join) {
                    $join->on('fs.user_id', '=', 'users.id');
                })
                ->where('users.id', $user_id)
                ->where(function($query) {
                    $query->orWhereNotNull('users.profile_picture_cropped_1')
                    ->orWhereNotNull('users.profile_picture_cropped_2')
                    ->orWhereNotNull('users.profile_picture_cropped_3');
                })
                ->get();
            return $record;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
        
    }       

    public function getNoDataOfProfilePictureList($user_id) {
        try {
            $records = DB::table($this->table)
                ->select('id')
                ->where('id', '<>', $user_id)
                ->whereNull('profile_picture_cropped_1')
                ->whereNull('profile_picture_cropped_2')
                ->whereNull('profile_picture_cropped_3')
                ->distinct()
                ->get();
            return $records;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }

    public function getYesOrNopeRecentlyList($user_id) {
        try {
            $records = DB::select(DB::raw("select distinct u.id from users as u
                inner join matches as ma on ma.to_user_id = u.id and ((ma.from_user_id = $user_id and ma.action = 0) or (ma.from_user_id = $user_id and ma.action = 1 and ma.created_at > now() - interval '1 months'))
                where u.id <> $user_id"));
            return $records;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }

    public function getUsersProfileList($excludeUserList) {
        try {
            $records = DB::table($this->table)
                ->select('users.id', 'users.age', 'users.gender', 'users.nationality',
                    'ud.looking_for_id as looking_for_id', 'ud.league1_id as league1_id',
                    'ud.league2_id as league2_id', 'ud.league3_id as league3_id',
                    'ud.clubteam1_id as clubteam1_id', 'ud.clubteam2_id as clubteam2_id',
                    'ud.clubteam3_id as clubteam3_id',
                    'ud.player1_id as player1_id', 'ud.player2_id as player2_id', 
                    'ud.player3_id as player3_id',
                    'ud.coach1_id as coach1_id', 'ud.coach2_id as coach2_id',
                    'ud.coach3_id as coach3_id',
                    'ud.position1_id as position1_id', 'ud.position2_id as position2_id',
                    'ud.position3_id as position3_id',
                    'ud.favorite_part_id as favorite_part_id', 'ud.football_game_id as football_game_id',
                    'ud.playing_experience as playing_experience')
                ->leftJoin('users_detail as ud', function($join) {
                    $join->on('ud.user_id', '=', 'users.id');
                })
                ->whereNotIn('users.id', $excludeUserList)
                ->get()
                ->toArray();
            return $records;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }

    public function getUserProfileForMatch($user_id) {
        try {
            $record = DB::table($this->table)
                ->select('users.id', 'users.user_name', 'users.name', 'users.age', 
                    'users.gender', 'ge.name as gender_name',
                    'users.nationality', 'na.name as nationality_name',
                    'users.profile_picture_cropped_1', 'users.profile_picture_original_1',
                    'users.profile_picture_cropped_2', 'users.profile_picture_original_2',
                    'users.profile_picture_cropped_3', 'users.profile_picture_original_3',
                    'ud.looking_for_id', 'lf.name as looking_for_name',
                    'ud.league1_id', 'le1.name as league1_name',
                    'ud.league2_id', 'le2.name as league2_name',
                    'ud.league3_id', 'le3.name as league3_name',
                    'ud.clubteam1_id', 'cl1.name as clubteam1_name',
                    'ud.clubteam2_id', 'cl2.name as clubteam2_name',
                    'ud.clubteam3_id', 'cl3.name as clubteam3_name',
                    'ud.player1_id', 'pl1.name as player1_name',
                    'ud.player2_id', 'pl2.name as player2_name',
                    'ud.player3_id', 'pl3.name as player3_name',
                    'ud.coach1_id', 'co1.name as coach1_name',
                    'ud.coach2_id', 'co2.name as coach2_name',
                    'ud.coach3_id', 'co3.name as coach3_name',
                    'ud.position1_id', 'po1.name as position1_name',
                    'ud.position2_id', 'po2.name as position2_name',
                    'ud.position3_id', 'po3.name as position3_name',
                    'ud.favorite_part_id', 'fp.name as favorite_part_name',
                    'ud.football_game_id', 'fg.name as football_game_name',
                    'ud.playing_experience', 'ud.about_me')
                ->where('users.id', $user_id)
                ->leftJoin('users_detail as ud', function($join) {
                    $join->on('ud.user_id', '=', 'users.id');
                })
                ->leftJoin('gender as ge', function($join) {
                    $join->on('ge.id', '=', 'users.gender');
                })
                ->leftJoin('nations as na', function($join) {
                    $join->on('na.id', '=', 'users.nationality');
                })
                ->leftJoin('looking_for as lf', function($join) {
                    $join->on('lf.id', '=', 'ud.looking_for_id');
                })
                ->leftJoin('leagues as le1', function($join) {
                    $join->on('le1.id', '=', 'ud.league1_id');
                })
                ->leftJoin('leagues as le2', function($join) {
                    $join->on('le2.id', '=', 'ud.league2_id');
                })
                ->leftJoin('leagues as le3', function($join) {
                    $join->on('le3.id', '=', 'ud.league3_id');
                })
                ->leftJoin('clubteams as cl1', function($join) {
                    $join->on('cl1.id', '=', 'ud.clubteam1_id');
                })
                ->leftJoin('clubteams as cl2', function($join) {
                    $join->on('cl2.id', '=', 'ud.clubteam2_id');
                })
                ->leftJoin('clubteams as cl3', function($join) {
                    $join->on('cl3.id', '=', 'ud.clubteam3_id');
                })
                ->leftJoin('players as pl1', function($join) {
                    $join->on('pl1.id', '=', 'ud.player1_id');
                })
                ->leftJoin('players as pl2', function($join) {
                    $join->on('pl2.id', '=', 'ud.player2_id');
                })
                ->leftJoin('players as pl3', function($join) {
                    $join->on('pl3.id', '=', 'ud.player3_id');
                })
                ->leftJoin('coaches as co1', function($join) {
                    $join->on('co1.id', '=', 'ud.coach1_id');
                })
                ->leftJoin('coaches as co2', function($join) {
                    $join->on('co2.id', '=', 'ud.coach2_id');
                })
                ->leftJoin('coaches as co3', function($join) {
                    $join->on('co3.id', '=', 'ud.coach3_id');
                })
                ->leftJoin('positions as po1', function($join) {
                    $join->on('po1.id', '=', 'ud.position1_id');
                })
                ->leftJoin('positions as po2', function($join) {
                    $join->on('po2.id', '=', 'ud.position2_id');
                })
                ->leftJoin('positions as po3', function($join) {
                    $join->on('po3.id', '=', 'ud.position3_id');
                })
                ->leftJoin('favorite_parts as fp', function($join) {
                    $join->on('fp.id', '=', 'ud.favorite_part_id');
                })
                ->leftJoin('football_games as fg', function($join) {
                    $join->on('fg.id', '=', 'ud.football_game_id');
                })
                ->get();
            return $record;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }

    public function getName($user_id) {
        try {
            $record = DB::table($this->table)
                ->select('name')
                ->where('id', $user_id)
                ->get();
            return $record;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }
}