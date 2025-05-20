<?php

namespace App\Http\Requests\Api\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;


class AddRequest extends FormRequest
{
    use \App\Http\Requests\Api\ValidationRequest;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|unique:m_user|max:999999|numeric',
            'user_name' =>
                ['required',
                'max:10',
                'string',
                'zenkaku_ok'],
            'email' => 'required|email|max:255|confirmed|unique:m_user',
            'email_confirmation' => 'required|max:255',
            'user_type' => 'required',
        ];
    }
}
