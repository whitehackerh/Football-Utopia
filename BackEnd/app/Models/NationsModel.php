<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use App\Exceptions\ExpandException;
use Exception;

class NationsModel extends BaseModel {
    private $table = 'nations';

    public function getRecords() {
        try {
            return parent::get($this->table);
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage(), config('ErrorConst.sqlError.code'));
        }
    }
}