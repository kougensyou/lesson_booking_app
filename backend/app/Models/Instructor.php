<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}