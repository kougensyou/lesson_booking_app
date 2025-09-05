<?php

namespace App\Models;

class Report extends AbstractModel
{
    protected $table = 'report';
    protected $primaryKey = 'id';
    public $incrementing = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'id',
        'user_id',
        'title',
        'email',
        'contents',
        'created_at',
        'updated_at',
    ];
}