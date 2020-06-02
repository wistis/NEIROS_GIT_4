<?php

namespace App;

use App\Models\Call\BayPhone;
use App\Models\Servies\GroupRoles;
use App\Models\Servies\UsersGroup;
use App\Models\Settings\CompanyDefaultSetting;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     * @var email
     * @var site
     * `id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `project_vid`, `task_vid`, `my_company_id`, `site`, `start_date`, `end_date`, `stat_start_date`, `stat_end_date`, `apikey`, `super_admin`, `tarif`, `admin_id`, `phone`, `chat_audio`, `users_push`, `last_report`, `selected_chat`, `test_period`, `is_active`, `operator`, `sms_code`, `time_sms`, `amount_sms`
     */

    protected $fillable = [
        'name', 'email', 'password' ,'role','my_company_id','apikey','my_company_id','apikey','start_date','end_date','stat_start_date','stat_end_date','phone','test_period','is_active','sms_code','users_group_id'
        ,'time_sms','amount_sms','is_first_reg','partner_id','tarif'

             
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getMyCompany(){
return $this->hasOne(Users_company::class,'id','my_company_id');
    }

    public function getroles()
    {
        return $this->hasMany('App\User_roles','user_id','id');
    }
    public function getcompany()
    {
        return $this->hasOne('App\Users_company','id','my_company_id');
    }
    public function getNumbers(){

        return $this->hasMany(BayPhone::class,'my_company_id','my_company_id');
    }

    public function getNumbersActive(){
return $this->getNumbers()->where('was_deleted',0)->count();

    }
public function getSites(){

        return $this->hasMany(Sites::class,'my_company_id','my_company_id');
}
    public function get_site()
    {
        return $this->belongsTo('App\Sites','site');
    }
    public function get_site_()
    {
        return Sites::find($this->site);
    }




    public function getglobalsetting()
    {
        return $this->hasMany('App\Models\Settings\CompanyDefaultSetting','my_company_id','my_company_id');
    }


    public function getglsetvithinstall($skey,$value=null){



        $mcomset=CompanyDefaultSetting::where('my_company_id',auth()->user()->my_company_id)->where('skey',$skey)->first();




        if($mcomset){
           if(!is_null($value)){
               $mcomset->value=$value;
               $mcomset->save();
           }

        }else {

            $mcomset = new CompanyDefaultSetting();
            $mcomset->skey = $skey;//$skey'catch_who_man_wooman';
            if(!is_null($value)) {
                $mcomset->value = $value;
            }else{
                $mcomset->value = 0;
            }

            $mcomset->my_company_id = auth()->user()->my_company_id;
            $mcomset->comment = '';//'Мужской или женский голос';
            $mcomset->save();

        }
return $mcomset->value;

    }




    public function groups()
    {
        return $this->belongsToMany(UsersGroup::class,'group_user','user_id','group_id');
    }
    public function grouproles()
    {
        return $this->belongsToMany(GroupRoles::class,'group_role_user','user_id','group_id');
    }
public function is_operator(){

    $user=$this->load('grouproles')->grouproles->wherein('id',[0,1])->first() ; 
    if($user){

        return false;
    }

    $user=$this->load('grouproles')->grouproles->wherein('id',[2])->first() ;
    if($user){

        return true;
    }

}
    public function grouproles_prov($role){

        $user=$this->load('grouproles')->grouproles->pluck('id')->toArray();
       if(in_array($role,$user)){

            return true;
        }
        return false;
    }

    public function partners(){

        return $this->hasMany(User::class,'partner_id','id');

    }

}
