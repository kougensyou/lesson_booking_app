<?php

namespace App\Models;

class Studio extends AbstractModel
{
    protected $table = 'studio';
    protected $primaryKey = 'id';
    public $incrementing = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'id',
        'studio_name',
        'created_at',
        'updated_at',
    ];
}