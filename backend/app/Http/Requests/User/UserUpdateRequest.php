<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        if ($this->has('user') && is_string($this->user)) {
            $decoded = json_decode($this->user, true);
            if (is_array($decoded)) {
                \Log::info('Decoded user:', $decoded);
                $this->merge($decoded);
            }
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'                => 'required|string|max:255',
            'email'               => 'required|email|max:255',
            'zip_code'            => 'required|string|max:255',
            'address'             => 'required|string|max:255',
            'birth_date'          => 'required|date',
            'tel_no'              => 'required|string|max:255',
            'image_url'           => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return __('validation.custom');
    }
}