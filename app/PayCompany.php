<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayCompany extends Model
{
    protected $fillable = ['*','id', 'my_company_id', 'tip', 'short_name', 'full_name', 'kpp', 'ogrn', 'phone', 'email', 'fio', 'ur_adres', 'post_adres', 'bik', 'rs', 'bank_info', 'created_at', 'updated_at'];
    protected $table='pay_company';
    protected $casts=[
        'bank_info'=>'json'
    ];
}
