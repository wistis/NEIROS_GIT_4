<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class SimpleAdController extends Controller
{
   public function index($type){
       if($type==1){
           $fields= [
               'CampaignId',
               'CampaignName',
               'Clicks',
               'Cost',
               'Date',

           ];
         $table='Z_ad_company';
       }

       if($type==2){
           $fields= [
               'CampaignId',
               'CampaignName',
               'AdGroupId',
               'AdGroupName',
               'Clicks',
               'Cost',
               'Date',

           ];

          $table='Z_ad_group';
       }
       if($type==3){$stop=false;
           $fields= [
               'CampaignId',
               'AdGroupId',
               'Query',
               'Clicks',
               'Cost',
               'Date',

           ];

           $table='Z_ad_query';
       }
$min_date=DB::table($table)->orderby('Date','asc')->min('Date');
$max_date=DB::table($table)->orderby('Date','asc')->max('Date');

$results=DB::table($table)->orderby('Date','asc')->get();

       return view('sad.'.$type,compact('results','max_date','min_date'));

   }
}
