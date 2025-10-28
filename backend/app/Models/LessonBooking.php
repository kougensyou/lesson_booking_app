<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonBooking extends Model
{
    protected $table = 'lesson_booking';

    protected $guarded = ['id'];

    protected $fillable = [
        'booking_time',
        'lesson_id',
        'user_id',
        'done_flag',
        'created_at',
        'updated_at',
    ];
}