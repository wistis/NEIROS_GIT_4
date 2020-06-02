<?php

namespace App\Http\Controllers\Developer;
use App\Http\Controllers\AdwordsController;
use App\Http\Controllers\GoogleUploadController;
use App\Models\WidgetCanal;
use App\Widgets;
use App\Widgets_phone_routing;
use LaravelGoogleAds\Services\AuthorizationService;
use LaravelGoogleAds\Services\AdWordsService;
use App\Http\Controllers\Api\WidgetApiController;
use App\Http\Controllers\DirectController;
use App\Models\MetricaCurrent;
use App\Models\MetrikaCurrentRegion;
use App\Models\NeirosClientId;
use App\Models\NeirosUtm;
use App\Models\SrcCompact;
use App\Project;
use App\Servies\Dadata;
use App\Users_company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function React\Promise\reject;

use League\Flysystem\Filesystem;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter;


use DB;
class ServiesController extends Controller
{
    protected $authorizationService;
    protected $adWordsService;

    public function __construct(AdWordsService $adWordsService,AuthorizationService $authorizationService)
    {
        $this->adWordsService = $adWordsService;
        $this->authorizationService = $authorizationService;

    }
  public function index($id=null){

      switch ($id){
          case 0:
           return   $this->make_controller();

              break;
          case 1:
              return   $this->reprov_lead();

              break;

          case 2:
           return   $this->datata();
              break;
          case 3:
              return   $this->reprow_direct(12,8);
              break;

          case 4:
              return   $this->reprov_crs(40);
              break;
          case 5:
              return   $this->prov_adwords(1062);
              break;



          case 6:
              return   $this->prov_direct(12);
              break;
          case 7:
              return $this->reprt(121);
          case 8:
              return $this->m7();
              case 9:
              return $this->tsv_to_array(public_path().'/directreport_test/2020-03-22-11.tvs');
          case 10:
             $go=new GoogleUploadController();
          return    $go->set_permis();

              break;
      }



  }

