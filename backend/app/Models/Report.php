<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'report';

    protected $guarded = ['id'];

    protected $fillable = [
        'user_id',
        'title',
        'email',
        'contents',
        'created_at',
        'updated_at',
    ];
}