<?php

namespace App;

use App\Models\MetrikaCurrentRegion;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    
    protected $fillable=['*','id', 'name', 'stage_id', 'user_id', 'summ', 'comment', 'created_at', 'updated_at', 'fio', 'company', 'phone', 'email', 'company_id', 'client_id', 'widget_id', 'my_company_id', 'client_hash', 'vst', 'pgs', 'promocod', 'url', 'site_id', 'hour', 'week', 'uniqueid', 'sub_widget', 'promocodoff', 'is_viewed', 'amo_id', 'reports_date', 'bt24_id', 'report_grouping', 'call_back_random_id', 'neiros_visit', 'neiros_url_vst', 'phone_to_call', 'client_project_id','widgets_client_id','widgets_model','bt24_deal_id','bt24_id_client','ncl_id'];
    
   public function set_max(){
       $pr=Project::where('site_id',$this->site_id)->max('client_project_id');
       $new_max=$pr+1;

       $this->client_project_id=$new_max;
       $this->save();


   }
public function get_chat_users(){


           return $this->belongsTo("$this->widgets_model", 'widgets_client_id','id');

}
   public function get_widget_info(){


       return $this->hasOne(Widgets::class,'id','widget_id');


   }
public function getUserCompany(){
       return $this->hasOne(Users_company::class,'id','my_company_id');
}

    public static function boot()

    {

        parent::boot();

        static::created(function ($project) {

            \Event::fire('project.created', $project);


        });
        static::updated(function ($project) {


            \Event::fire('project.updated', $project);

        });
    }
    public function region(){
       return $this->hasOne(MetrikaCurrentRegion::class,'neiros_visit','neiros_visit');

    }

    public function widget(){

       return $this->hasOne(Widgets::class,'id','widget_id');
    }
}
