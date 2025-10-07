<?php

namespace App\Http\Requests\LessonBooking;

use Illuminate\Foundation\Http\FormRequest;

class FirstBookingRequest extends FormRequest
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
            'lesson_category_name' => $this->input('first_booking.selectedLesson.lesson_category_name'),
            'studio_name'          => $this->input('first_booking.selectedLesson.studio_name'),
            'lesson_day'           => $this->input('first_booking.selectedLesson.lesson_day'),
            'lesson_time'          => $this->input('first_booking.selectedLesson.lesson_time'),
            'lesson_name'          => $this->input('first_booking.selectedLesson.lesson_name'),
            'name'                 => $this->input('first_booking.user.name'),
            'email'                => $this->input('first_booking.user.email'),
            'birth_date'           => $this->input('first_booking.user.birth_date'),
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
            'lesson_category_name' => 'required|string',
            'studio_name'          => 'required|string',
            'lesson_name'          => 'required',
            'name'                 => 'required|string',
            'email'                => 'required|email',
            'birth_date'           => 'required|date',
        ];
    }

    public function attributes(): array
    {
        return __('validation.attributes');
    }

    public function messages(): array
    {
        return __('validation.custom');
    }
}