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

    protected function prepareForValidation()
    {
        $this->merge([
            'currentPassword'     => $this->input('password_data.currentPassword'),
            'newPassword'         => $this->input('password_data.newPassword'),
            'newPasswordConfirmation' => $this->input('password_data.newPasswordConfirmation'),
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
            'currentPassword'     => 'required|string',
            'newPassword'         => 'required|string',
            'newPasswordConfirmation' => 'required|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'currentPassword' => __('validation.attributes.current_password'),
            'newPassword' => __('validation.attributes.new_password'),
            'newPasswordConfirmation' => __('validation.attributes.new_password_confirmation'),
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->newPassword !== $this->newPasswordConfirmation) {
                $validator->errors()->add('newPassword', __('validation.custom.newPassword.mismatch'));
            }

            if (!Hash::check($this->currentPassword, $this->user()->password)) {
                $validator->errors()->add('currentPassword', __('validation.custom.currentPassword.invalid'));
            }
        });
    }
}