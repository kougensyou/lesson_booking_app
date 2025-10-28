<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    protected $table = 'info';

    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'image_path',
        'kind',
        'link_url',
        'created_at',
        'updated_at',
    ];
}