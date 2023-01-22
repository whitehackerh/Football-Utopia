<?php

nameSpace App\Http\Services;

use App\Http\Services\BaseService;
use Illuminate\Http\Request;
use Exception;
use App\Exceptions\ExpandException;
use App\Models\UsersDetailModel;

class GetUserDetailProfileService extends BaseService {
    public function service(Request $request) {
        try {
            $model = new UsersDetailModel();
            $record = $model->getRecords($request->input('user_id'));
            $data = $this->formatResponseData($record);
            return $data;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage, 400);
        }
    }

    private function formatResponseData($record) {
        $data = [];
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