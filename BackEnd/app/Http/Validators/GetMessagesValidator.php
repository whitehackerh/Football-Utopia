<?php

namespace App\Http\Validators;

use App\Http\Validators\BaseValidator;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\ExpandException;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class GetMessagesValidator extends BaseValidator {
    private $parameterRule;

    public function __construct() {
        $this->parameterRule = [
            'user_id' => ['required', 'integer'],
            'other_user_id' => ['required', 'integer'],
            'first_request' => ['required', 'boolean'],
            'displayed_latest_id' => ['present', 'nullable', 'integer'],
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