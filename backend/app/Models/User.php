<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'user';

    protected $guarded = ['id'];

    protected $fillable = [
        'name', 
        'email', 
        'password',
        'birth_date',
        'image_path',
        'zip_code',
        'tel_no',
        'address'
    ];
}