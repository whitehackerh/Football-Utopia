<?php

nameSpace App\Http\Services;

use App\Http\Services\BaseService;
use Illuminate\Http\Request;
use Exception;
use App\Exceptions\ExpandException;
use App\Models\MessagesModel;

class GetMessagesService extends BaseService {
    public function service(Request $request) {
        try {
            $model = new MessagesModel();
            $user_id = $request->input('user_id');
            $other_user_id = $request->input('other_user_id');
            $records = null;
            if ($request->input('first_request')) {
                $records = $model->getMessagesFirstRequest($user_id, $other_user_id);
            }
            if ($request->input('displayed_latest_id')) {
                $records = $model->getMessagesLatest($user_id, $other_user_id, $request->input('displayed_latest_id'));
            }
            $data = $this->formatResponseData($records);
            return $data;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage, 400);
        }
    }

    private function formatResponseData($records) {
        $data = [];
        $data['messages'] = [];
        if ($records->count()) {
            $records = array_reverse($records->toArray());
        }
        foreach ($records as $record) {
            $data['messages'][] = [
                'id' => $record->id,
                'sender_id' => $record->sender_id,
                'receiver_id' => $record->receiver_id,
                'message' => $record->message,
                'picture' => $record->picture,
                'read' => $record->read,
                'created_at' => $record->created_at,
                'updated_at' => $record->updated_at
            ];
        }
        return $data;
    }
}