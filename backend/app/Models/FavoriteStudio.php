<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteStudio extends Model
{
    protected $table = 'favorite_studio';

    protected $guarded = ['id'];

    protected $fillable = [
        'user_id',
        'studio_id',
        'created_at',
        'updated_at',
    ];
}