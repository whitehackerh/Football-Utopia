<?php

namespace App\Http\Services;

use App\Http\Services\BaseService;
use App\Models\MessagesModel;
use Illuminate\Http\Request;
use Exception;
use App\Exceptions\ExpandException;

class DeleteMessageService extends BaseService {
    public function service(Request $request) {
        try {
            $user_id = $request->input('user_id');
            $id = $request->input('id');
            $model = new MessagesModel();
            
            if ($model->isSenderMatched($user_id, $id)) {
                $model->deleteMessage($id);
            }
            return null;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), 400);
        }
    }
}