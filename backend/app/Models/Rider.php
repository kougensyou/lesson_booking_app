<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Rider extends Authenticatable
{
    protected $table = 'm_rider';

    const CREATED_AT = 'cmn_create_date';
    const UPDATED_AT = 'cmn_update_date';

    protected $fillable = [
        'rider_no',
        'rider_name',
        'rider_name_kana',
        'department_code',
        'contract_code',
        'tel_company',
        'tel_private',
        'mail_address_company',
        'contract_start_date',
        'guarantee_end_date',
        'contract_end_date',
        'note',
        'rider_level',
        'rider_div',
        'arrangement_div',
        'contract_div',
        'pay_deadline',
        'pay_site_month_num',
        'pay_day',
        'bank_code',
        'branch_code',
        'deposit_kind',
        'account_number',
        'receiver_name_kana',
        'del_flg',
        'cmn_create_function_id',
        'cmn_create_user_id',
        'cmn_create_date',
        'cmn_update_function_id',
        'cmn_update_user_id',
        'cmn_update_date',
    ];

}