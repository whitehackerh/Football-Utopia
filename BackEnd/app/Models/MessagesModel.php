<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use App\Enums\Read;
use App\Exceptions\ExpandException;
use Exception;
use Illuminate\Support\Facades\Log;

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

    public function getUnreadCount($user_id) {
        try {
            $count = DB::table($this->table)
                ->where('receiver_id', $user_id)
                ->where('read', Read::UNREAD)
                ->whereNull('deleted_at')
                ->count();
            return $count;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }

    public function getLatestMessageList($user_id) {
        try {
            $records = DB::select(DB::raw("SELECT m.*
                FROM messages m
                JOIN (
                    SELECT
                        CASE
                            WHEN sender_id = $user_id THEN receiver_id
                            WHEN receiver_id = $user_id THEN sender_id
                        END AS other_user_id,
                        MAX(id) AS max_id
                    FROM messages
                    WHERE (sender_id = $user_id OR receiver_id = $user_id) AND deleted_at IS NULL
                    GROUP BY other_user_id
                ) t ON (
                    (m.sender_id = $user_id AND m.receiver_id = t.other_user_id) OR
                    (m.receiver_id = $user_id AND m.sender_id = t.other_user_id)
                ) AND m.id = t.max_id
                ORDER BY id DESC;
                "));
            return $records;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }

    public function getUnreadCountsBySenderId($user_id) {
        try {
            $records = DB::table($this->table)
                ->select('sender_id', DB::raw('COALESCE(COUNT(*) FILTER (WHERE read = 0), 0) AS unread_count'))
                ->where('receiver_id', $user_id)
                ->whereNull('deleted_at')
                ->groupBy('sender_id')
                ->get();
            return $records;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }

    public function getMessagesFirstRequest($user_id, $other_user_id) {
        try {
            $records = DB::table($this->table)
                ->whereNull('deleted_at')
                ->where(function ($query) {
                    $query->whereNotNull('message')
                        ->orWhereNotNull('picture');
                })
                ->where(function ($query) use ($user_id, $other_user_id) {
                    $query->where('sender_id', $user_id)
                        ->where('receiver_id', $other_user_id)
                        ->orWhere('sender_id', $other_user_id)
                        ->where('receiver_id', $user_id);
                })
                ->orderBy('id', 'DESC')
                ->get();
            return $records;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }

    public function getMessagesLatest($user_id, $other_user_id, $id) {
        try {
            $records = DB::table($this->table)
                ->whereNull('deleted_at')
                ->where(function ($query) {
                    $query->whereNotNull('message')
                        ->orWhereNotNull('picture');
                })
                ->where(function ($query) use ($user_id, $other_user_id) {
                    $query->where('sender_id', $user_id)
                        ->where('receiver_id', $other_user_id)
                        ->orWhere('sender_id', $other_user_id)
                        ->where('receiver_id', $user_id);
                })
                ->where('id', '>', $id)
                ->orderBy('id', 'DESC')
                ->get();
            return $records;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }

    public function setReadMessages($user_id, $other_user_id, $id, $read, $unread) {
        try {
            DB::table($this->table)
            ->where('id', '<=', $id)
            ->where('sender_id', $other_user_id)
            ->where('receiver_id', $user_id)
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

    public function isSenderMatched($user_id, $id) {
        try {
            $exists = DB::table($this->table)
                    ->where('sender_id', $user_id)
                    ->where('id', $id)
                    ->exists();
            return $exists;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }

    public function deleteMessage($id) {
        try {
            DB::table($this->table)
                ->where('id', $id)
                ->update(
                    [
                        'deleted_at' => now()
                    ]
                );
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }

    public function insertMessage($sender_id, $receiver_id, $message, $unread) {
        try {
            $id = DB::table($this->table)
            ->insertGetId([
                'sender_id' => $sender_id,
                'receiver_id' => $receiver_id,
                'message' => $message,
                'read' => $unread,
                'created_at' => now(),
            ]);
            return $id;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }

    public function registerPicture($id, $path) {
        try {
            DB::table($this->table)
            ->where('id', $id)
            ->update([
                'picture' => $path
            ]);
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }
}
