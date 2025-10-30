<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'user';

    protected $guarded = ['id'];

    protected $fillable = [
        'name', 
        'email', 
        'password',
        'birth_date',
        'image_path',
        'zip_code',
        'tel_no',
        'address'
    ];

    public function studios(): BelongsToMany
    {
        return $this->belongsToMany(Studio::class);
    }

    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }
}