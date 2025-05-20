<?php

namespace App\Models;

class MCommon extends AbstractModel
{
    protected $table = 'm_common';
    protected $primaryKey = ['master_id', 'item_id'];
    public $incrementing = false;
}
