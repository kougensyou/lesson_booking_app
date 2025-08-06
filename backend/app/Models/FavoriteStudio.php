<?php

namespace App\Models;

class FavoriteStudio extends AbstractModel
{
    protected $table = 'favorite_studio';
    protected $primaryKey = 'id';
    public $incrementing = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'id',
        'user_id',
        'studio_id',
        'created_at',
        'updated_at',
    ];
}