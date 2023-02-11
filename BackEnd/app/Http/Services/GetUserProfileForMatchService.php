<?php

nameSpace App\Http\Services;

use App\Http\Services\BaseService;
use Illuminate\Http\Request;
use Exception;
use App\Exceptions\ExpandException;
use App\Models\UsersModel;


class GetUserProfileForMatchService extends BaseService {
    public function service(Request $request) {
        try {
            $model = new UsersModel();
            $record = $model->getUserProfileForMatch($request->input('user_id'));
            $data = $this->formatResponseData($record);
            return $data;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage, 400);
        }
    }

    private function formatResponseData($record) {
        $data = [];
        $data['gender'] = [];
        $data['nationality'] = [];
        $data['profile_pictures'] = [];
        $data['looking_for'] = [];
        $data['favorite_leagues'] = [];
        $data['favorite_leagues']['favorite_league'] = [];
        $data['favorite_leagues']['second_favorite_league'] = [];
        $data['favorite_leagues']['third_favorite_league'] = [];
        $data['favorite_clubteams'] = [];
        $data['favorite_clubteams']['favorite_clubteam'] = [];
        $data['favorite_clubteams']['second_favorite_clubteam'] = [];
        $data['favorite_clubteams']['third_favorite_clubteam'] = [];
        $data['favorite_players'] = [];
        $data['favorite_players']['favorite_player'] = [];
        $data['favorite_players']['second_favorite_player'] = [];
        $data['favorite_players']['third_favorite_player'] = [];
        $data['favorite_coaches'] = [];
        $data['favorite_coaches']['favorite_coach'] = [];
        $data['favorite_coaches']['second_favorite_coach'] = [];
        $data['favorite_coaches']['third_favorite_coach'] = [];
        $data['favorite_positions'] = [];
        $data['favorite_positions']['favorite_position'] = [];
        $data['favorite_positions']['second_favorite_position'] = [];
        $data['favorite_positions']['third_favorite_position'] = [];
        $data['favorite_part'] = [];
        $data['favorite_football_game'] = [];

        if ($record->count()) {
            $data['user_id'] = $record[0]->id;
            $data['user_name'] = $record[0]->user_name;
            $data['name'] = $record[0]->name;
            $data['age'] = $record[0]->age;
            $data['gender']['id'] = $record[0]->gender;
            $data['gender']['name'] = $record[0]->gender_name;
            $data['nationality']['id'] = $record[0]->nationality;
            $data['nationality']['name'] = $record[0]->nationality_name;
            $data['profile_pictures']['cropped_1'] = $record[0]->profile_picture_cropped_1;
            $data['profile_pictures']['original_1'] = $record[0]->profile_picture_original_1;
            $data['profile_pictures']['cropped_2'] = $record[0]->profile_picture_cropped_2;
            $data['profile_pictures']['original_2'] = $record[0]->profile_picture_original_2;
            $data['profile_pictures']['cropped_3'] = $record[0]->profile_picture_cropped_3;
            $data['profile_pictures']['original_3'] = $record[0]->profile_picture_original_3;
            $data['looking_for']['id'] = $record[0]->looking_for_id;
            $data['looking_for']['name'] = $record[0]->looking_for_name;
            $data['favorite_leagues']['favorite_league']['id'] = $record[0]->league1_id;
            $data['favorite_leagues']['favorite_league']['name'] = $record[0]->league1_name;
            $data['favorite_leagues']['second_favorite_league']['id'] = $record[0]->league2_id;
            $data['favorite_leagues']['second_favorite_league']['name'] = $record[0]->league2_name;
            $data['favorite_leagues']['third_favorite_league']['id'] = $record[0]->league3_id;
            $data['favorite_leagues']['third_favorite_league']['name'] = $record[0]->league3_name;
            $data['favorite_clubteams']['favorite_clubteam']['id'] = $record[0]->clubteam1_id;
            $data['favorite_clubteams']['favorite_clubteam']['name'] = $record[0]->clubteam1_name;
            $data['favorite_clubteams']['second_favorite_clubteam']['id'] = $record[0]->clubteam2_id;
            $data['favorite_clubteams']['second_favorite_clubteam']['name'] = $record[0]->clubteam2_name;
            $data['favorite_clubteams']['third_favorite_clubteam']['id'] = $record[0]->clubteam3_id;
            $data['favorite_clubteams']['third_favorite_clubteam']['name'] = $record[0]->clubteam3_name;
            $data['favorite_players']['favorite_player']['id'] = $record[0]->player1_id;
            $data['favorite_players']['favorite_player']['name'] = $record[0]->player1_name;
            $data['favorite_players']['second_favorite_player']['id'] = $record[0]->player2_id;
            $data['favorite_players']['second_favorite_player']['name'] = $record[0]->player2_name;
            $data['favorite_players']['third_favorite_player']['id'] = $record[0]->player3_id;
            $data['favorite_players']['third_favorite_player']['name'] = $record[0]->player3_name;
            $data['favorite_coaches']['favorite_coach']['id'] = $record[0]->coach1_id;
            $data['favorite_coaches']['favorite_coach']['name'] = $record[0]->coach1_name;
            $data['favorite_coaches']['second_favorite_coach']['id'] = $record[0]->coach2_id;
            $data['favorite_coaches']['second_favorite_coach']['name'] = $record[0]->coach2_name;
            $data['favorite_coaches']['third_favorite_coach']['id'] = $record[0]->coach3_id;
            $data['favorite_coaches']['third_favorite_coach']['name'] = $record[0]->coach3_name;
            $data['favorite_positions']['favorite_position']['id'] = $record[0]->position1_id;
            $data['favorite_positions']['favorite_position']['name'] = $record[0]->position1_name;
            $data['favorite_positions']['second_favorite_position']['id'] = $record[0]->position2_id;
            $data['favorite_positions']['second_favorite_position']['name'] = $record[0]->position2_name;
            $data['favorite_positions']['third_favorite_position']['id'] = $record[0]->position3_id;
            $data['favorite_positions']['third_favorite_position']['name'] = $record[0]->position3_name;
            $data['favorite_part']['id'] = $record[0]->favorite_part_id;
            $data['favorite_part']['name'] = $record[0]->favorite_part_name;
            $data['favorite_football_game']['id'] = $record[0]->football_game_id;
            $data['favorite_football_game']['name'] = $record[0]->football_game_name;
            $data['playing_experience'] = $record[0]->playing_experience;
            $data['about_me'] = $record[0]->about_me;
        } else {
            $data['user_id'] = null;
            $data['user_name'] = null;
            $data['name'] = null;
            $data['age'] = null;
            $data['gender']['id'] = null;
            $data['gender']['name'] = null;
            $data['nationality']['id'] = null;
            $data['nationality']['name'] = null;
            $data['profile_pictures']['cropped_1'] = null;
            $data['profile_pictures']['original_1'] = null;
            $data['profile_pictures']['cropped_2'] = null;
            $data['profile_pictures']['original_2'] = null;
            $data['profile_pictures']['cropped_3'] = null;
            $data['profile_pictures']['original_3'] = null;
            $data['looking_for']['id'] = null;
            $data['looking_for']['name'] = null;
            $data['favorite_leagues']['favorite_league']['id'] = null;
            $data['favorite_leagues']['favorite_league']['name'] = null;
            $data['favorite_leagues']['second_favorite_league']['id'] = null;
            $data['favorite_leagues']['second_favorite_league']['name'] = null;
            $data['favorite_leagues']['third_favorite_league']['id'] = null;
            $data['favorite_leagues']['third_favorite_league']['name'] = null;
            $data['favorite_clubteams']['favorite_clubteam']['id'] = null;
            $data['favorite_clubteams']['favorite_clubteam']['name'] = null;
            $data['favorite_clubteams']['second_favorite_clubteam']['id'] = null;
            $data['favorite_clubteams']['second_favorite_clubteam']['name'] = null;
            $data['favorite_clubteams']['third_favorite_clubteam']['id'] = null;
            $data['favorite_clubteams']['third_favorite_clubteam']['name'] = null;
            $data['favorite_players']['favorite_player']['id'] = null;
            $data['favorite_players']['favorite_player']['name'] = null;
            $data['favorite_players']['second_favorite_player']['id'] = null;
            $data['favorite_players']['second_favorite_player']['name'] = null;
            $data['favorite_players']['third_favorite_player']['id'] = null;
            $data['favorite_players']['third_favorite_player']['name'] = null;
            $data['favorite_coaches']['favorite_coach']['id'] = null;
            $data['favorite_coaches']['favorite_coach']['name'] = null;
            $data['favorite_coaches']['second_favorite_coach']['id'] = null;
            $data['favorite_coaches']['second_favorite_coach']['name'] = null;
            $data['favorite_coaches']['third_favorite_coach']['id'] = null;
            $data['favorite_coaches']['third_favorite_coach']['name'] = null;
            $data['favorite_positions']['favorite_position']['id'] = null;
            $data['favorite_positions']['favorite_position']['name'] = null;
            $data['favorite_positions']['second_favorite_position']['id'] = null;
            $data['favorite_positions']['second_favorite_position']['name'] = null;
            $data['favorite_positions']['third_favorite_position']['id'] = null;
            $data['favorite_positions']['third_favorite_position']['name'] = null;
            $data['favorite_part']['id'] = null;
            $data['favorite_part']['name'] = null;
            $data['favorite_football_game']['id'] = null;
            $data['favorite_football_game']['name'] = null;
            $data['playing_experience'] = null;
            $data['about_me'] = null;
        }
        return $data;
    }
}