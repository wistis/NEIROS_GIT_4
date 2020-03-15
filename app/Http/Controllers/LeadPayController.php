<?php

namespace App\Http\Controllers;

use App\Models\MetricaCurrent;
use Illuminate\Http\Request;

class LeadPayController extends Controller
{
    public static function createPayment($project){


        $metrika = new MetricaCurrent();
        $metrika->setTable('metrica_' . $project->my_company_id);
        $metrika->key_user = '';
        $metrika->fd = '';
        $metrika->ep = '';
        $metrika->rf = '';
        $metrika->neiros_visit = $project->neiros_visit;
        $metrika->typ = 'payment';
        $metrika->mdm ='';
        $metrika->src = '';
        $metrika->project_id = $project->id;
        $metrika->summ = $project->summ;
        $metrika->lead = 1;
        $metrika->cmp = '';
        $metrika->cnt = '';
        $metrika->trim = '';
        $metrika->uag = '';
        $metrika->visit =1;
        $metrika->promocod ='';
        $metrika->_gid = '';
        $metrika->_ym_uid ='';
        $metrika->olev_phone_track ='';
        $metrika->ip ='';
        $metrika->utm_source = '';
        $metrika->my_company_id =$project->my_company_id;
        $metrika->site_id = $project->site_id;
        $metrika->reports_date =$project->reports_date;
        $metrika->updated_at = date('Y-m-d H:i:s');
        $metrika->created_at = date('Y-m-d H:i:s');

        $metrika->bot = 0;
        $metrika->save();


info(json_encode($metrika));
    }
}
