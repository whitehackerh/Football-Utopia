<?php

nameSpace App\Http\Services;

use App\Http\Services\BaseService;
use Illuminate\Http\Request;
use Exception;
use App\Exceptions\ExpandException;
use App\Models\UsersModel;
use App\Models\MatchesModel;

class GetUserListForMatchesService extends BaseService {
    private const upperLimit = 10;
    // $remaining == 0 -> upper Limit

    public function service(Request $request) {
        try {
            /*
                other userlist　(users / users_detail join)
                own users / users_detail / filter_settings join
                compare -> sort
                return user_id list as much as $remaining
            */

            $data = [];
            $user_id = $request->input('user_id');
            $matchesModel = new MatchesModel();
            $usersModel = new UsersModel();

            $selfProfileAndFilter = $usersModel->getSelfProfileAndFilter($user_id);
            if (!$selfProfileAndFilter->count()) {
                $data['user_list'] = null;
                $data['supplement'] = 1; // picture null
                return $data;
            }

            $remaining = self::upperLimit - $matchesModel->getTodaysMatchesCount($user_id);
            if ($remaining == 0) {
                $data['user_list'] = null;
                $data['supplement'] = 2; // upper limit
                return $data;
            }

            $excludeUserList = $this->getExcludeUserList($user_id, $usersModel);
            $otherUsersProfile = $usersModel->getUsersProfileList($excludeUserList);
            if (!count($otherUsersProfile)) {
                $data['user_list'] = null;
                $data['supplement'] = 3; // no records
                return $data;
            }

            $data['user_list'] = $this->getUserList($selfProfileAndFilter, $otherUsersProfile, $remaining);
            $data['supplement'] = 0; 
            return $data;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage, 400);
        }
    }

    private function getExcludeUserList($user_id, $model) {
        // profile picture all null
        // from_user = $user_id and action = 0 (yes)
        // from_user = $user_id and action = 1 (nope) and within 1 month
        // own

        $list = [];
        array_push($list, $user_id);
        $noDataList = $model->getNoDataOfProfilePictureList($user_id);
        if ($noDataList->count()) {
            foreach ($noDataList as $user) {
                if (!in_array($user->id, $list)) {
                    array_push($list, $user->id);
                }
            }
        }
        $yesOrNopeRecentlyList = $model->getYesOrNopeRecentlyList($user_id);
        if (count($yesOrNopeRecentlyList)) {
            foreach ($yesOrNopeRecentlyList as $user) {
                if (!in_array($user->id, $list)) {
                    array_push($list, $user->id);
                }
            }
        }
        return $list;
    }

    private function getUserList($selfProfileAndFilter, $otherUsersProfile, $remaining) {
        $userList = [];
        if (count($otherUsersProfile) == 1 || count($otherUsersProfile) <= $remaining) {
            foreach($otherUsersProfile as $index => $array) {
                array_push($userList, $otherUsersProfile[$index]->id);
            }
            return $userList;
        }

        foreach($otherUsersProfile as $index => $array) {
            $otherUsersProfile[$index]->score = 0;

            // Looking For
            if (!is_null($selfProfileAndFilter[0]->fs_looking_for_id)) {
                if ($selfProfileAndFilter[0]->fs_looking_for_id == $otherUsersProfile[$index]->looking_for_id) {
                    $otherUsersProfile[$index]->score += 10;
                }
            } else {
                if (!is_null($selfProfileAndFilter[0]->ud_looking_for_id)) {
                    if ($selfProfileAndFilter[0]->ud_looking_for_id == $otherUsersProfile[$index]->looking_for_id) {
                        $otherUsersProfile[$index]->score += 10;
                    }
                }
            }

            // Age
            if (!is_null($selfProfileAndFilter[0]->min_age) && !is_null($selfProfileAndFilter[0]->max_age)) {
                if ($selfProfileAndFilter[0]->min_age <= $otherUsersProfile[$index]->age && $otherUsersProfile[$index]->age <= $selfProfileAndFilter[0]->max_age) {
                    $otherUsersProfile[$index]->score += 10;
                }
            } else if (!is_null($selfProfileAndFilter[0]->min_age) && is_null($selfProfileAndFilter[0]->max_age)) {
                if ($selfProfileAndFilter[0]->min_age <= $otherUsersProfile[$index]->age) {
                    $otherUsersProfile[$index]->score += 10;
                }
            } else if (is_null($selfProfileAndFilter[0]->min_age) && !is_null($selfProfileAndFilter[0]->max_age)) {
                if ($otherUsersProfile[$index]->age <= $selfProfileAndFilter[0]->max_age) {
                    $otherUsersProfile[$index]->score += 10;
                }
            } else {
                if ($selfProfileAndFilter[0]->age == $otherUsersProfile[$index]->age) {
                    $otherUsersProfile[$index]->score += 5;
                }
            }

            // Gender
            if (!is_null($selfProfileAndFilter[0]->gender_id)) {
                if ($selfProfileAndFilter[0]->gender_id == $otherUsersProfile[$index]->gender) {
                    $otherUsersProfile[$index]->score += 10;
                }
            }

            // Nationality
            if (!is_null($selfProfileAndFilter[0]->nation_id)) {
                if ($selfProfileAndFilter[0]->nation_id == $otherUsersProfile[$index]->nationality) {
                    $otherUsersProfile[$index]->score += 10;
                }
            } else {
                if ($selfProfileAndFilter[0]->nationality == $otherUsersProfile[$index]->nationality) {
                    $otherUsersProfile[$index]->score += 5;
                }
            }

            /*
                Filter1 == 1 : +10 / Filter1 == 2 : +5
                Filter1 == 3 : +3 
                Filter2 == 1 : +5  / Filter2 == 2 : +3
                Filter2 == 3 : +1 
                Filter3 == 1 : +3  / Filter3 == 2 : +1
                Filter3 == 3 : +0 
                Detail1 == 1 : +5  / Detail1 == 2 : +3
                Detail1 == 3 : +1 
                Detail2 == 1 : +3  / Detail2 == 2 : +1
                Detail2 == 3 : +0 
                Detail3 == 1 : +1  / Detail3 == 2 : +0
                Detail3 == 3 : +0
            */
            // League
            if (!is_null($selfProfileAndFilter[0]->fs_league1_id)) {
                if ($selfProfileAndFilter[0]->fs_league1_id == $otherUsersProfile[$index]->league1_id) {
                    $otherUsersProfile[$index]->score += 10;
                }
                if ($selfProfileAndFilter[0]->fs_league1_id == $otherUsersProfile[$index]->league2_id) {
                    $otherUsersProfile[$index]->score += 5;
                }
                if ($selfProfileAndFilter[0]->fs_league1_id == $otherUsersProfile[$index]->league3_id) {
                    $otherUsersProfile[$index]->score += 5;
                }
            }
            if (!is_null($selfProfileAndFilter[0]->fs_league2_id)) {
                if ($selfProfileAndFilter[0]->fs_league2_id == $otherUsersProfile[$index]->league1_id) {
                    $otherUsersProfile[$index]->score += 5;
                }
                if ($selfProfileAndFilter[0]->fs_league2_id == $otherUsersProfile[$index]->league2_id) {
                    $otherUsersProfile[$index]->score += 3;
                }
                if ($selfProfileAndFilter[0]->fs_league2_id == $otherUsersProfile[$index]->league3_id) {
                    $otherUsersProfile[$index]->score += 1;
                }
            }
            if (!is_null($selfProfileAndFilter[0]->fs_league3_id)) {
                if ($selfProfileAndFilter[0]->fs_league3_id == $otherUsersProfile[$index]->league1_id) {
                    $otherUsersProfile[$index]->score += 3;
                }
                if ($selfProfileAndFilter[0]->fs_league3_id == $otherUsersProfile[$index]->league2_id) {
                    $otherUsersProfile[$index]->score += 1;
                }
            }
            if (is_null($selfProfileAndFilter[0]->fs_league1_id) && !is_null($selfProfileAndFilter[0]->ud_league1_id)) {
                if ($selfProfileAndFilter[0]->ud_league1_id == $otherUsersProfile[$index]->league1_id) {
                    $otherUsersProfile[$index]->score += 5;
                }
                if ($selfProfileAndFilter[0]->ud_league1_id == $otherUsersProfile[$index]->league2_id) {
                    $otherUsersProfile[$index]->score += 3;
                }
                if ($selfProfileAndFilter[0]->ud_league1_id == $otherUsersProfile[$index]->league3_id) {
                    $otherUsersProfile[$index]->score += 1;
                }
            }
            if (is_null($selfProfileAndFilter[0]->fs_league2_id) && !is_null($selfProfileAndFilter[0]->ud_league2_id)) {
                if ($selfProfileAndFilter[0]->ud_league2_id == $otherUsersProfile[$index]->league1_id) {
                    $otherUsersProfile[$index]->score += 3;
                }
                if ($selfProfileAndFilter[0]->ud_league2_id == $otherUsersProfile[$index]->league2_id) {
                    $otherUsersProfile[$index]->score += 1;
                }
            }
            if (is_null($selfProfileAndFilter[0]->fs_league3_id) && !is_null($selfProfileAndFilter[0]->ud_league3_id)) {
                if ($selfProfileAndFilter[0]->ud_league3_id == $otherUsersProfile[$index]->league1_id) {
                    $otherUsersProfile[$index]->score += 3;
                }
            }

            // Clubteam
            if (!is_null($selfProfileAndFilter[0]->fs_clubteam1_id)) {
                if ($selfProfileAndFilter[0]->fs_clubteam1_id == $otherUsersProfile[$index]->clubteam1_id) {
                    $otherUsersProfile[$index]->score += 10;
                }
                if ($selfProfileAndFilter[0]->fs_clubteam1_id == $otherUsersProfile[$index]->clubteam2_id) {
                    $otherUsersProfile[$index]->score += 5;
                }
                if ($selfProfileAndFilter[0]->fs_clubteam1_id == $otherUsersProfile[$index]->clubteam3_id) {
                    $otherUsersProfile[$index]->score += 5;
                }
            }
            if (!is_null($selfProfileAndFilter[0]->fs_clubteam2_id)) {
                if ($selfProfileAndFilter[0]->fs_clubteam2_id == $otherUsersProfile[$index]->clubteam1_id) {
                    $otherUsersProfile[$index]->score += 5;
                }
                if ($selfProfileAndFilter[0]->fs_clubteam2_id == $otherUsersProfile[$index]->clubteam2_id) {
                    $otherUsersProfile[$index]->score += 3;
                }
                if ($selfProfileAndFilter[0]->fs_clubteam2_id == $otherUsersProfile[$index]->clubteam3_id) {
                    $otherUsersProfile[$index]->score += 1;
                }
            }
            if (!is_null($selfProfileAndFilter[0]->fs_clubteam3_id)) {
                if ($selfProfileAndFilter[0]->fs_clubteam3_id == $otherUsersProfile[$index]->clubteam1_id) {
                    $otherUsersProfile[$index]->score += 3;
                }
                if ($selfProfileAndFilter[0]->fs_clubteam3_id == $otherUsersProfile[$index]->clubteam2_id) {
                    $otherUsersProfile[$index]->score += 1;
                }
            }
            if (is_null($selfProfileAndFilter[0]->fs_clubteam1_id) && !is_null($selfProfileAndFilter[0]->ud_clubteam1_id)) {
                if ($selfProfileAndFilter[0]->ud_clubteam1_id == $otherUsersProfile[$index]->clubteam1_id) {
                    $otherUsersProfile[$index]->score += 5;
                }
                if ($selfProfileAndFilter[0]->ud_clubteam1_id == $otherUsersProfile[$index]->clubteam2_id) {
                    $otherUsersProfile[$index]->score += 3;
                }
                if ($selfProfileAndFilter[0]->ud_clubteam1_id == $otherUsersProfile[$index]->clubteam3_id) {
                    $otherUsersProfile[$index]->score += 1;
                }
            }
            if (is_null($selfProfileAndFilter[0]->fs_clubteam2_id) && !is_null($selfProfileAndFilter[0]->ud_clubteam2_id)) {
                if ($selfProfileAndFilter[0]->ud_clubteam2_id == $otherUsersProfile[$index]->clubteam1_id) {
                    $otherUsersProfile[$index]->score += 3;
                }
                if ($selfProfileAndFilter[0]->ud_clubteam2_id == $otherUsersProfile[$index]->clubteam2_id) {
                    $otherUsersProfile[$index]->score += 1;
                }
            }
            if (is_null($selfProfileAndFilter[0]->fs_clubteam3_id) && !is_null($selfProfileAndFilter[0]->ud_clubteam3_id)) {
                if ($selfProfileAndFilter[0]->ud_clubteam3_id == $otherUsersProfile[$index]->clubteam1_id) {
                    $otherUsersProfile[$index]->score += 3;
                }
            }
            
            // Player
            if (!is_null($selfProfileAndFilter[0]->fs_player1_id)) {
                if ($selfProfileAndFilter[0]->fs_player1_id == $otherUsersProfile[$index]->player1_id) {
                    $otherUsersProfile[$index]->score += 10;
                }
                if ($selfProfileAndFilter[0]->fs_player1_id == $otherUsersProfile[$index]->player2_id) {
                    $otherUsersProfile[$index]->score += 5;
                }
                if ($selfProfileAndFilter[0]->fs_player1_id == $otherUsersProfile[$index]->player3_id) {
                    $otherUsersProfile[$index]->score += 5;
                }
            }
            if (!is_null($selfProfileAndFilter[0]->fs_player2_id)) {
                if ($selfProfileAndFilter[0]->fs_player2_id == $otherUsersProfile[$index]->player1_id) {
                    $otherUsersProfile[$index]->score += 5;
                }
                if ($selfProfileAndFilter[0]->fs_player2_id == $otherUsersProfile[$index]->player2_id) {
                    $otherUsersProfile[$index]->score += 3;
                }
                if ($selfProfileAndFilter[0]->fs_player2_id == $otherUsersProfile[$index]->player3_id) {
                    $otherUsersProfile[$index]->score += 1;
                }
            }
            if (!is_null($selfProfileAndFilter[0]->fs_player3_id)) {
                if ($selfProfileAndFilter[0]->fs_player3_id == $otherUsersProfile[$index]->player1_id) {
                    $otherUsersProfile[$index]->score += 3;
                }
                if ($selfProfileAndFilter[0]->fs_player3_id == $otherUsersProfile[$index]->player2_id) {
                    $otherUsersProfile[$index]->score += 1;
                }
            }
            if (is_null($selfProfileAndFilter[0]->fs_player1_id) && !is_null($selfProfileAndFilter[0]->ud_player1_id)) {
                if ($selfProfileAndFilter[0]->ud_player1_id == $otherUsersProfile[$index]->player1_id) {
                    $otherUsersProfile[$index]->score += 5;
                }
                if ($selfProfileAndFilter[0]->ud_player1_id == $otherUsersProfile[$index]->player2_id) {
                    $otherUsersProfile[$index]->score += 3;
                }
                if ($selfProfileAndFilter[0]->ud_player1_id == $otherUsersProfile[$index]->player3_id) {
                    $otherUsersProfile[$index]->score += 1;
                }
            }
            if (is_null($selfProfileAndFilter[0]->fs_player2_id) && !is_null($selfProfileAndFilter[0]->ud_player2_id)) {
                if ($selfProfileAndFilter[0]->ud_player2_id == $otherUsersProfile[$index]->player1_id) {
                    $otherUsersProfile[$index]->score += 3;
                }
                if ($selfProfileAndFilter[0]->ud_player2_id == $otherUsersProfile[$index]->player2_id) {
                    $otherUsersProfile[$index]->score += 1;
                }
            }
            if (is_null($selfProfileAndFilter[0]->fs_player3_id) && !is_null($selfProfileAndFilter[0]->ud_player3_id)) {
                if ($selfProfileAndFilter[0]->ud_player3_id == $otherUsersProfile[$index]->player1_id) {
                    $otherUsersProfile[$index]->score += 3;
                }
            }

            // Coach
            if (!is_null($selfProfileAndFilter[0]->fs_coach1_id)) {
                if ($selfProfileAndFilter[0]->fs_coach1_id == $otherUsersProfile[$index]->coach1_id) {
                    $otherUsersProfile[$index]->score += 10;
                }
                if ($selfProfileAndFilter[0]->fs_coach1_id == $otherUsersProfile[$index]->coach2_id) {
                    $otherUsersProfile[$index]->score += 5;
                }
                if ($selfProfileAndFilter[0]->fs_coach1_id == $otherUsersProfile[$index]->coach3_id) {
                    $otherUsersProfile[$index]->score += 5;
                }
            }
            if (!is_null($selfProfileAndFilter[0]->fs_coach2_id)) {
                if ($selfProfileAndFilter[0]->fs_coach2_id == $otherUsersProfile[$index]->coach1_id) {
                    $otherUsersProfile[$index]->score += 5;
                }
                if ($selfProfileAndFilter[0]->fs_coach2_id == $otherUsersProfile[$index]->coach2_id) {
                    $otherUsersProfile[$index]->score += 3;
                }
                if ($selfProfileAndFilter[0]->fs_coach2_id == $otherUsersProfile[$index]->coach3_id) {
                    $otherUsersProfile[$index]->score += 1;
                }
            }
            if (!is_null($selfProfileAndFilter[0]->fs_coach3_id)) {
                if ($selfProfileAndFilter[0]->fs_coach3_id == $otherUsersProfile[$index]->coach1_id) {
                    $otherUsersProfile[$index]->score += 3;
                }
                if ($selfProfileAndFilter[0]->fs_coach3_id == $otherUsersProfile[$index]->coach2_id) {
                    $otherUsersProfile[$index]->score += 1;
                }
            }
            if (is_null($selfProfileAndFilter[0]->fs_coach1_id) && !is_null($selfProfileAndFilter[0]->ud_coach1_id)) {
                if ($selfProfileAndFilter[0]->ud_coach1_id == $otherUsersProfile[$index]->coach1_id) {
                    $otherUsersProfile[$index]->score += 5;
                }
                if ($selfProfileAndFilter[0]->ud_coach1_id == $otherUsersProfile[$index]->coach2_id) {
                    $otherUsersProfile[$index]->score += 3;
                }
                if ($selfProfileAndFilter[0]->ud_coach1_id == $otherUsersProfile[$index]->coach3_id) {
                    $otherUsersProfile[$index]->score += 1;
                }
            }
            if (is_null($selfProfileAndFilter[0]->fs_coach2_id) && !is_null($selfProfileAndFilter[0]->ud_coach2_id)) {
                if ($selfProfileAndFilter[0]->ud_coach2_id == $otherUsersProfile[$index]->coach1_id) {
                    $otherUsersProfile[$index]->score += 3;
                }
                if ($selfProfileAndFilter[0]->ud_coach2_id == $otherUsersProfile[$index]->coach2_id) {
                    $otherUsersProfile[$index]->score += 1;
                }
            }
            if (is_null($selfProfileAndFilter[0]->fs_coach3_id) && !is_null($selfProfileAndFilter[0]->ud_coach3_id)) {
                if ($selfProfileAndFilter[0]->ud_coach3_id == $otherUsersProfile[$index]->coach1_id) {
                    $otherUsersProfile[$index]->score += 3;
                }
            }

            // Position
            if (!is_null($selfProfileAndFilter[0]->fs_position1_id)) {
                if ($selfProfileAndFilter[0]->fs_position1_id == $otherUsersProfile[$index]->position1_id) {
                    $otherUsersProfile[$index]->score += 10;
                }
                if ($selfProfileAndFilter[0]->fs_position1_id == $otherUsersProfile[$index]->position2_id) {
                    $otherUsersProfile[$index]->score += 5;
                }
                if ($selfProfileAndFilter[0]->fs_position1_id == $otherUsersProfile[$index]->position3_id) {
                    $otherUsersProfile[$index]->score += 5;
                }
            }
            if (!is_null($selfProfileAndFilter[0]->fs_position2_id)) {
                if ($selfProfileAndFilter[0]->fs_position2_id == $otherUsersProfile[$index]->position1_id) {
                    $otherUsersProfile[$index]->score += 5;
                }
                if ($selfProfileAndFilter[0]->fs_position2_id == $otherUsersProfile[$index]->position2_id) {
                    $otherUsersProfile[$index]->score += 3;
                }
                if ($selfProfileAndFilter[0]->fs_position2_id == $otherUsersProfile[$index]->position3_id) {
                    $otherUsersProfile[$index]->score += 1;
                }
            }
            if (!is_null($selfProfileAndFilter[0]->fs_position3_id)) {
                if ($selfProfileAndFilter[0]->fs_position3_id == $otherUsersProfile[$index]->position1_id) {
                    $otherUsersProfile[$index]->score += 3;
                }
                if ($selfProfileAndFilter[0]->fs_position3_id == $otherUsersProfile[$index]->position2_id) {
                    $otherUsersProfile[$index]->score += 1;
                }
            }
            if (is_null($selfProfileAndFilter[0]->fs_position1_id) && !is_null($selfProfileAndFilter[0]->ud_position1_id)) {
                if ($selfProfileAndFilter[0]->ud_position1_id == $otherUsersProfile[$index]->position1_id) {
                    $otherUsersProfile[$index]->score += 5;
                }
                if ($selfProfileAndFilter[0]->ud_position1_id == $otherUsersProfile[$index]->position2_id) {
                    $otherUsersProfile[$index]->score += 3;
                }
                if ($selfProfileAndFilter[0]->ud_position1_id == $otherUsersProfile[$index]->position3_id) {
                    $otherUsersProfile[$index]->score += 1;
                }
            }
            if (is_null($selfProfileAndFilter[0]->fs_position2_id) && !is_null($selfProfileAndFilter[0]->ud_position2_id)) {
                if ($selfProfileAndFilter[0]->ud_position2_id == $otherUsersProfile[$index]->position1_id) {
                    $otherUsersProfile[$index]->score += 3;
                }
                if ($selfProfileAndFilter[0]->ud_position2_id == $otherUsersProfile[$index]->position2_id) {
                    $otherUsersProfile[$index]->score += 1;
                }
            }
            if (is_null($selfProfileAndFilter[0]->fs_position3_id) && !is_null($selfProfileAndFilter[0]->ud_position3_id)) {
                if ($selfProfileAndFilter[0]->ud_position3_id == $otherUsersProfile[$index]->position1_id) {
                    $otherUsersProfile[$index]->score += 3;
                }
            }

            // Favorite Part
            if (!is_null($selfProfileAndFilter[0]->fs_favorite_part_id)) {
                if ($selfProfileAndFilter[0]->fs_favorite_part_id == $otherUsersProfile[$index]->favorite_part_id) {
                    $otherUsersProfile[$index]->score += 10;
                }
            } else {
                if (!is_null($selfProfileAndFilter[0]->ud_favorite_part_id)) {
                    if ($selfProfileAndFilter[0]->ud_favorite_part_id == $otherUsersProfile[$index]->favorite_part_id) {
                        $otherUsersProfile[$index]->score += 5;
                    }
                }
            }

            // Football Game
            if (!is_null($selfProfileAndFilter[0]->fs_football_game_id)) {
                if ($selfProfileAndFilter[0]->fs_football_game_id == $otherUsersProfile[$index]->football_game_id) {
                    $otherUsersProfile[$index]->score += 10;
                }
            } else {
                if (!is_null($selfProfileAndFilter[0]->ud_football_game_id)) {
                    if ($selfProfileAndFilter[0]->ud_football_game_id == $otherUsersProfile[$index]->football_game_id) {
                        $otherUsersProfile[$index]->score += 5;
                    }
                }
            }

            // Playing Experience
            if (!is_null($selfProfileAndFilter[0]->fs_playing_experience)) {
                if ($selfProfileAndFilter[0]->fs_playing_experience <= $otherUsersProfile[$index]->playing_experience) {
                    $otherUsersProfile[$index]->score += 5;
                }
            }
        }
        
        usort($otherUsersProfile, array($this, 'userSort'));
        for ($i = 0; $i < $remaining; $i++) {
            array_push($userList, $otherUsersProfile[$i]->id);
        }
        return $userList;
    }

    private function userSort($a, $b) {
        if ($a->score == $b->score) {
            return 0;
        }
        return ($a->score > $b->score) ? -1 : 1;
    }
} 