  public function m7(){
        $mcompanyid=46;
        $dir=new DirectController();
        $dir->get_companyotchet_new_test();



  }
    function tsv_to_array($file )
    { $args = array();
        $debug = 1;

        //key => default
        $fields = array(
            'header_row' => true,
            'remove_header_row' => true,
            'trim_headers' => true, //trim whitespace around header row values
            'trim_values' => true, //trim whitespace around all non-header row values
            'debug' => false, //set to true while testing if you run into troubles
            'lb' => "\n", //line break character
            'tab' => "\t", //tab character
        );

        foreach ($fields as $key => $default) {
            if (array_key_exists($key, $args)) {
                $$key = $args[$key];
            } else {
                $$key = $default;
            }
        }

        if (!file_exists($file)) {

            $error = 'File does not exist.';
dd($error);
            info($error);
        }

        if ($debug) {
            echo('<p>Opening ' . htmlspecialchars($file) . '&hellip;</p>');
        }
        $data = array();

        if (($handle = fopen($file, 'r')) !== false) {
            $contents = fgets($handle, filesize($file));
            fclose($handle);
        } else {
            echo('There was an error opening the file.');
        }

        $lines = explode($fields['lb'], $contents);
        if ($debug) {
            echo('<p>Reading ' . count($lines) . ' lines&hellip;</p>');
        }

        $row = 1;
        $rowm = -2;
        foreach ($lines as $line) {
            $row++;
            if ($row > 2) {
                $rowm++;
                if (($header_row) && ($row == 2)) {
                    $data['headers'] = array();
                }


                $values = explode($tab, $line);
                foreach ($values as $c => $value) {
                    if (($header_row) && ($row == 3)) { //if this is part of the header row

                        //if (in_array($value,$data['headers'])) { custom_die('There are duplicate values in the header row: '.htmlspecialchars($value).'.'); }

                        if ($trim_headers) {
                            $value = trim($value);
                        }
                        $data['headers'][$c] = $value . ''; //the .'' makes sure it's a string

                    } elseif ($header_row) { //if this isn't part of the header row, but there is a header row


                        $key = $data['headers'][$c];
                        if ($trim_values) {
                            $value = trim($value);
                        }
                        $data[$rowm][$key] = $value;
                    } else { //if there's not a header row at all
                        $data[$rowm][$c] = $value;
                    }
                }
            }

        }

        if ($remove_header_row) {
            unset($data['headers']);
        }

        if ($debug) {
            echo '<pre>' . print_r($data, true) . '</pre>';
        }
 dd( count($data));
        for ($ih = 0; $ih < count($data); $ih++) {


            if (count($data[$ih]) > 3) {

                DB::table('aaaaaa')->insert([
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                    'CampaignId' => $data[$ih]['CampaignId'],
                    'CampaignName' => $data[$ih]['CampaignName'],
                    'AdGroupId' => $data[$ih]['AdGroupId'],
                    'AdGroupName' => $data[$ih]['AdGroupName'],
                    'Query' => explode('-', $data[$ih]['Criteria'])[0],
                    'Criteria' => $data[$ih]['Criteria'],
                    'Bounces' => $data[$ih]['Bounces'],
                    'Clicks' => $data[$ih]['Clicks'],
                    'Impressions' => $data[$ih]['Impressions'],
                    'Placement' => $data[$ih]['Placement'],
                    'AdId' => $data[$ih]['AdId'],
                    'AdNetworkType' => $data[$ih]['AdNetworkType'],


                    'Cost' => $data[$ih]['Cost'],
                    'Date' => $data[$ih]['Date'],
                    'my_company_id' => 0,
                    'otchet' => 0,

                ]);

            }

        }


        //return $data;
    }
  public function reprt($id){
    /*  $rout = Widgets_phone_routing::where('id', $id)->with('phones') ->first();
dd(1);
foreach ($rout->phones as $item){
 $canal=WidgetCanal::wherein('id', $rout->canals)->first();
 $code=$canal->code;
 ; dd($code,$item->input);
$projects=Project::where('my_company_id',$rout->my_company_id) ->get();
 foreach ($projects as $project){
$prov_met=\DB::connection('neiros_metrica')->table('metrica_'.$rout->my_company_id)->where('neiros_visit',$project->neiros_visit)->where('project_id',$project->id)->first();
 if(!$prov_met){


 }



 }
$r= \DB::connection('neiros_metrica')->table('metrica_'.$rout->my_company_id)->get();



}*/
      $rout = Widgets_phone_routing::where('id', $id)->with('phones') ->first();
      $prov_met=\DB::connection('neiros_metrica')->table('metrica_'.$rout->my_company_id)->update(['sdelka'=>1]);

  }
public function prov_adwords($id){

    $adw=new AdwordsController($this->adWordsService, $this->authorizationService);
    $widgets=Widgets::where('tip',20) ->with('w20')->where('status',1)->where('id',$id)->first();

    $adw->getCompany('',$widgets->w20);


}
  function prov_direct(){
/*$comp=Users_company::get();
     foreach ($comp as $item) {
        try {
            DB::connection('neiros_direct1')->table('direct_otchet_parcer_' . $item->id)->truncate();
            DB::connection('neiros_direct1')->table('direct_otchet_' . $item->id)->truncate();
        }catch (\Exception $e){

        }
      }

exit();*/
//widget_direct 44
$id=12
;      $DirectController=new DirectController();

      try {


          $DirectController->get_companyotchet_new_1($id);

      }catch (\Exception $e){
       dd($e);
      }

dd(2);
      try {

          info('starts');
          info($id);
          $DirectController->uploadfile($id);

      }catch (\Exception $e){
         dd($e);
      }

  }

function clear_direct($my_company_id){





}
public function reprov_crs($my_company_id){
$cop=Users_company::get();
foreach ($cop as $co) {


    try {
        DB::connection('neiros_metrica')->raw("update `metrica_".$co->id."` set `osn_typ2`=`typ`");

    }catch (\Exception $e){

    }

    $get = SrcCompact::get();
    foreach ($get as $item) {

        try {



            if($item->typ==1){
                $typ='organic';
                DB::connection('neiros_metrica')->table('metrica_' . $co->id)->where('src', $item->src)->update([

                    'src' => $item->name,
                    'typ' => $typ,
                ]);
            }else{
                DB::connection('neiros_metrica')->table('metrica_' . $co->id)->where('src', $item->src)->update([

                    'src' => $item->name
                ]);
            }

        }catch (\Exception $e){

        }

    }


}



}

