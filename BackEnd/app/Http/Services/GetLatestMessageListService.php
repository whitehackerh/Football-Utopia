<?php

nameSpace App\Http\Services;

use App\Http\Services\BaseService;
use Illuminate\Http\Request;
use Exception;
use App\Exceptions\ExpandException;
use App\Models\MessagesModel;
use App\Models\UsersModel;

class GetLatestMessageListService extends BaseService {
    public function service(Request $request) {
        try {
            $data = [];
            $user_id = $request->input('user_id');
            $messagesModel = new MessagesModel();
            $usersModel = new UsersModel();
            $latestMessageList = $messagesModel->getLatestMessageList($user_id);
            if (!count($latestMessageList)) {
                $data['latest_message_list'] = null;
                return $data;
            }
            $unreadCountList = $messagesModel->getUnreadCountsBySenderId($user_id);
            $userList = $this->getUserList($user_id, $latestMessageList);
            $userInfoList = $usersModel->getNameAndPictures($userList);
            $data = $this->formatResponseData($user_id, $latestMessageList, $unreadCountList, $userInfoList);  
            return $data;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage, 400);
        }
    }

    private function getUserList($user_id, $latestMessageList) {
        $userList = [];
        foreach ($latestMessageList as $record) {
            if ($record->sender_id != $user_id) {
                array_push($userList, $record->sender_id);
            } else {
                array_push($userList, $record->receiver_id);
            }
        }
        return $userList;
    }

    private function formatResponseData($user_id, $latestMessageList, $unreadCountList, $userInfoList) {
        $data = [];
        $data['latest_message_list']= [];

        foreach ($latestMessageList as $record) {
            $otherUserId = null;
            if ($record->sender_id == $user_id) {
                $otherUserId = $record->receiver_id;
            } else {
                $otherUserId = $record->sender_id;
            }
            $message = null;
            if (is_null($record->message) && !is_null($record->picture)) {
                $message = 'Picture has been sent.';
            } else if (!is_null($record->message)) {
                $message = $record->message;
            }
            $data['latest_message_list'][] = [
                'other_user_id' => $otherUserId,
                'message' => $message
            ];
        }

        for ($i = 0; $i < count($data['latest_message_list']); $i++) {
            $data['latest_message_list'][$i]['unread_count'] = 0;
            foreach ($unreadCountList as $record) {
                if ($data['latest_message_list'][$i]['other_user_id'] == $record->sender_id) {
                    $data['latest_message_list'][$i]['unread_count'] = $record->unread_count;
                }
            }
        }

        for ($i = 0; $i < count($data['latest_message_list']); $i++) {
            foreach ($userInfoList as $record) {
                if ($data['latest_message_list'][$i]['other_user_id'] == $record->id) {
                    $data['latest_message_list'][$i]['name'] = $record->name;
                    if ($record->profile_picture_cropped_1) {
                        $data['latest_message_list'][$i]['profile_picture_cropped'] = $record->profile_picture_cropped_1;
                    } else if ($record->profile_picture_cropped_2) {
                        $data['latest_message_list'][$i]['profile_picture_cropped'] = $record->profile_picture_cropped_2;
                    } else if ($record->profile_picture_cropped_3) {
                        $data['latest_message_list'][$i]['profile_picture_cropped'] = $record->profile_picture_cropped_3;
                    } else {
                        $data['latest_message_list'][$i]['profile_picture_cropped'] = null;
                    }
                }
            } 
        }
        
        return $data;
    }
}