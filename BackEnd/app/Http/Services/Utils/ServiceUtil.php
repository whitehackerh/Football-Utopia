<?php

namespace App\Http\Services\Utils;

use Illuminate\Support\Facades\Storage;

class ServiceUtil {
    static function existsDirectory($pass) {
        if (!Storage::exists($pass)) {
            Storage::makeDirectory($pass);
        }
    }
}

