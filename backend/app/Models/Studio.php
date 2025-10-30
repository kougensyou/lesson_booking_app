<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Studio extends Model
{
    protected $table = 'studio';

    protected $guarded = ['id'];

    protected $fillable = [
        'studio_name',
        'created_at',
        'updated_at',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    public function favoriteStudios(): HasMany
    {
        return $this->hasMany(FavoriteStudio::class);
    }
}