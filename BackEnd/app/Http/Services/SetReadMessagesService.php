<?php

namespace App\Http\Services;

use App\Http\Services\BaseService;
use App\Models\MessagesModel;
use Illuminate\Http\Request;
use Exception;
use App\Exceptions\ExpandException;
use App\Enums\Read;

class SetReadMessagesService extends BaseService {
    public function service(Request $request) {
        try {
            $model = new MessagesModel();
            $model->SetReadMessages($request->input('user_id'), $request->input('other_user_id'), $request->input('latest_to_read_id'), Read::READ, Read::UNREAD);
            return null;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), 400);
        }
    }
}