    public function reprow_direct($my_company_id,$site_id){
        $dates= \DB::connection('neiros_direct1')->table('direct_otchet_parcer_'.$my_company_id)->groupby('Date') ->pluck( 'Date');
     foreach ($dates as $key=>$val){
        /* $direct_company_id=DB::connection('neiros_direct')->table('direct_otchet_parcer_'.$my_company_id)->where('Date',$val)->distinct('CampaignId')->pluck( 'CampaignId');*/
         $get_ids_metrika=NeirosUtm::where('neiros_p0','direct1')->pluck('neiros_visit');

         $result = DB::connection('neiros_metrica')->table('metrica_'.$my_company_id)
             ->where('site_id', $site_id)->where('reports_date', $val)->where('bot', 0)
             ->where(function ($query) use ($get_ids_metrika){
                 $query->orwherein('neiros_visit',$get_ids_metrika);
                 $query->orwhere('typ','direct','payment');

             })
             ->select('typ', 'src','cmp',
                 DB::raw($this->get_zapros('sdelka')  ),
                 DB::raw( $this ->get_zapros('lead')),
                 DB::raw( $this->get_zapros('summ')),
                 DB::raw('count(DISTINCT(src)) as count_group')
             )->first() ;






         $cost= DB::connection('neiros_direct1')->table('direct_otchet_parcer_'.$my_company_id)->where('Date',$val) ->sum( 'Cost');
         $cost=round($cost / 1000000*1.2, 2);

         $Clicks= DB::connection('neiros_direct1')->table('direct_otchet_parcer_'.$my_company_id)->where('Date',$val) ->sum( 'Clicks');



         $metrika = new MetricaCurrent();

         $metrika=$metrika->setTable('metrica_' . $my_company_id);
         $metrika->key_user = '';
         $metrika->fd = '';
         $metrika->ep = '';
         $metrika->rf = '';
         $metrika ->neiros_visit = 0;
         $metrika->typ = 'Директ';
         $metrika->mdm ='';
         $metrika->src = '';
         $metrika->cmp = '';
         $metrika->cnt = '';
         $metrika->trim = '';
         $metrika->uag = '';
         $metrika->visit =1;
         $metrika->sdelka =$result->sdelka;
         $metrika->lead =$result->lead;
         $metrika->summ =$result->summ;
         $metrika->promocod ='';
         $metrika->_gid = '';
         $metrika->_ym_uid ='';
         $metrika->olev_phone_track ='';
         $metrika->ip ='';
         $metrika->utm_source = '';
         $metrika-> site_id=$site_id;
         $metrika-> my_company_id= $my_company_id;
         $metrika->reports_date =$val;
         $metrika->updated_at = date('Y-m-d H:i:s');
         $metrika->created_at = date('Y-m-d H:i:s');

         $metrika->bot = 0;
         $metrika->cost=$cost;
         $metrika->unique_visit=$Clicks;
         $metrika->save();



     }





    }

    public function get_zapros($pole)
    {
        $text = 'sum(' . $pole . ') as ' . $pole;

        return $text;

    }

    public function datata(){

    $dadata = new Dadata("e07930f5614b8f86f5699f4e631b02f8dd59c635");
    $dadata->init();








    $result = $dadata->iplocate('46.226.227.20');
dd($result);

}
  public function reprov_lead(){
      $projects=Project::whereNULL('ncl_id')->get();


      $wpapi=new WidgetApiController();

      foreach ($projects as $project){

$data=[];
$data['phone']=$project->phone;
$data['email']=$project->email;

          $ncl_id=$wpapi->get_ncl_id($project->my_company_id,$data,$project->neiros_visit,$project->site_id);
$project->ncl_id=$ncl_id;
$project->save();
          NeirosClientId::updatedata($project->id);
      }


  }

  public function make_controller(){



      if(\request()->method()=='POST'){

\Artisan::call('make:controller',['name'=>\request()->get('name')]);

session()->flash('success');
return redirect()->back();
      }



      return view("developer.make_controller");


  }
}
