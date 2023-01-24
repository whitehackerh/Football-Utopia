<?php

nameSpace App\Http\Services;

use App\Http\Services\BaseService;
use Illuminate\Http\Request;
use Exception;
use App\Exceptions\ExpandException;
use App\Models\FilterSettingsModel;

class SetFilterSettingsService extends BaseService {
    public function service(Request $request) {
        try {
            $model = new FilterSettingsModel();
            $model->updateFilterSettings($request->all());
            return null;
        } catch (Exception $e) {
            throw new ExpandException($e->getMessage, 400);
        }
    }
}