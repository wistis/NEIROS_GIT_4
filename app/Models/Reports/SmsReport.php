<?php

namespace App\Models\Reports;

use App\Sites;
use Illuminate\Database\Eloquent\Model;

class SmsReport extends Model
{

    protected $fillable=['*','id', 'my_company_id', 'fields', 'repeat_sms', 'site_id', 'time', 'date_reports', 'day_send', 'created_at', 'updated_at','send_date'];
    protected $table='sms_reports';

    protected $casts=['fields'=>'json'];
const FIELDS=['visit'=>'Посетители',

  'sdelka'=>'Заявки',
  'conversionsd'=>'Конверсия в заявку',
  'lead'=>'Продажи',
  'conversionld'=>'Конверсия в заказ',
  'srcheck'=>'Средний чек',
  'roi'=>'ROI',



];
    const FIELDS_ELK=['visit'=>'',

        'sdelka'=>'',
        'conversionsd'=>'%',
        'lead'=>'',
        'conversionld'=>'%',
        'srcheck'=>'',
        'roi'=>'%',



    ];
const  REPEAT_SMS=[
  'day'=>"Каждый день",
  'week'=>"Каждую неделю",
  'month'=>"Каждый месяц",



];
    const  DATE_REPORTS=[
        'day'=>"За день",
        'week'=>"За 7 дней",
        'month'=>"За месяц",



    ];
const  DAY_SAND=[
    0=>'Воскресенье',
    1=>'Понедельник',
    2=>'Вторник',
    3=>'Среда',
    4=>'Четверг',
    5=>'Пятница',
    6=>'Суббота',



];

    public static function boot()

    {

        parent::boot();

        static::created(function ($project) {

            SmsReport::create_send_date($project->id);


        });

    }


public static function create_send_date($id){
    $sms=SmsReport::find($id);
 $new_time=null;
 /*Если отчет каждый день*/
if($sms->repeat_sms=='day'){

    if(date('Y-m-d '.$sms->time)>date('Y-m-d H:i:s')){

        $new_time=date('Y-m-d '.$sms->time);

    }else{

        $new_time=date('Y-m-d '.$sms->time,strtotime('+ 1 day',strtotime(date('Y-m-d'))));

    }
}
    /*Если отчет каждый день*/


    /*Если отчет каждую неделю*/
    if($sms->repeat_sms=='week'){
//echo date('d.m.Y', strtotime('next Sunday', strtotime('07.05.2010')));
if(($sms->day_send==date('w'))&&(date('Y-m-d '.$sms->time)>date('Y-m-d H:i:s'))){
    /*Если сегодня тот день*/

    $new_time=date('Y-m-d '.$sms->time);

}else{
    $dowMap = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');

    $new_time=date('Y-m-d '.$sms->time, strtotime('next '.$dowMap[$sms->day_send], strtotime(date('Y-m-d'))));

}


    }
    /*Если отчет каждую неделю*/


    /*Если отчет каждый месяц */
    if($sms->repeat_sms=='month'){



            if(date('Y-m-01 '.$sms->time)>date('Y-m-d H:i:s')){

                $new_time=date('Y-m-d '.$sms->time);

            }else{

                $new_time=date('Y-m-d '.$sms->time,strtotime('+ 1 month',strtotime(date('Y-m-d'))));

            }



    }











    $sms->send_date=$new_time;
    $sms->save();

}

public function site(){

        return $this->belongsTo(Sites::class,'site_id','id');
}
}
