<?php

namespace App\Models\Servies;

use Illuminate\Database\Eloquent\Model;

class CurrencyCurs extends Model
{


    protected $table='currency_curs';

    protected $fillable=['*','curs', 'date'];


}
