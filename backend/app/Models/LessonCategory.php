<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LessonCategory extends Model
{
    protected $table = 'lesson_category';

    protected $guarded = ['id'];

    protected $fillable = [
        'category_name',
        'created_at',
        'updated_at',
    ];

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }
}