<?php

namespace App\Http\Validators;

use App\Http\Validators\BaseValidator;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\ExpandException;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class SetFilterSettingsValidator extends BaseValidator {
    private $parameterRule;

    public function __construct() {
        $this->parameterRule = [
            'user_id' => ['required', 'integer'],
            'age.min' => ['present', 'numeric', 'lte:age.max', 'nullable'],
            'age.max' => ['present', 'numeric', 'gte:age.min', 'nullable'],
            'looking_for' => ['present', 'integer', 'nullable'],
            'gender' => ['present', 'integer', 'nullable'],
            'nationality' => ['present', 'integer', 'nullable'],
            'favorite_leagues' => ['required', 'array'],
            'favorite_leagues.favorite_league' => ['present', 'nullable', 'integer',
                'different:favorite_leagues.second_favorite_league', 'different:favorite_leagues.third_favorite_league',
                'required_with:favorite_leagues.second_favorite_league', 'required_with:favorite_leagues.third_favorite_league'
            ],
            'favorite_leagues.second_favorite_league' => ['present', 'nullable', 'integer', 
                'different:favorite_leagues.favorite_league', 'different:favorite_leagues.third_favorite_league',
                'required_with:favorite_leagues.third_favorite_league'
            ],
            'favorite_leagues.third_favorite_league' => ['present', 'nullable', 'integer',
                'different:favorite_leagues.favorite_league', 'different:favorite_leagues.second_favorite_league'
            ],
            'favorite_clubteams' => ['required', 'array'],
            'favorite_clubteams.favorite_clubteam' => ['present', 'nullable', 'integer',
                'different:favorite_clubteams.second_favorite_clubteam', 'different:favorite_clubteams.third_favorite_clubteam',
                'required_with:favorite_clubteams.second_favorite_clubteam', 'required_with:favorite_clubteams.third_favorite_clubteam'
            ],
            'favorite_clubteams.second_favorite_clubteam' => ['present', 'nullable', 'integer',
                'different:favorite_clubteams.favorite_clubteam', 'different:favorite_clubteams.third_favorite_clubteam',
                'required_with:favorite_clubteams.third_favorite_clubteam'
            ],
            'favorite_clubteams.third_favorite_clubteam' => ['present', 'nullable', 'integer',
                'different:favorite_clubteams.favorite_clubteam', 'different:favorite_clubteams.second_favorite_clubteam'
            ],
            'favorite_players' => ['required', 'array'],
            'favorite_players.favorite_player' => ['present', 'nullable', 'integer',
                'different:favorite_players.second_favorite_player', 'different:favorite_players.third_favorite_player',
                'required_with:favorite_players.second_favorite_player', 'required_with:favorite_players.third_favorite_player'
            ],
            'favorite_players.second_favorite_player' => ['present', 'nullable', 'integer',
                'different:favorite_players.favorite_player', 'different:favorite_players.third_favorite_player',
                'required_with:favorite_players.third_favorite_player'
            ],
            'favorite_players.third_favorite_player' => ['present', 'nullable', 'integer',
                'different:favorite_players.favorite_player', 'different:favorite_players.second_favorite_player',
            ],
            'favorite_coaches' => ['required', 'array'],
            'favorite_coaches.favorite_coach' => ['present', 'nullable', 'integer',
                'different:favorite_coaches.second_favorite_coach', 'different:favorite_coaches.third_favorite_coach',
                'required_with:favorite_coaches.second_favorite_coach', 'required_with:favorite_coaches.third_favorite_coach'
            ],
            'favorite_coaches.second_favorite_coach' => ['present', 'nullable', 'integer',
                'different:favorite_coaches.favorite_coach', 'different:favorite_coaches.third_favorite_coach',
                'required_with:favorite_coaches.third_favorite_coach'
            ],
            'favorite_coaches.third_favorite_coach' => ['present', 'nullable', 'integer',
                'different:favorite_coaches.favorite_coach', 'different:favorite_coaches.second_favorite_coach',
            ],
            'favorite_positions' => ['required', 'array'],
            'favorite_positions.favorite_position' => ['present', 'nullable', 'integer',
                'different:favorite_positions.second_favorite_position', 'different:favorite_positions.third_favorite_position',
                'required_with:favorite_positions.second_favorite_position', 'required_with:favorite_position.third_favorite_position'
            ],
            'favorite_positions.second_favorite_position' => ['present', 'nullable', 'integer',
                'different:favorite_positions.favorite_position', 'different:favorite_positions.third_favorite_position',
                'required_with:favorite_position.third_favorite_position'
            ],
            'favorite_positions.third_favorite_position' => ['present', 'nullable', 'integer',
                'different:favorite_positions.favorite_position', 'different:favorite_positions.second_favorite_position',
            ],
            'favorite_part' => ['present', 'nullable', 'integer'],
            'favorite_football_game' => ['present', 'nullable', 'integer'],
            'playing_experience' => ['present', 'nullable', 'integer'],
        ];
    }

    public function validateApi(Request $request) {
        $validateResult = Validator::make($request->all(), $this->parameterRule);
        if ($validateResult->fails()) {
            throw new ExpandException(Arr::flatten($validateResult->errors()->toArray()), parent::VALDIATION_ERROR_CODE);
        }
        return true;
    }
}