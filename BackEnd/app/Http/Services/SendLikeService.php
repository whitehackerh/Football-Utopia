<?php

nameSpace App\Http\Services;

use App\Http\Services\BaseService;
use Illuminate\Http\Request;
use Exception;
use App\Exceptions\ExpandException;
use App\Models\NotificationsModel;
use App\Enums\NotificationsType;
use App\Enums\Read;

class SendLikeService extends BaseService {
    public function service(Request $request) {
        try {
            $model = new NotificationsModel();
            $model->sendLike($request->input('sender_id'), $request->input('recipient_id'), 
                NotificationsType::LIKE, Read::UNREAD);
            return null;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage, 400);
        }
    }
}