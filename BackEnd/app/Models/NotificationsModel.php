<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use App\Enums\NotificationsType;
use App\Exceptions\ExpandException;
use Exception;
use Illuminate\Support\Carbon;

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

    public function canLike($login_user_id, $other_user_id) {
        try {
            return DB::table($this->table)
                ->where('sender_id', $login_user_id)
                ->where('recipient_id', $other_user_id)
                ->where('type', NotificationsType::LIKE)
                ->where('created_at', '>=', Carbon::now()->subMonth())
                ->exists();
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }

    public function sendLike($sender_id, $recipient_id, $type, $read) {
        try {
            DB::table($this->table)
            ->insert(
                [
                    'sender_id' => $sender_id,
                    'recipient_id' => $recipient_id,
                    'type' => $type,
                    'read' => $read,
                    'created_at' => now() 
                ]
            );
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }

    public function getUnreadCount($user_id) {
        try {
            $count = DB::table($this->table)
                ->where('recipient_id', $user_id)
                ->where('read', 0)
                ->count();
            return $count;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }

    public function getNotificationsFirstRequest($user_id, $limit) {
        try {
            $records = DB::table("$this->table as n")
                ->select('n.id', 'n.sender_id', 'n.type', 'n.read', 'n.created_at', 'u.name',
                    'u.profile_picture_cropped_1','u.profile_picture_cropped_2','u.profile_picture_cropped_3')
                ->leftJoin('users as u', function($join) {
                    $join->on('u.id', '=', 'n.sender_id');
                })
                ->where('n.recipient_id', $user_id)
                ->orderBy('n.created_at', 'DESC')
                ->limit($limit)
                ->get();
            return $records;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }

    public function getNotificationsLatest($user_id, $id) {
        try {
            $records = DB::table("$this->table as n")
                ->select('n.id', 'n.sender_id', 'n.type', 'n.read', 'n.created_at', 'u.name',
                    'u.profile_picture_cropped_1','u.profile_picture_cropped_2','u.profile_picture_cropped_3')
                ->leftJoin('users as u', function($join) {
                    $join->on('u.id', '=', 'n.sender_id');
                })
                ->where('n.recipient_id', $user_id)
                ->where('n.id', '>', $id)
                ->orderBy('n.created_at', 'DESC')
                ->get();
            return $records;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }

    public function getNotificationsContinuation($user_id, $id, $limit) {
        try {
            $records = DB::table("$this->table as n")
                ->select('n.id', 'n.sender_id', 'n.type', 'n.read', 'n.created_at', 'u.name',
                'u.profile_picture_cropped_1','u.profile_picture_cropped_2','u.profile_picture_cropped_3')
                ->leftJoin('users as u', function($join) {
                    $join->on('u.id', '=', 'n.sender_id');
                })
                ->where('n.recipient_id', $user_id)
                ->where('n.id', '<', $id)
                ->orderBy('n.created_at', 'DESC')
                ->limit($limit)
                ->get();
            return $records;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }

    public function setReadNotifications($user_id, $id, $read, $unread) {
        try {
            DB::table($this->table)
            ->where('recipient_id', $user_id)
            ->where('id', '<=', $id)
            ->where('read', $unread)
            ->update(
                [
                    'read' => $read,
                    'updated_at' => now() 
                ]
            );
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }
}