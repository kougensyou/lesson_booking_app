<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Instructor extends Model
{
    protected $table = 'instructor';

    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'image_path',
        'studio_id',
        'introduction',
        'from_place',
        'created_at',
        'updated_at',
    ];

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }
}