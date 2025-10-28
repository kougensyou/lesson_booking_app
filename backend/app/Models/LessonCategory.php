<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonCategory extends Model
{
    protected $table = 'lesson_category';

    protected $guarded = ['id'];

    protected $fillable = [
        'category_name',
        'created_at',
        'updated_at',
    ];
}