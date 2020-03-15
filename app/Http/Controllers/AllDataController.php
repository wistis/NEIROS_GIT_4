<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Log;
use Datatables;

class AllDataController extends Controller
{
    public function index()
    {

return view('projects.list_table_new');


   }
   public function anyData(){

       $user=Auth::user();
     $info= DB::table('projects')
           ->join('widgets','widgets.id','=','projects.widget_id')
           ->where('projects.my_company_id',$user->my_company_id)


         ->select('projects.phone as projects_phone'
             ,'projects.email as projects_email'
             ,'projects.id as projects_id'
             ,'projects.created_at as projects_created_at'
             ,'projects.fio as projects_fio'
             ,'projects.vst as projects_vst'
             ,'projects.pgs as projects_pgs'
             ,'projects.url as projects_url'


          ,'widgets.name as widgets_name'






         );



       return Datatables::queryBuilder($info)->make(true);

   }
   public  function show(){

   }
}
