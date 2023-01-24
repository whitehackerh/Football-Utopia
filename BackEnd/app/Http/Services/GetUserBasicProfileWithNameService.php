<?php

nameSpace App\Http\Services;

use App\Http\Services\BaseService;
use Illuminate\Http\Request;
use Exception;
use App\Exceptions\ExpandException;
use App\Models\UsersModel;

class GetUserBasicProfileWithNameService extends BaseService {
    public function service(Request $request) {
        try {
            $model = new UsersModel();
            $record = $model->getRecordsWithName($request->input('user_id'));
            $data = $this->formatResponseData($record);
            return $data;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage, 400);
        }
    }

    private function formatResponseData($record) {
        $data = [];
        if ($record->count()) {
            $data['gender']['id'] = $record[0]->gender;
            $data['gender']['name'] = $record[0]->gender_name;
            $data['nationality']['id'] = $record[0]->nationality;
            $data['nationality']['name'] = $record[0]->nationality_name;
        } else {
            $data['gender']['id'] = null;
            $data['gender']['name'] = null;
            $data['nationality']['id'] = null;
            $data['nationality']['name'] = null;
        }
        return $data;
    } 
}