<?php

namespace App\Http\Services;

use App\Http\Services\BaseService;
use App\Models\NotificationsModel;
use Illuminate\Http\Request;
use Exception;
use App\Exceptions\ExpandException;
use App\Enums\Read;

class SetReadNotificationsService extends BaseService {
    public function service(Request $request) {
        try {
            $model = new NotificationsModel();
            $model->setReadNotifications($request->input('user_id'), $request->input('latest_to_read_id'), Read::READ, Read::UNREAD);
            return null;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), 400);
        }
    }
}
