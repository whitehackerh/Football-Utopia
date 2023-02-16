<?php

namespace App\Http\Services;

use App\Http\Services\BaseService;
use Illuminate\Http\Request;
use Exception;
use App\Exceptions\ExpandException;
use App\Models\MatchesModel;
use App\Enums\MatchAction;

class GetMatchHistoryService extends BaseService {
    public function service(Request $request) {
        try {
            $model = new MatchesModel();
            $page = $request->input('page');
            $offset = ($page - 1) * 10 + 1;  
            $records = $model->getMatchHistory($request->input('user_id'), $offset, $offset + 9);
            $data = $this->formatResponseData($records, $model);
            return $data;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage, 400);
        }
    }

    private function formatResponseData($records, $model) {
        $data = [];
        $data['records'] = [];
        if ($records->count()) {
            foreach ($records as $record) {
                $is_match = null;
                if ($record->action == MatchAction::YES) {
                    if ($model->isMatch($record->to_user_id, $record->from_user_id)) {
                        $is_match = true;
                    } else {
                        $is_match = false;
                    }
                } else {
                    $is_match = false;
                }
                $profile_picture_representative = null;
                if ($record->profile_picture_cropped_1) {
                    $profile_picture_representative = $record->profile_picture_cropped_1;
                } else if (!$record->profile_picture_cropped_1 && $record->profile_picture_cropped_2) {
                    $profile_picture_representative = $record->profile_picture_cropped_2;
                } else if (!$record->profile_picture_cropped_1 && !$record->profile_picture_cropped_2 && $record->profile_picture_cropped_3) {
                    $profile_picture_representative = $record->profile_picture_cropped_3;
                }
                $record->is_match = $is_match;
                $record->profile_picture_representative = $profile_picture_representative;
                $record->created_at = date('d/m/Y', strtotime($record->created_at));
                $data['records'][] = $record;
            }
            $data['exist_days'] = count($data['records']);
        } else {
            $data['exist_days'] = 0;
        }
        return $data;
    }
}