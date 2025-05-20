<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait ValidationRequest
{
    /**
     * APIバリデーションエラー時のレスポンス共通フォーマット
     *
     */
    protected function failedValidation(Validator $validator)
    {
        $data = [
            'data' => [],
            'status' => 'error',
            'summary' => 'Failed validation.',
            'errors' => $validator->errors()->toArray(),
        ];

        throw new HttpResponseException(response()->json($data, 422));
    }
}