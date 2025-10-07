<?php

namespace App\Http\Requests\Report;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:50',
            'email' => 'required|email|max:30',
            'contents' => 'required'
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => __('validation.attributes.report_title'),
            'email' => __('validation.attributes.report_email'),
            'contents' => __('validation.attributes.report_contents')
        ];
    }
}