<?php

nameSpace App\Http\Services;

use App\Http\Services\BaseService;
use Illuminate\Http\Request;
use Exception;
use App\Exceptions\ExpandException;
use App\Models\NotificationsModel;

class GetUnreadNotificationsService extends BaseService {
    public function service(Request $request) {
        try {
            $data = [];
            $model = new NotificationsModel();
            $data['unread_count'] = $model->getUnreadCount($request->input('user_id'));
            return $data;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage, 400);
        }
    }
}