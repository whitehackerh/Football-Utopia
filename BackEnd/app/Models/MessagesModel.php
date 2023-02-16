<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use App\Exceptions\ExpandException;
use Exception;

class MessagesModel extends BaseModel {
    private $table = 'messages';

    public function setMessageInit($record) {
        try {
            DB::table($this->table)
            ->insert([
                'sender_id' => $record['sender_id'],
                'receiver_id' => $record['receiver_id'],
                'read' => $record['read'],
                'created_at' => now()
            ]);
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    } 
}
