<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function lessonBookings(): HasMany
    {
        return $this->hasMany(LessonBooking::class);
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Instructor::class);
    }

    public function studio(): BelongsTo
    {
        return $this->belongsTo(Studio::class);
    }

    public function lesson_category(): BelongsTo
    {
        return $this->belongsTo(LessonCategory::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}