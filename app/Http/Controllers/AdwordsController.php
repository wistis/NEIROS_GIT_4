<?php

namespace App\Http\Controllers;

use App\Models\Adwords\Otchet;
use App\Models\AdwordsLog;
use App\Models\MetricaCurrent;
use App\Models\NeirosUtm;
use App\Models\Servies\CurrencyCurs;
use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Log;
use Symfony\Component\Process\Process;
use Yandex\Direct\Client;
use Yandex\Direct\Credentials;
use Yandex\Direct\Logger\EchoLog;
use Yandex\Direct\Transport\Json\Transport;
use Yandex\OAuth\Exception\AuthRequestException;
use Yandex\OAuth\OAuthClient;
use LaravelGoogleAds\Services\AdWordsService;
use Google\AdsApi\AdWords\AdWordsServices;
use Google\AdsApi\AdWords\AdWordsSessionBuilder;
use Google\AdsApi\AdWords\v201809\cm\CampaignService;
use Google\AdsApi\AdWords\v201809\cm\ReportDefinitionService;
use Google\AdsApi\AdWords\v201809\cm\OrderBy;
use Google\AdsApi\AdWords\v201809\cm\Paging;
use Google\AdsApi\AdWords\v201809\cm\Selector;
use Google\AdsApi\AdWords\v201809\cm\DateRange;
use Google\AdsApi\Common\OAuth2TokenBuilder;
use Google\AdsApi\AdWords\Reporting\v201809\ReportDefinitionDateRangeType;
use Google\AdsApi\AdWords\v201809\cm\Predicate;
use Google\AdsApi\AdWords\v201809\cm\PredicateOperator;
use Google\AdsApi\AdWords\Reporting\v201809\ReportDefinition;
use Google\AdsApi\AdWords\v201809\cm\ReportDefinitionReportType;
use Google\AdsApi\AdWords\Reporting\v201809\DownloadFormat;
use Google\AdsApi\AdWords\Reporting\v201809\ReportDownloader;
use Google\Auth\CredentialsLoader;
use Google\Auth\OAuth2;
use Google\AdsApi\AdWords\ReportSettingsBuilder;
use LaravelGoogleAds\Services\AuthorizationService;
class AdwordsController extends Controller
{
public $log_id;
    protected $authorizationService;
    protected $adWordsService;
    const ADWORDS_API_SCOPE = 'https://www.googleapis.com/auth/adwords';
    /**
     * @var string the OAuth2 scope for the Ad Manger API
     * @see https://developers.google.com/ad-manager/docs/authentication#scope
     */
    const AD_MANAGER_API_SCOPE = 'https://www.googleapis.com/auth/dfp';
    /**
     * @var string the Google OAuth2 authorization URI for OAuth2 requests
     * @see https://developers.google.com/identity/protocols/OAuth2InstalledApp#formingtheurl
     */
    const AUTHORIZATION_URI = 'https://accounts.google.com/o/oauth2/v2/auth';
    /**
     * @var string the redirect URI for OAuth2 installed application flows
     * @see https://developers.google.com/identity/protocols/OAuth2InstalledApp#formingtheurl
     */
    const REDIRECT_URI = 'urn:ietf:wg:oauth:2.0:oob';
    /**
     * @param AdWordsService $adWordsService
     */

    public function __construct(AdWordsService $adWordsService,AuthorizationService $authorizationService)
    {
        $this->adWordsService = $adWordsService;
        $this->authorizationService = $authorizationService;
    }

