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
            'lesson_category_name' => 'required|string|max:255',
            'studio_name'          => 'required|string|max:255',
            'lesson_day'           => 'required|date',
            'lesson_time'          => 'required|string|max:50',
            'lesson_name'          => 'required|string|max:255',
            'name'                 => 'required|string|max:255',
            'email'                => 'required|email|max:255',
            'birth_date'           => 'required|date',
        ];
    }

    public function attributes(): array
    {
        return [
            'lesson_category_name' => 'カテゴリー名',
            'studio_name'          => 'スタジオ名',
            'lesson_day'           => 'レッスン日',
            'lesson_time'          => 'レッスン時間',
            'lesson_name'          => 'レッスン名',
            'name'                 => '氏名',
            'email'                => 'メールアドレス',
            'birth_date'           => '生年月日',
        ];
    }
}