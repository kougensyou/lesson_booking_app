<?php

namespace App\Models;

class Info extends AbstractModel
{
    protected $table = 'info';
    protected $primaryKey = 'id';
    public $incrementing = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'id',
        'name',
        'image_path',
        'kind',
        'link_url',
        'created_at',
        'updated_at',
    ];
}