  /*  public function start(){
        $adid='2582922435';
        $token='4/SgFU7HsSkXNT4lKCzQmqpDy8M9XqsKcN9XCNDLvNixqVt7Hd-pqw9mk';

return $this-> GetRefrech($token ,$adid );
}*/
    public function getCompanyWithoutReport($adId=null ,$widgget_ad=null,$params=null){

        if(($widgget_ad->clientAdId=='')||($widgget_ad->token=='') )
        {
            return '';
        }

        try {
            $oAuth2Credential = (new OAuth2TokenBuilder())
                ->withClientId('928548831727-02q34vlpnvgk59rbvv1s7jdbihai6h2l.apps.googleusercontent.com')
                ->withClientSecret('qNzgzdeQ6I9Oecv9Hi9e-fiP')
                ->withRefreshToken($widgget_ad->token)
                ->build();
            $campaignService = $this->adWordsService->getService(CampaignService::class, $widgget_ad->clientAdId, $oAuth2Credential);
        }catch (\Exception $e){

            return '';
        }
        // Create selector.
        $selector = new Selector();
        $selector->setFields(array('Id', 'Name' ,'ServingStatus','AdvertisingChannelType'));
        $selector->setOrdering(array(new OrderBy('Name', 'ASCENDING')));

        // Create paging controls.
        $selector->setPaging(new Paging(0, 100));

        // Make the get request.
        $page = $campaignService->get($selector);

        $entries=$page->getEntries();

        DB::table('metrika_adwords_company')->where('widget_direct_id', $widgget_ad->id)->delete();

        for($i=0;$i<count($entries);$i++){
            $comp=$entries[$i];
            $prov = DB::table('metrika_adwords_company')->where('widget_direct_id', $widgget_ad->id)->where('company', $comp->getId())->first();
            if (!$prov) {

                $comp1=$comp->getId();
                if(is_array($params)){
                    if(in_array($comp1,$params)){
                        $status=1;
                    }else{
                        $status=0;
                    }


                }else{

                    $status=0;
                }

                DB::table('metrika_adwords_company')->insert([
                    'my_company_id' => $widgget_ad->my_company_id,
                    'site_id' => $widgget_ad->site_id,
                    'widget_id' => $widgget_ad->widget_id,
                    'widget_direct_id' => $widgget_ad->id,
                    'company' =>$comp1,
                    'name' =>$comp->getName(),
                    'Type' => $comp->getAdvertisingChannelType(),
                    'status' => $status


                ]);

            }
        }

       // $this->get_report(3,$widgget_ad,  ReportDefinitionDateRangeType::ALL_TIME,$widgget_ad->my_company_id);

        return 1;
    }

