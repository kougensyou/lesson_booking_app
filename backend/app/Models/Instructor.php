<?php

namespace App\Models;

class Instructor extends AbstractModel
{
    protected $table = 'instructor';
    protected $primaryKey = 'id';
    public $incrementing = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'id',
        'name',
        'image_path',
        'studio_id',
        'introduction',
        'from_place',
        'created_at',
        'updated_at',
    ];
}