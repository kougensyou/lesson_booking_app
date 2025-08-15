<?php

namespace App\Models;

class Lesson extends AbstractModel
{
    protected $table = 'lesson';
    protected $primaryKey = 'id';
    public $incrementing = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'id',
        'instructor_id',
        'name',
        'image_path',
        'studio_id',
        'start_time',
        'end_time',
        'explanation',
        'max_user_num',
        'lesson_category_id',
        'created_at',
        'updated_at',
    ];
}