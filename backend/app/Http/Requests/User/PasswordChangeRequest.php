<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class PasswordChangeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'current_password'     => $this->input('password_data.current_password'),
            'new_password'         => $this->input('password_data.new_password'),
            'new_password_confirmation' => $this->input('password_data.new_password_confirmation'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'current_password'     => 'required|string',
            'new_password'         => 'required|string',
            'new_password_confirmation' => 'required|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'current_password' => __('validation.attributes.current_password'),
            'new_password' => __('validation.attributes.new_password'),
            'new_password_confirmation' => __('validation.attributes.new_password_confirmation'),
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->new_password !== $this->new_password_confirmation) {
                $validator->errors()->add('new_password', __('validation.custom.new_password.mismatch'));
            }

            if (!Hash::check($this->current_password, $this->user()->password)) {
                $validator->errors()->add('current_password', __('validation.custom.current_password.invalid'));
            }
        });
    }
}