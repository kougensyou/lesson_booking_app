<?php

namespace App\Models;

class TSubmitFileUpload extends AbstractModel
{
    protected $table = 't_submit_file_upload';
    protected $primaryKey = 'file_id';
    public $incrementing = true;

    const CREATED_AT = 'cmn_create_date';
    const UPDATED_AT = 'cmn_update_date';

    protected $fillable = [
        'order_date',
        'inquiry_no',
        'file_name',
        'file_type',
        'file_path',
        'rider_no',
        'upload_time',
        'description',
        'del_flg',
        'cmn_create_function_id',
        'cmn_create_user_id',
        'cmn_create_date',
        'cmn_update_function_id',
        'cmn_update_user_id',
        'cmn_update_date',
    ];

}
