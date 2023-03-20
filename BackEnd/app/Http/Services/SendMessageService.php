<?php

nameSpace App\Http\Services;

use App\Http\Services\BaseService;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\ExpandException;
use App\Models\MessagesModel;
use App\Enums\Read;

class SendMessageService extends BaseService {
    public function service(Request $request) {
        try {
            $model = new MessagesModel();
            $sender_id = $request->input('sender_id');
            $file = $request->file('picture');
            $message = null;
            if ($request->input('message') != 'null') {
                $message = $request->input('message');
            }

            DB::beginTransaction();
            $id = $model->insertMessage($sender_id, $request->input('receiver_id'), $message, Read::UNREAD);

            if ($file) {
                $directory = 'messages';
                $fileName = time() . $id . '.png';
                Storage::putFileAs($directory, $file, $fileName);
                $model->registerPicture($id, $directory . '/' . $fileName);
            }
            DB::commit();
            return null;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage, 400);
        }
    }
}