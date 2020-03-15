<?php

namespace App\Models;

use App\Project;
use Illuminate\Database\Eloquent\Model;

class NeirosClientId extends Model
{
    /**
     * An Eloquent Model: 'NeirosClientId'
     *
     * @property integer $id
     * @property integer $ncl_id
     * @property string $dvalue

     */

    protected $table='neiros_client_id';

    public  static function updatedata($project_1){
     $project=Project::find($project_1);



$datfor=[];
        if(strlen($project->email)>3) {
            $datfor[]=$project->email;
        }
        if(strlen($project->phone)>5) {
            $datfor[]=$project->phone;
        }
        if($project->neiros_visit>0) {
            $datfor[]=$project->neiros_visit;
        }


       foreach($datfor as $key=>$val){
           info('WID@'.$val);
            $ser = NeirosClientId::where('dvalue',$val)->where('ncl_id', $project->ncl_id)->first();
            if (!$ser) {
                $ser=new NeirosClientId();
                $ser->ncl_id=$project->ncl_id;
                $ser->dvalue=$val;
                $ser->my_company_id=$project->my_company_id;
                $ser->save();
            }

        }





    }
}
