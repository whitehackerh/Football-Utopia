<?php

nameSpace App\Http\Services;

use App\Http\Services\BaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Exceptions\ExpandException;
use App\Models\MatchesModel;
use App\Models\NotificationsModel;
use App\Enums\MatchesAction;
use App\Enums\NotificationsType;
use App\Enums\NotificationsRead;

class SetMatchesActionService extends BaseService {
    public function service(Request $request) {
        try {
            /*
                ・insert action
                ・from_user_id, to_user_id, action = 0 ... both
                  -> insert notification 2records
                ・return result isMatch -> 0 : match / 1 : not match
            */
            $data = [];
            $matchesModel = new MatchesModel();
            $notificationsModel = new NotificationsModel();

            $from_user_id = $request->input('from_user_id');
            $to_user_id = $request->input('to_user_id');
            $action = $request->input('action');

            DB::beginTransaction();
            $matchesModel->setAction($from_user_id, $to_user_id, $action);

            if ($action == MatchesAction::YES && $matchesModel->isMatch($to_user_id, $from_user_id)) {
                $records = [];
                $records[] = array(
                    'sender_id' => $from_user_id,
                    'recipient_id' => $to_user_id,
                    'type' => NotificationsType::MATCH,
                    'read' => NotificationsRead::UNREAD
                );
                $records[] = array(
                    'sender_id' => $to_user_id,
                    'recipient_id' => $from_user_id,
                    'type' => NotificationsType::MATCH,
                    'read' => NotificationsRead::UNREAD
                );
                $notificationsModel->setNotifications($records);
                $data['isMatch'] = 0;
            } else {
                $data['isMatch'] = 1;
            }
            DB::commit();
            return $data;
        } catch (Exception $e) {
            DB::rollBack();
            throw new ExpandException($e->getMessage, 400);
        }
    }
}