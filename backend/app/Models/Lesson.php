<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $table = 'lesson';

    protected $guarded = ['id'];

    protected $fillable = [
        'instructor_id',
        'name',
        'image_path',
        'studio_id',
        'start_time',
        'end_time',
        'explanation',
        'max_user_num',
        'booking_user_num',
        'lesson_category_id',
        'created_at',
        'updated_at',
    ];
}