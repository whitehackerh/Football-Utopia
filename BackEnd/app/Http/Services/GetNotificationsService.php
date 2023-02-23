<?php

nameSpace App\Http\Services;

use App\Http\Services\BaseService;
use Illuminate\Http\Request;
use Exception;
use App\Exceptions\ExpandException;
use App\Models\NotificationsModel;
use App\Enums\NotificationsContent;

class GetNotificationsService extends BaseService {
    private const LIMIT = 10;
    public function service(Request $request) {
        try {
            $model = new NotificationsModel();
            $user_id = $request->input('user_id');
            $records = null;
            if ($request->input('first_request')) {
                $records = $model->getNotificationsFirstRequest($user_id, self::LIMIT);
            }
            if ($request->input('displayed_latest_id')) {
                $records = $model->getNotificationsLatest($user_id, $request->input('displayed_latest_id'));
            }
            if ($request->input('displayed_oldest_id')) {
                $records = $model->getNotificationsContinuation($user_id, $request->input('displayed_oldest_id'), self::LIMIT);
            }
            $data = $this->formatResponseData($records); 
            return $data;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage, 400);
        }
    }

    private function formatResponseData($records) {
        $data = [];
        $data['notifications'] = [];
        foreach ($records as $record) {
            $message = '';
            switch ($record->type) {
                case 1:
                    $message = NotificationsContent::MATCH . $record->name;
                    break;
                case 2:
                    $message = $record->name . NotificationsContent::LIKE;
                    break;
                case 3:
                    $message = NotificationsContent::ALBUM_VIEWING_REQUEST_FIRST . $record->name . NotificatiosContent::ALBUM_VIEWING_REQUEST_LATTER;
                    break;
                default:
                    break;
            }
            $profile_picture = null;
            if ($record->profile_picture_cropped_1) {
                $profile_picture = $record->profile_picture_cropped_1;
            } else if ($record->profile_picture_cropped_2) {
                $profile_picture = $record->profile_picture_cropped_2;
            } else if ($record->profile_picture_cropped_3) {
                $profile_picture = $record->profile_picture_cropped_3;
            }
            $data['notifications'][] = [
                'id' => $record->id,
                'sender_id' => $record->sender_id,
                'type' => $record->type,
                'read' => $record->read,
                'created_at' => $record->created_at,
                'message' => $message,
                'profile_picture' => $profile_picture
            ]; 
        }
        return $data;
    }
}