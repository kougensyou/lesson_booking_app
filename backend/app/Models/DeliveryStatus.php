<?php

namespace App\Models;

class DeliveryStatus extends AbstractModel
{
    protected $table = 't_delivery_status';
    protected $primaryKey = ['order_date', 'inquiry_no'];
    public $incrementing = false;

    const CREATED_AT = 'cmn_create_date';
    const UPDATED_AT = 'cmn_update_date';

    protected $fillable = [
        'order_date',
        'inquiry_no',
        'active_delivery_seq',
        'delivery_status',
        'instructions_id',
        'relation_div',
        'delivery_rider_no',
        'cmn_create_function_id',
        'cmn_create_user_id',
        'cmn_create_date',
        'cmn_update_function_id',
        'cmn_update_user_id',
        'cmn_update_date',
    ];
}