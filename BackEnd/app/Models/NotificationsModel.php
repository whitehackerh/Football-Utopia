<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use App\Exceptions\ExpandException;
use Exception;

class NotificationsModel extends BaseModel {
    private $table = 'notifications';

    public function setNotifications($records) {
        try {
            DB::table($this->table)
            ->insert([
                [
                    'sender_id' => $records[0]['sender_id'],
                    'recipient_id' => $records[0]['recipient_id'],
                    'type' => $records[0]['type'],
                    'read' => $records[0]['read'],
                    'created_at' => now() 
                ],
                [
                    'sender_id' => $records[1]['sender_id'],
                    'recipient_id' => $records[1]['recipient_id'],
                    'type' => $records[1]['type'],
                    'read' => $records[1]['read'],
                    'created_at' => now() 
                ]
            ]);
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }
}