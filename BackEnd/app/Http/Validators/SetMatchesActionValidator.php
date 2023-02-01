<?php

namespace App\Http\Validators;

use App\Http\Validators\BaseValidator;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\ExpandException;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class SetMatchesActionValidator extends BaseValidator {
    private $parameterRule;

    public function __construct() {
        $this->parameterRule = [
            'from_user_id' => ['required', 'integer'],
            'to_user_id' => ['required', 'integer'],
            'action' => ['required', 'integer']
        ];
    }

    public function validateApi(Request $request) {
        $validateResult = Validator::make($request->all(), $this->parameterRule);
        if ($validateResult->fails()) {
            throw new ExpandException(Arr::flatten($validateResult->errors()->toArray()), parent::VALDIATION_ERROR_CODE);
        }
        return true;
    }
}