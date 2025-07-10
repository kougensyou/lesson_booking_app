<?php

namespace App\Models;

class LessonBooking extends AbstractModel
{
    protected $table = 'lesson_booking';
    protected $primaryKey = 'id';
    public $incrementing = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'id',
        'booking_time',
        'lesson_id',
        'cancel_flag',
        'user_id',
        'done_flag',
        'created_at',
        'updated_at',
    ];
}