    public function getCompany($adId=null ,$widgget_ad=null){

if(($widgget_ad->clientAdId=='')||($widgget_ad->token=='') )
{
    return '';
}


        $log=new AdwordsLog();
        $log->name='Запуск адвордса директа';
        $log->my_company_id=$widgget_ad->my_company_id;
        $log->save();
        $log->parent_id=$log->id;
        $log->save();
        $this->log_id=$log->id;


try {
    $oAuth2Credential = (new OAuth2TokenBuilder())
        ->withClientId('928548831727-02q34vlpnvgk59rbvv1s7jdbihai6h2l.apps.googleusercontent.com')
        ->withClientSecret('qNzgzdeQ6I9Oecv9Hi9e-fiP')
        ->withRefreshToken($widgget_ad->token)
        ->build();
    $campaignService = $this->adWordsService->getService(CampaignService::class, $widgget_ad->clientAdId, $oAuth2Credential);
}catch (\Exception $e){

    return '';
}
        // Create selector.
        $selector = new Selector();
        $selector->setFields(array('Id', 'Name' ,'ServingStatus','AdvertisingChannelType'));
         $selector->setOrdering(array(new OrderBy('Name', 'ASCENDING')));

        // Create paging controls.
       $selector->setPaging(new Paging(0, 100));

        // Make the get request.
         $page = $campaignService->get($selector);

        $entries=$page->getEntries();

        DB::table('metrika_adwords_company')->where('widget_direct_id', $widgget_ad->id)->delete();

        for($i=0;$i<count($entries);$i++){
$comp=$entries[$i];
            $prov = DB::table('metrika_adwords_company')->where('widget_direct_id', $widgget_ad->id)->where('company', $comp->getId())->first();
            if (!$prov) {
                DB::table('metrika_adwords_company')->insert([
                    'my_company_id' => $widgget_ad->my_company_id,
                    'site_id' => $widgget_ad->site_id,
                    'widget_id' => $widgget_ad->widget_id,
                    'widget_direct_id' => $widgget_ad->id,
                    'company' =>$comp->getId(),
                    'name' =>$comp->getName(),
                    'Type' => $comp->getAdvertisingChannelType(),
                    'status' => 0


                ]);

            }
        }

        $this->get_report(3,$widgget_ad,  ReportDefinitionDateRangeType::ALL_TIME,$widgget_ad->my_company_id);

return 1;
    }





public function get_report($type,$widgget_ad,$date,$my_company_id){
$is_first_otchet=0;
$id_itchet=0;
$first_otchet=\DB::connection('neiros_cloud_adwords')->table('otchet_'.$my_company_id)->where('first_otchet',1)->first();
if(!$first_otchet){

    $is_first_otchet=1;
    $company_my = User::where('my_company_id', $my_company_id)->orderby('id', 'asc')->first();
    $DateFrom = date('Y-m-d', strtotime($company_my->created_at));
    $DateTo = date('Y-m-d', (time() - 86400));
/*INSERT INTO `otchet_59`(`id`, `direct_company_id`, `name`, `status`, `DateFrom`, `DateTo`, `created_at`, `updated_at`, `first_otchet`, `comment`, `site_id`) */
    $id_itchet=\DB::connection('neiros_cloud_adwords')->table('otchet_'.$my_company_id)->insertGetId([
'direct_company_id'=>$widgget_ad->id,
'name'=>'Первый отчет',
'status'=>0,
'DateFrom'=>$DateFrom,
'DateTo'=>$DateTo,
'first_otchet'=>1,
'comment'=>'',


    ])  ;

}elseif($first_otchet->status==0){
    $DateFrom=$first_otchet->DateFrom;
    $DateTo=$first_otchet->DateTo;
    $is_first_otchet=1;
    $id_itchet=$first_otchet->id;


}else{
    $DateFrom=date('Y-m-d');
    $DateTo=date('Y-m-d');
    $is_first_otchet=0;
    $id_itchet=\DB::connection('neiros_cloud_adwords')->table('otchet_'.$my_company_id)->insertGetId([
        'direct_company_id'=>$widgget_ad->id,
        'name'=>'Первый отчет',
        'status'=>0,
        'DateFrom'=>$DateFrom,
        'DateTo'=>$DateTo,
        'first_otchet'=>1,
        'comment'=>'',


    ])  ;


}

   $adId=$widgget_ad->clientAdId ;
    $oAuth2Credential = (new OAuth2TokenBuilder())
        ->withClientId('928548831727-02q34vlpnvgk59rbvv1s7jdbihai6h2l.apps.googleusercontent.com')
        ->withClientSecret('qNzgzdeQ6I9Oecv9Hi9e-fiP')
        ->withRefreshToken( $widgget_ad->token)
        ->build();
    $session = (new AdWordsSessionBuilder())->fromFile()->withOAuth2Credential($oAuth2Credential)->withClientCustomerId($adId)->build();

/*https://github.com/googleads/googleads-php-lib/tree/master/examples*/
/*if($type==1){
    $fields= [
        'CampaignId',
        'CampaignName',
        'Clicks',
        'Cost',
        'Date',

    ];
$stop=true;
    $typereport=ReportDefinitionReportType::CAMPAIGN_PERFORMANCE_REPORT;
     }*/

  /*  if($type==2){$stop=true;
        $fields= [
            'CampaignId',
            'CampaignName',
            'AdGroupId',
            'AdGroupName',
            'Clicks',
            'Cost',
            'Date',

        ];

        $typereport=ReportDefinitionReportType::ADGROUP_PERFORMANCE_REPORT;
    }*/
    if($type==3){$stop=false;
        $fields= [

            'CampaignId',
            'CampaignName',
            'AdGroupId',
            'AdGroupName',
            'AdNetworkType1',
            'AdNetworkType2',
            'Criteria',
            'Clicks',
            'Cost',
            'Date',
            'AccountCurrencyCode',

        ];

        $typereport=ReportDefinitionReportType::KEYWORDS_PERFORMANCE_REPORT;
    }

  /*  if($type==4){$stop=false;
        $fields= [
            'CriteriaId',
            'CriteriaParameters',


        ];

        $typereport=ReportDefinitionReportType::CLICK_PERFORMANCE_REPORT;
    }*/


    // Create selector.
    $selector = new Selector();
    $selector->setFields(
        $fields
    );
    $selector->setDateRange(new DateRange($DateFrom, $DateTo));
    // Use a predicate to filter out paused criteria (this is optional).
  /*  $selector->setPredicates(
        [
            new Predicate('Status', PredicateOperator::NOT_IN, ['PAUSED'])
        ]
    );*/
    // Create report definition.
    $reportDefinition =new ReportDefinition();;
    $reportDefinition->setSelector($selector);
    $reportDefinition->setReportName(
        'Criteria performance report #' . uniqid()
    );
    $reportDefinition->setDateRangeType(
     'CUSTOM_DATE'
    );


    $reportDefinition->setReportType(
        $typereport
    );
    $reportDefinition->setDownloadFormat(DownloadFormat::CSV);
    // Download report.
    $reportDownloader = new ReportDownloader($session);
    // Optional: If you need to adjust report settings just for this one
    // request, you can create and supply the settings override here. Otherwise,
    // default values from the configuration file (adsapi_php.ini) are used.
    $reportSettingsOverride = (new ReportSettingsBuilder())
        ->includeZeroImpressions($stop)
        ->skipReportHeader(true)
        ->skipReportSummary(true)->build();
    $reportDownloadResult = $reportDownloader->downloadReport(
        $reportDefinition,
        $reportSettingsOverride
    );
    $reportDownloadResult->saveToFile(public_path().'/adwordsreport/'.$my_company_id.'_'.$type.'.csv');
    printf(
        "Report with name '%s' was downloaded to '%s'.\n",
        $reportDefinition->getReportName(),
        public_path().'/adwordsreport/'.$my_company_id.'_'.$type.'.csv'
    );


    $log=new AdwordsLog();
    $log->name='Получен отчет импорта директа';
    $log->my_company_id=$my_company_id;
    $log->parent_id=$this->log_id;
    $log->save();

    $this-> parse_report($type,$my_company_id,$widgget_ad,$id_itchet,$is_first_otchet,$DateFrom);
}

