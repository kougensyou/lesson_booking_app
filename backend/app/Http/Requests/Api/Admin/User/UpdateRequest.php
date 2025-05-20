<?php

namespace App\Http\Requests\Api\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;


class UpdateRequest extends FormRequest
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

        $rules = [
            'user_id' => 'required|max:6',
            'user_name' =>
                ['required',
                'max:10',
                'string',
                'zenkaku_ok'],
            'email' => 'required|max:255|confirmed|unique:m_user,email,'.$this->user_id.',user_id',
            'email_confirmation' => 'required|max:255',
            'user_type' => 'required',
            'del_flg' => 'integer',
        ];

        if(strlen($this->input('email')) == 0 && strlen($this->input('email_confirmation')) == 0){
            unset($rules['email']);
            unset($rules['email_confirmation']);
        }

        return $rules;

    }
}
