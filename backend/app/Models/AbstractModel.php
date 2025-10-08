<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbstractModel extends Model
{
    const CREATED_AT = 'cmn_create_date';
    const UPDATED_AT = 'cmn_update_date';

    protected $casts = [
        'cmn_create_date' => 'datetime:Y/m/d H:i:s',
        'cmn_update_date' => 'datetime:Y/m/d H:i:s',
    ];
}
