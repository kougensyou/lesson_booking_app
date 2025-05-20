<?php

namespace App\Models;

class TRiderSituation extends AbstractModel
{
    protected $table = 't_rider_situation';
    protected $primaryKey = 'rider_no';
    public $incrementing = false;
    public $timestamps = false;

    const CREATED_AT = 'cmn_create_date';
    const UPDATED_AT = 'cmn_update_date';

    protected $fillable = [
        'rider_no',
        'rider_status',
        'deliveries_cnt',
        'instructions_id',
        'instructions_res_date',
        'start_address',
        'start_latitude',
        'start_longitude',
        'end_address',
        'end_latitude',
        'end_longitude',
        'del_flg',
        'cmn_create_function_id',
        'cmn_create_user_id',
        'cmn_create_date',
        'cmn_update_function_id',
        'cmn_update_user_id',
        'cmn_update_date',
    ];
}
?>