<?php

namespace App\Models;

class Delivery extends AbstractModel
{
    protected $table = 't_delivery';
    protected $primaryKey = ['order_date', 'inquiry_no', 'order_detail_no'];
    public $incrementing = false;
    
    const CREATED_AT = 'cmn_create_date';
    const UPDATED_AT = 'cmn_update_date';

    protected $fillable = [
        'order_date',
        'inquiry_no',
        'order_detail_no',
        'start_relation_no',
        'start_relation_div',
        'start_delivery_div',
        'start_delivery_seq',
        'start_eta',
        'start_customer_code',
        'start_tel_no',
        'start_company_name',
        'start_company_name_kana',
        'start_post_no',
        'start_todofuken_code',
        'start_todofuken_name',
        'start_shikuchoson_code',
        'start_shikuchoson_name',
        'start_address',
        'start_building_name',
        'start_latitude',
        'start_longitude',
        'start_department',
        'start_person_charge',
        'start_inner_line',
        'start_comment',
        'end_relation_no',
        'end_relation_div',
        'end_delivery_div',
        'end_delivery_seq',
        'end_eta',
        'end_customer_code',
        'end_tel_no',
        'end_company_name',
        'end_company_name_kana',
        'end_post_no',
        'end_todofuken_code',
        'end_todofuken_name',
        'end_shikuchoson_code',
        'end_shikuchoson_name',
        'end_address',
        'end_building_name',
        'end_latitude',
        'end_longitude',
        'end_department',
        'end_charge',
        'end_inner_line',
        'end_comment',
        'delivery_distance',
        'delivery_way',
        'delivery_require_time',
        'delivery_rider_no',
        'delivery_arrangement_date',
        'receive_start_date',
        'receive_end_date',
        'send_start_date',
        'send_end_date',
        'cmn_create_function_id',
        'cmn_create_user_id',
        'cmn_create_date',
        'cmn_update_function_id',
        'cmn_update_user_id',
        'cmn_update_date',
    ];
}