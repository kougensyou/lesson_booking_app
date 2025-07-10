<?php

namespace App\Models;

class StudioCategory extends AbstractModel
{
    protected $table = 'studio_category';
    protected $primaryKey = 'id';
    public $incrementing = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'id',
        'category_name',
        'created_at',
        'updated_at',
    ];
}