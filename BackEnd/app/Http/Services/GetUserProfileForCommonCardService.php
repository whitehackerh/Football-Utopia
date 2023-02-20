<?php

nameSpace App\Http\Services;

use App\Http\Services\BaseService;
use Illuminate\Http\Request;
use Exception;
use App\Exceptions\ExpandException;
use App\Models\UsersModel;
use App\Models\NotificationsModel;

class GetUserProfileForCommonCardService extends BaseService {
    public function service(Request $request) {
        try {
            $usersModel = new UsersModel();
            $notificationsModel = new NotificationsModel();
            $profile = $usersModel->getUserProfileForCard($request->input('other_user_id'));
            $data = $this->formatResponseData($profile);
            $data['can_like'] = !$notificationsModel->canLike($request->input('login_user_id'), $request->input('other_user_id'));
            return $data;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage, 400);
        }
    }

    private function formatResponseData($profile) {
        $data = [];
        $data['profile'] = [];
        $data['profile']['gender'] = [];
        $data['profile']['nationality'] = [];
        $data['profile']['profile_pictures'] = [];
        $data['profile']['looking_for'] = [];
        $data['profile']['favorite_leagues'] = [];
        $data['profile']['favorite_leagues']['favorite_league'] = [];
        $data['profile']['favorite_leagues']['second_favorite_league'] = [];
        $data['profile']['favorite_leagues']['third_favorite_league'] = [];
        $data['profile']['favorite_clubteams'] = [];
        $data['profile']['favorite_clubteams']['favorite_clubteam'] = [];
        $data['profile']['favorite_clubteams']['second_favorite_clubteam'] = [];
        $data['profile']['favorite_clubteams']['third_favorite_clubteam'] = [];
        $data['profile']['favorite_players'] = [];
        $data['profile']['favorite_players']['favorite_player'] = [];
        $data['profile']['favorite_players']['second_favorite_player'] = [];
        $data['profile']['favorite_players']['third_favorite_player'] = [];
        $data['profile']['favorite_coaches'] = [];
        $data['profile']['favorite_coaches']['favorite_coach'] = [];
        $data['profile']['favorite_coaches']['second_favorite_coach'] = [];
        $data['profile']['favorite_coaches']['third_favorite_coach'] = [];
        $data['profile']['favorite_positions'] = [];
        $data['profile']['favorite_positions']['favorite_position'] = [];
        $data['profile']['favorite_positions']['second_favorite_position'] = [];
        $data['profile']['favorite_positions']['third_favorite_position'] = [];
        $data['profile']['favorite_part'] = [];
        $data['profile']['favorite_football_game'] = [];

        if ($profile->count()) {
            $data['profile']['user_id'] = $profile[0]->id;
            $data['profile']['user_name'] = $profile[0]->user_name;
            $data['profile']['name'] = $profile[0]->name;
            $data['profile']['age'] = $profile[0]->age;
            $data['profile']['gender']['id'] = $profile[0]->gender;
            $data['profile']['gender']['name'] = $profile[0]->gender_name;
            $data['profile']['nationality']['id'] = $profile[0]->nationality;
            $data['profile']['nationality']['name'] = $profile[0]->nationality_name;
            $data['profile']['profile_pictures']['cropped_1'] = $profile[0]->profile_picture_cropped_1;
            $data['profile']['profile_pictures']['original_1'] = $profile[0]->profile_picture_original_1;
            $data['profile']['profile_pictures']['cropped_2'] = $profile[0]->profile_picture_cropped_2;
            $data['profile']['profile_pictures']['original_2'] = $profile[0]->profile_picture_original_2;
            $data['profile']['profile_pictures']['cropped_3'] = $profile[0]->profile_picture_cropped_3;
            $data['profile']['profile_pictures']['original_3'] = $profile[0]->profile_picture_original_3;
            $data['profile']['looking_for']['id'] = $profile[0]->looking_for_id;
            $data['profile']['looking_for']['name'] = $profile[0]->looking_for_name;
            $data['profile']['favorite_leagues']['favorite_league']['id'] = $profile[0]->league1_id;
            $data['profile']['favorite_leagues']['favorite_league']['name'] = $profile[0]->league1_name;
            $data['profile']['favorite_leagues']['second_favorite_league']['id'] = $profile[0]->league2_id;
            $data['profile']['favorite_leagues']['second_favorite_league']['name'] = $profile[0]->league2_name;
            $data['profile']['favorite_leagues']['third_favorite_league']['id'] = $profile[0]->league3_id;
            $data['profile']['favorite_leagues']['third_favorite_league']['name'] = $profile[0]->league3_name;
            $data['profile']['favorite_clubteams']['favorite_clubteam']['id'] = $profile[0]->clubteam1_id;
            $data['profile']['favorite_clubteams']['favorite_clubteam']['name'] = $profile[0]->clubteam1_name;
            $data['profile']['favorite_clubteams']['second_favorite_clubteam']['id'] = $profile[0]->clubteam2_id;
            $data['profile']['favorite_clubteams']['second_favorite_clubteam']['name'] = $profile[0]->clubteam2_name;
            $data['profile']['favorite_clubteams']['third_favorite_clubteam']['id'] = $profile[0]->clubteam3_id;
            $data['profile']['favorite_clubteams']['third_favorite_clubteam']['name'] = $profile[0]->clubteam3_name;
            $data['profile']['favorite_players']['favorite_player']['id'] = $profile[0]->player1_id;
            $data['profile']['favorite_players']['favorite_player']['name'] = $profile[0]->player1_name;
            $data['profile']['favorite_players']['second_favorite_player']['id'] = $profile[0]->player2_id;
            $data['profile']['favorite_players']['second_favorite_player']['name'] = $profile[0]->player2_name;
            $data['profile']['favorite_players']['third_favorite_player']['id'] = $profile[0]->player3_id;
            $data['profile']['favorite_players']['third_favorite_player']['name'] = $profile[0]->player3_name;
            $data['profile']['favorite_coaches']['favorite_coach']['id'] = $profile[0]->coach1_id;
            $data['profile']['favorite_coaches']['favorite_coach']['name'] = $profile[0]->coach1_name;
            $data['profile']['favorite_coaches']['second_favorite_coach']['id'] = $profile[0]->coach2_id;
            $data['profile']['favorite_coaches']['second_favorite_coach']['name'] = $profile[0]->coach2_name;
            $data['profile']['favorite_coaches']['third_favorite_coach']['id'] = $profile[0]->coach3_id;
            $data['profile']['favorite_coaches']['third_favorite_coach']['name'] = $profile[0]->coach3_name;
            $data['profile']['favorite_positions']['favorite_position']['id'] = $profile[0]->position1_id;
            $data['profile']['favorite_positions']['favorite_position']['name'] = $profile[0]->position1_name;
            $data['profile']['favorite_positions']['second_favorite_position']['id'] = $profile[0]->position2_id;
            $data['profile']['favorite_positions']['second_favorite_position']['name'] = $profile[0]->position2_name;
            $data['profile']['favorite_positions']['third_favorite_position']['id'] = $profile[0]->position3_id;
            $data['profile']['favorite_positions']['third_favorite_position']['name'] = $profile[0]->position3_name;
            $data['profile']['favorite_part']['id'] = $profile[0]->favorite_part_id;
            $data['profile']['favorite_part']['name'] = $profile[0]->favorite_part_name;
            $data['profile']['favorite_football_game']['id'] = $profile[0]->football_game_id;
            $data['profile']['favorite_football_game']['name'] = $profile[0]->football_game_name;
            $data['profile']['playing_experience'] = $profile[0]->playing_experience;
            $data['profile']['about_me'] = $profile[0]->about_me;
        } else {
            $data['profile']['user_id'] = null;
            $data['profile']['user_name'] = null;
            $data['profile']['name'] = null;
            $data['profile']['age'] = null;
            $data['profile']['gender']['id'] = null;
            $data['profile']['gender']['name'] = null;
            $data['profile']['nationality']['id'] = null;
            $data['profile']['nationality']['name'] = null;
            $data['profile']['profile_pictures']['cropped_1'] = null;
            $data['profile']['profile_pictures']['original_1'] = null;
            $data['profile']['profile_pictures']['cropped_2'] = null;
            $data['profile']['profile_pictures']['original_2'] = null;
            $data['profile']['profile_pictures']['cropped_3'] = null;
            $data['profile']['profile_pictures']['original_3'] = null;
            $data['profile']['looking_for']['id'] = null;
            $data['profile']['looking_for']['name'] = null;
            $data['profile']['favorite_leagues']['favorite_league']['id'] = null;
            $data['profile']['favorite_leagues']['favorite_league']['name'] = null;
            $data['profile']['favorite_leagues']['second_favorite_league']['id'] = null;
            $data['profile']['favorite_leagues']['second_favorite_league']['name'] = null;
            $data['profile']['favorite_leagues']['third_favorite_league']['id'] = null;
            $data['profile']['favorite_leagues']['third_favorite_league']['name'] = null;
            $data['profile']['favorite_clubteams']['favorite_clubteam']['id'] = null;
            $data['profile']['favorite_clubteams']['favorite_clubteam']['name'] = null;
            $data['profile']['favorite_clubteams']['second_favorite_clubteam']['id'] = null;
            $data['profile']['favorite_clubteams']['second_favorite_clubteam']['name'] = null;
            $data['profile']['favorite_clubteams']['third_favorite_clubteam']['id'] = null;
            $data['profile']['favorite_clubteams']['third_favorite_clubteam']['name'] = null;
            $data['profile']['favorite_players']['favorite_player']['id'] = null;
            $data['profile']['favorite_players']['favorite_player']['name'] = null;
            $data['profile']['favorite_players']['second_favorite_player']['id'] = null;
            $data['profile']['favorite_players']['second_favorite_player']['name'] = null;
            $data['profile']['favorite_players']['third_favorite_player']['id'] = null;
            $data['profile']['favorite_players']['third_favorite_player']['name'] = null;
            $data['profile']['favorite_coaches']['favorite_coach']['id'] = null;
            $data['profile']['favorite_coaches']['favorite_coach']['name'] = null;
            $data['profile']['favorite_coaches']['second_favorite_coach']['id'] = null;
            $data['profile']['favorite_coaches']['second_favorite_coach']['name'] = null;
            $data['profile']['favorite_coaches']['third_favorite_coach']['id'] = null;
            $data['profile']['favorite_coaches']['third_favorite_coach']['name'] = null;
            $data['profile']['favorite_positions']['favorite_position']['id'] = null;
            $data['profile']['favorite_positions']['favorite_position']['name'] = null;
            $data['profile']['favorite_positions']['second_favorite_position']['id'] = null;
            $data['profile']['favorite_positions']['second_favorite_position']['name'] = null;
            $data['profile']['favorite_positions']['third_favorite_position']['id'] = null;
            $data['profile']['favorite_positions']['third_favorite_position']['name'] = null;
            $data['profile']['favorite_part']['id'] = null;
            $data['profile']['favorite_part']['name'] = null;
            $data['profile']['favorite_football_game']['id'] = null;
            $data['profile']['favorite_football_game']['name'] = null;
            $data['profile']['playing_experience'] = null;
            $data['profile']['about_me'] = null;
        }
        return $data;
    }
}