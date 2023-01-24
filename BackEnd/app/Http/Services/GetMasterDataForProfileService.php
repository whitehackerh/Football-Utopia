<?php

namespace App\Http\Services;

use App\Http\Services\BaseService;
use Illuminate\Http\Request;
use Exception;
use App\Exceptions\ExpandException;
use App\Models\CoachesModel;
use App\Models\FavoritePartsModel;
use App\Models\LeaguesModel;
use App\Models\ClubTeamsModel;
use App\Models\LookingForModel;
use App\Models\PlayersModel;
use App\Models\PositionsModel;
use App\Models\FootballGamesModel;
use App\Models\GenderModel;
use App\Models\NationsModel;

class GetMasterDataForProfileService extends BaseService {
    public function service(Request $request) {
        try {
            list($lookingForRecords, $leaguesRecords, $clubsRecords, 
                $playersRecords, $coachesRecords, $favoritePartsRecords, 
                $positionsRecords, $footballGamesRecords, $genderRecords, $nationsRecords)
                = $this->getRecords();
            $data = $this->formatResponseData($lookingForRecords, $leaguesRecords, $clubsRecords, 
                        $playersRecords, $coachesRecords, $favoritePartsRecords, 
                        $positionsRecords, $footballGamesRecords, $genderRecords, $nationsRecords);
            return $data;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage, 400);
        }
    }

    private function getRecords() {
        $lookingForModel = new LookingForModel();
        $leaguesModel = new LeaguesModel();
        $clubteamsModel = new ClubteamsModel();
        $playersModel = new PlayersModel();
        $coachesModel = new CoachesModel();
        $favoritePartsModel = new FavoritePartsModel();
        $positionsModel = new PositionsModel();
        $footballGamesModel = new FootballGamesModel();
        $genderModel = new genderModel();
        $nationsModel = new NationsModel();

        return array($lookingForModel->getRecords(), $leaguesModel->getRecords(),
            $clubteamsModel->getRecords(), $playersModel->getRecords(), $coachesModel->getRecords(),
            $favoritePartsModel->getRecords(), $positionsModel->getRecords(), $footballGamesModel->getRecords(),
            $genderModel->getRecords(), $nationsModel->getRecords()
        );
    }

    private function formatResponseData($lookingForRecords, $leaguesRecords, $clubteamsRecords, 
    $playersRecords, $coachesRecords, $favoritePartsRecords, 
    $positionsRecords, $footballGamesRecords, $genderRecords, $nationsRecords) {
        $data = [];
        $data['looking_for'] = [];
        $data['leagues'] = [];
        $data['clubteams'] = [];
        $data['players'] = [];
        $data['coaches'] = [];
        $data['favorite_parts'] = [];
        $data['positions'] = [];
        $data['football_games'] = [];
        $data['gender'] = [];
        $data['nations'] = [];

        foreach ($lookingForRecords as $record) {
            $temporary = [];
            $temporary['id'] = $record->id;
            $temporary['name'] = $record->name;
            array_push($data['looking_for'], $temporary);
        }

        foreach ($leaguesRecords as $record) {
            $temporary = [];
            $temporary['id'] = $record->id;
            $temporary['name'] = $record->name;
            array_push($data['leagues'], $temporary);
        }

        foreach ($clubteamsRecords as $record) {
            $temporary = [];
            $temporary['id'] = $record->id;
            $temporary['league_id'] = $record->league_id;
            $temporary['clubteam_id'] = $record->clubteam_id;
            $temporary['name'] = $record->name;
            array_push($data['clubteams'], $temporary);
        }

        foreach ($playersRecords as $record) {
            $temporary = [];
            $temporary['id'] = $record->id;
            $temporary['league_id'] = $record->league_id;
            $temporary['clubteam_id'] = $record->clubteam_id;
            $temporary['player_id'] = $record->player_id;
            $temporary['name'] = $record->name;
            array_push($data['players'], $temporary);
        }

        foreach ($coachesRecords as $record) {
            $temporary = [];
            $temporary['id'] = $record->id;
            $temporary['league_id'] = $record->league_id;
            $temporary['clubteam_id'] = $record->clubteam_id;
            $temporary['coach_id'] = $record->coach_id;
            $temporary['name'] = $record->name;
            array_push($data['coaches'], $temporary);
        }

        foreach ($favoritePartsRecords as $record) {
            $temporary = [];
            $temporary['id'] = $record->id;
            $temporary['name'] = $record->name;
            array_push($data['favorite_parts'], $temporary);
        }

        foreach ($positionsRecords as $record) {
            $temporary = [];
            $temporary['id'] = $record->id;
            $temporary['name'] = $record->name;
            array_push($data['positions'], $temporary);
        }

        foreach ($footballGamesRecords as $record) {
            $temporary = [];
            $temporary['id'] = $record->id;
            $temporary['name'] = $record->name;
            array_push($data['football_games'], $temporary);
        }

        foreach ($genderRecords as $record) {
            $temporary = [];
            $temporary['id'] = $record->id;
            $temporary['name'] = $record->name;
            array_push($data['gender'], $temporary);
        }

        foreach ($nationsRecords as $record) {
            $temporary = [];
            $temporary['id'] = $record->id;
            $temporary['name'] = $record->name;
            array_push($data['nations'], $temporary);
        }

        return $data;
    }
}