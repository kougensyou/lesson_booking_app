<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    protected $table = 'studio';

    protected $guarded = ['id'];

    protected $fillable = [
        'studio_name',
        'created_at',
        'updated_at',
    ];
}