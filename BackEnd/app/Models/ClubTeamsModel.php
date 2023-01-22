<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use App\Exceptions\ExpandException;
use Exception;

class ClubTeamsModel extends BaseModel {
    private $table = 'clubteams';

    public function getRecords() {
        try {
            return parent::get($this->table);
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }
}