    public function set_token()
    {
        $PRODUCTS = [
            ['AdWords API', self::ADWORDS_API_SCOPE],
            ['Ad Manager API', self::AD_MANAGER_API_SCOPE],
            ['AdWords API and Ad Manager API', self::ADWORDS_API_SCOPE  ]
        ];


        $clientId =  '928548831727-02q34vlpnvgk59rbvv1s7jdbihai6h2l.apps.googleusercontent.com';
        $clientSecret='qNzgzdeQ6I9Oecv9Hi9e-fiP';

        $scopes =['https://www.googleapis.com/auth/adwords'];// $PRODUCTS[$api][1] . ' ' . trim(fgets($stdin));
        $authorizationService = $this->authorizationService;

        $oauth2 = $authorizationService->oauth2(
            $clientId,
            $clientSecret,
            AuthorizationService::REDIRECT_URI,
            implode(" ", $scopes)
        );


        $url=$authorizationService->buildFullAuthorizationUri($oauth2, true, [
            'prompt' => 'consent',
        ]);

       $urlka=$url->getscheme().'://accounts.google.com/o/oauth2/v2/auth?'.$url->getQuery();
 return redirect($urlka);
        $code = '4/JgHaQrQmZ6yzy1XZlY4yhoshmwt1X1aOUauMFZC4h7zgrbTrD_zo-EU';

        try {
            $authToken = $authorizationService->fetchAuthToken($oauth2, $code);
        } catch (Exception $exception) {
          dd($code);
        }




    }
    public function GetRefrech($token=null,$adwords=null,$adid)
    {


        $clientId =  '928548831727-02q34vlpnvgk59rbvv1s7jdbihai6h2l.apps.googleusercontent.com';
        $clientSecret='qNzgzdeQ6I9Oecv9Hi9e-fiP';

        $scopes =['https://www.googleapis.com/auth/adwords'];// $PRODUCTS[$api][1] . ' ' . trim(fgets($stdin));
        $authorizationService = $this->authorizationService;

        $oauth2 = $authorizationService->oauth2(
            $clientId,
            $clientSecret,
            AuthorizationService::REDIRECT_URI,
            implode(" ", $scopes)
        );

        $code =urldecode($token);
        $authToken = $authorizationService->fetchAuthToken($oauth2, $code);


       try {

           DB::table('widget_adwords')->where('my_company_id', $adwords->my_company_id)->where('id', $adwords->id)->
           update([
               'clientAdId'=>$adid,
               'token'=>$authToken['refresh_token']
           ]);
      } catch (Exception $exception) {

      }


    }

public function parse_report($type,$my_company_id,$widgget_ad,$id_itchet,$is_first_otchet,$DateFrom){

/*$ot=new Otchet($my_company_id);
    $ot->where('my_company_id',$my_company_id)->delete();*/

if($is_first_otchet==1){
    $ot=new Otchet($my_company_id);
    $ot->where('my_company_id',$my_company_id)->delete();
}else{

    $ot=new Otchet($my_company_id);
    $ot->where('my_company_id',$my_company_id)->where('Date',$DateFrom)->delete();


}

$date_to_metrica=[];


        $file_path=public_path().'/adwordsreport/'.$my_company_id.'_'.$type.'.csv';

    $csv = array_map('str_getcsv', file($file_path));
    $i=0;

    array_walk($csv, function(&$a) use ($csv,$i,$type,$my_company_id) {
     /*   if($type==1) {


            $prow = DB::table('Z_ad_company') ->where('CampaignId', $a[0])->where('Date', $a[4])->first();


            if (!$prow) {
                DB::table('Z_ad_company')->insert([
                    'CampaignId' => $a[0],
                    'CampaignName' => $a[1],
                    'Clicks' => $a[2],
                    'Cost' => $a[3],
                    'Date' => $a[4],


                ]);
            } else {
                DB::table('Z_ad_company')->where('id', $prow->id)->update([
                    'CampaignId' => $a[0],
                    'CampaignName' => $a[1],
                    'Clicks' => $a[2],
                    'Cost' => $a[3],
                    'Date' => $a[4],


                ]);
            }
        }*/
/*Тип 2*/
       /* if($type==2) {


            $prow = DB::table('Z_ad_group') ->where('AdGroupId', $a[2])->where('Date', $a[6])->first();

            if (!$prow) {
                DB::table('Z_ad_group')->insert([
                    'CampaignId' => $a[0],
                    'CampaignName' => $a[1],
                    'AdGroupId' => $a[2],
                    'AdGroupName' => $a[3],
                    'Clicks' => $a[4],
                    'Cost' => $a[5],
                    'Date' => $a[6],


                ]);
            } else {
                DB::table('Z_ad_group')->where('id', $prow->id)->update([
                    'CampaignId' => $a[0],
                    'CampaignName' => $a[1],
                    'AdGroupId' => $a[2],
                    'AdGroupName' => $a[3],
                    'Clicks' => $a[4],
                    'Cost' => $a[5],
                    'Date' => $a[6],


                ]);
            }
        }*/
        if($type==3) {
            if ($a[7] != '') {

                $otchet = new Otchet($my_company_id);
                $date_curs = CurrencyCurs::pluck('curs', 'date');
                $last_curs = CurrencyCurs::orderby('id', 'desc')->first();


                $otchet->CampaignId = $a[0];
                $otchet->CampaignName = $a[1];
                $otchet->AdGroupId = $a[2];
                $otchet->AdGroupName = $a[3];
                $otchet->AdNetworkType1 = $a[4];
                $otchet->AdNetworkType2 = $a[5];
                $otchet->Query = $a[6];
                $otchet->Clicks = $a[7];

                $otchet->Date = $a[9];


                $otchet->my_company_id = $my_company_id;
                if ($a[10] == 'USD') {
                    if (isset($date_curs[$a[9]])) {
                        $otchet->Cost = $a[8] * $date_curs[$a[9]];

                    } else {

                        $otchet->Cost = $a[8] * $last_curs->curs;

                    }
                } else {
                    $otchet->Cost = $a[8];
                }
                $otchet->save();

            }
        }

$i++;;
    });

    $log=new AdwordsLog();
    $log->name='Отчет Спарсили';
    $log->my_company_id=$my_company_id;
    $log->parent_id=$this->log_id;
    $log->save();



    info('M11_'.$my_company_id);
   $this->create_metrika_from_direct($my_company_id,$widgget_ad->site_id,$is_first_otchet,$id_itchet,$DateFrom);
    info('M11END');
}


public function create_metrika_from_direct($my_company_id,$site_id,$is_first_otchet,$id_itchet,$DateFrom){


if($is_first_otchet==1){
    $date= $direct_company_id=DB::connection('neiros_cloud_adwords')->table('adwords_otchet_parcer_'.$my_company_id)->groupby('Date') ->pluck( 'Date');

    }else{
    $date= $direct_company_id=DB::connection('neiros_cloud_adwords')->table('adwords_otchet_parcer_'.$my_company_id)->groupby('Date')->where('Date',$DateFrom) ->pluck( 'Date');

}






    foreach ($date as $key=>$val){



        $get_ids_metrika = NeirosUtm::where('neiros_p0', 'google1')->pluck('neiros_visit');

        $result = DB::connection('neiros_metrica')->table('metrica_' . $my_company_id)
            ->where('site_id', $site_id)->where('reports_date', $val)->where('bot', 0)
            ->where(function ($query) use ($get_ids_metrika) {
                $query->orwherein('neiros_visit', $get_ids_metrika);
                $query->orwhere('typ', 'adwords');

            })
            ->select('typ', 'src', 'cmp',
                DB::raw($this->get_zapros('sdelka')),
                DB::raw($this->get_zapros('lead')),
                DB::raw($this->get_zapros('summ'))

            )->first();


        $cost = DB::connection('neiros_cloud_adwords')->table('adwords_otchet_parcer_' . $my_company_id)->where('Date', $val)->sum('Cost');
        $cost = round($cost / 1000000 * 1.2, 2);

        $Clicks = DB::connection('neiros_cloud_adwords')->table('adwords_otchet_parcer_' . $my_company_id)->where('Date', $val)->sum('Clicks');

        $summ = DB::connection('neiros_metrica')->table('metrica_' . $my_company_id)
            ->where('site_id', $site_id)->where('reports_date', $val)->where('bot', 0)
            ->where('typ', 'payment')->wherein('neiros_visit', $get_ids_metrika)
            ->select(
                DB::raw($this->get_zapros('summ'))

            )->first();
        $supsum = $result->summ;
        if ($summ) {
            $supsum += $summ->summ;
        }


       
        $metrika = new MetricaCurrent();

        $metrika = $metrika->setTable('metrica_' . $my_company_id)->where('reports_date',$val)
        ->where('typ', 'AdwordsApi')->first();

        if($metrika){
            $metrika->setTable('metrica_' . $my_company_id);
             $metrika->sdelka = $result->sdelka;
            $metrika->lead = $result->lead;
            $metrika->summ = $supsum;
             $metrika->cost = $cost;
            $metrika->unique_visit = $Clicks;
            $metrika->save();
        }else {

            $metrika = new MetricaCurrent();

            $metrika = $metrika->setTable('metrica_' . $my_company_id);
            $metrika->key_user = '';
            $metrika->fd = '';
            $metrika->ep = '';
            $metrika->rf = '';
            $metrika->neiros_visit = 0;
            $metrika->typ = 'AdwordsApi';
            $metrika->mdm = '';
            $metrika->src = '';
            $metrika->cmp = '';
            $metrika->cnt = '';
            $metrika->trim = '';
            $metrika->uag = '';
            $metrika->visit = 1;
            $metrika->sdelka = $result->sdelka;
            $metrika->lead = $result->lead;
            $metrika->summ = $supsum;
            $metrika->promocod = '';
            $metrika->_gid = '';
            $metrika->_ym_uid = '';
            $metrika->olev_phone_track = '';
            $metrika->ip = '';
            $metrika->utm_source = '';
            $metrika->site_id = $site_id;
            $metrika->my_company_id = $my_company_id;
            $metrika->reports_date = $val;
            $metrika->updated_at = date('Y-m-d H:i:s');
            $metrika->created_at = date('Y-m-d H:i:s');

            $metrika->bot = 0;
            $metrika->cost = $cost;
            $metrika->unique_visit = $Clicks;
            $metrika->save();
        }

    }

    \DB::connection('neiros_cloud_adwords')->table('otchet_'.$my_company_id)->where('id',$id_itchet)->update(['status'=>1]);

    $log=new AdwordsLog();
    $log->name='Адвордс загружен';
    $log->my_company_id=$my_company_id;
    $log->parent_id=$this->log_id;
    $log->save();




}
    public function get_zapros($pole)
    {
        $text = 'sum(' . $pole . ') as ' . $pole;

        return $text;

    }
}
