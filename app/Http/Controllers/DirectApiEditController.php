<?php

namespace App\Http\Controllers;

use App\Models\MetricaCurrent;
use Biplane\YandexDirect\Api\V4\Contract\Sitelink;
use Biplane\YandexDirect\Api\V5\Contract\AddSitelinksRequest;
use Biplane\YandexDirect\Api\V5\Contract\GetSitelinksRequest;
use Biplane\YandexDirect\Api\V5\Contract\IdsCriteria;
use Biplane\YandexDirect\Api\V5\Contract\SitelinkFieldEnum;
use Biplane\YandexDirect\Api\V5\Contract\SitelinksSetAddItem;
use Biplane\YandexDirect\Api\V5\Contract\SitelinksSetFieldEnum;
use Biplane\YandexDirect\Api\V5\Contract\TextAdFieldEnum;
use Biplane\YandexDirect\Api\V5\Contract\UpdateAdsRequest;
use Illuminate\Http\Request;
use Biplane\YandexDirect\Api\V5\Contract\AdFieldEnum;
use Biplane\YandexDirect\Api\V5\Contract\AdsSelectionCriteria;
use Biplane\YandexDirect\Api\V5\Contract\GetAdsRequest;
use Biplane\YandexDirect\Api\V5\Contract\StateEnum;
use Biplane\YandexDirect\User;
use DB;
use PDO;
 ;
class DirectApiEditController extends Controller
{
    public function index($company=null,$token=null,$email=null){
$response_update=[];
$z=0;

     /* $metricas=DB::table('metrika_current') ->where('uploaded',0)->whereNotNull('my_company_id')->take(100000)->get();
      foreach ($metricas as $item){
          if(is_numeric($item->my_company_id)) {
              $array= (array)$item;
              unset($array['id']);
              DB::connection('neiros_metrica')->table('metrica_' . $item->my_company_id)->insert(
                  $array

              );
          }
          DB::table('metrika_current')->where('id',$item->id)->update(['uploaded'=>1]);
      }*/
 

       /* $company=DB::table('metrika_direct_company')->where('widget_direct_id', 42)->where('status',1)->pluck('company')->toArray();*/
       // $tok=  DB::table('widget_direct') ->where('id', 42)->first();
$token=$token;
$email1=explode('@',$email);
        $user = new User([
            'access_token' => $token,
            'login' =>  $email1[0],
            'locale' => User::LOCALE_RU,
        ]);

        $criteria = AdsSelectionCriteria::create()
            ->setCampaignIds($company)
            /*->setStates([
                StateEnum::ON,
            ])*/;


        $payload = GetAdsRequest::create()
            ->setSelectionCriteria($criteria)
            ->setFieldNames([
                AdFieldEnum::AD_CATEGORIES,
                AdFieldEnum::AGE_LABEL,
                AdFieldEnum::AD_GROUP_ID,
                AdFieldEnum::ID,
                AdFieldEnum::STATUS,
                AdFieldEnum::TYPE,


            ])->setTextAdFieldNames(    [TextAdFieldEnum::HREF,TextAdFieldEnum::SITELINK_SET_ID]);

        $response = $user->getAdsService()->get($payload);
$array_to_json=[];$i=0;
        foreach ($response->getAds() as $ad) {



            $tupe = $ad->getType();
if($tupe=='TEXT_AD'){
$has_nairos=0;


$fast=$ad->getTextAd()->getSitelinkSetId();
$data_site_link=[];
$linck_id_res=0;
if(!is_null($fast)){

    $crt=IdsCriteria::create()->setIds([$fast]);
    ;$payload_sitelink=GetSitelinksRequest::create()->setSelectionCriteria($crt)->setFieldNames([
        SitelinksSetFieldEnum::ID,




    ])->setSitelinkFieldNames([ SitelinkFieldEnum::DESCRIPTION,
        SitelinkFieldEnum::HREF,
        SitelinkFieldEnum::TITLE,
        SitelinkFieldEnum::TURBO_PAGE_ID,]);

    $fastlinc_response=$user->getSitelinksService()->get($payload_sitelink) ;
$collectsitelink=$fastlinc_response->getSitelinksSets();;$mss=0;
foreach ($collectsitelink as $collink){
    $id=$collink->getId();
    $data_array=$collink->getSitelinks();
    for($iss=0;$iss<count($data_array);$iss++){

$prov_nairps=$this->create_url_with_neiros($data_array[$iss]->getHref());
if($prov_nairps['has_nairos']==0){

    $data_site_link['Sitelinks'][$mss]['Title']=$data_array[$iss]->getTitle();
    $data_site_link ['Sitelinks'][$mss]['Href']=$prov_nairps['new_url'];
    $data_site_link ['Sitelinks'][$mss]['Description']=$data_array[$iss]->getDescription();
    $data_site_link ['Sitelinks'][$mss]['TurboPageId']=$data_array[$iss]->getTurboPageId();
$mss++;
}


    }

}
if(count($data_site_link)>0){


    $create_site_linc=  AddSitelinksRequest::create()->setSitelinksSets($data_site_link);



try {
    $response = $user->getSitelinksService()->add($create_site_linc);/*dd($response);*/

    $linck_id_res = $response->getAddResults()[0]->getId();
}catch (\Exception $e){

}



}


}

    $old_url  = $ad->getTextAd()->getHref();

            $id = $ad->getId();

            $neiros_utm['neiros'] = 'direct1_{source_type}_{campaign_id}_{ad_id}_{keyword}';
            $neiros_utm['neiros_referrer'] = '{source}';
            $neiros_utm['neiros_position'] = '{position_type}_{position}';


            $url_get = explode('?', $old_url);

            if (count($url_get) == 1) {
                $text_to_url = '';
                foreach ($neiros_utm AS $key1 => $value) {
                    $text_to_url .= '&' . $key1 . '=' . $value;
                }

                /*В ссылке нет параметров*/
                $new_url = $old_url . '?' . trim($text_to_url, '&');

                /*В ссылке нет параметров*/

            }
            else
                {
                /*В ссылке есть параметры*/

                $url_start = $url_get[0];//До знака вопрос
                parse_str($url_get[1], $output);
                foreach ($output as $key => $val) {

                    if ($key == 'neiros') {
                        $has_nairos=1;
                        $val = $neiros_utm['neiros'];
                    }
                    if ($key == 'neiros_referrer') {
                        $val = $neiros_utm['neiros_referrer'];
                        $has_nairos=1;
                    }
                    if ($key == 'neiros_position') {
                        $val = $neiros_utm['neiros_position'];
                        $has_nairos=1;
                    }
                    $neiros_utm[$key] = $val;



                $text_to_url = '';
                foreach ($neiros_utm AS $key1 => $value) {
                    $text_to_url .= '&' . $key1 . '=' . $value;
                }
                $new_url = $url_start . '?' . trim($text_to_url, '&') . '';


            }
            }
            if( $has_nairos==0){
                $array_to_json[$i]['Id'] = $id;

            $array_to_json[$i]['TextAd']['Href'] = $new_url;

                if($linck_id_res>0){
                    $array_to_json[$i]['TextAd']['SitelinkSetId']=$linck_id_res;
                }

                $i++;$z++;
            }else{
                if($linck_id_res>0){
                    $array_to_json[$i]['Id'] = $id;
                    $array_to_json[$i]['TextAd']['SitelinkSetId']=$linck_id_res;
                    $i++;$z++;
                }
            }
;


            if ($i == 1000) {

                $response_update[]= $this->send_to_direct($array_to_json, $user);
                $array_to_json = [];
                $i = 0;
            }
        }else{

}
        }
        if(count($array_to_json)>0) {

            $response_update[]=   $this->send_to_direct($array_to_json, $user);
        }
        info(json_encode($response_update));
 return $z;
    }

    public function create_url_with_neiros($old_url){

$data['has_nairos']=0;$has_nairos=0;
        $neiros_utm['neiros'] = 'direct1_{source_type}_{campaign_id}_{ad_id}_{keyword}';
        $neiros_utm['neiros_referrer'] = '{source}';
        $neiros_utm['neiros_position'] = '{position_type}_{position}';


        $url_get = explode('?', $old_url);

        if (count($url_get) == 1) {
            $text_to_url = '';
            foreach ($neiros_utm AS $key1 => $value) {
                $text_to_url .= '&' . $key1 . '=' . $value;
            }

            /*В ссылке нет параметров*/
            $new_url = $old_url . '?' . trim($text_to_url, '&');

            /*В ссылке нет параметров*/

        } else {
            /*В ссылке есть параметры*/

            $url_start = $url_get[0];//До знака вопрос
            parse_str($url_get[1], $output);
            foreach ($output as $key => $val) {

                if ($key == 'neiros') {
                    $has_nairos=1;
                    $val = $neiros_utm['neiros'];
                }
                if ($key == 'neiros_referrer') {
                    $val = $neiros_utm['neiros_referrer'];
                    $has_nairos=1;
                }
                if ($key == 'neiros_position') {
                    $val = $neiros_utm['neiros_position'];
                    $has_nairos=1;
                }
                $neiros_utm[$key] = $val;



                $text_to_url = '';
                foreach ($neiros_utm AS $key1 => $value) {
                    $text_to_url .= '&' . $key1 . '=' . $value;
                }
                $new_url = $url_start . '?' . trim($text_to_url, '&') . '';


            }
        }


        $data['has_nairos']=$has_nairos;
        $data['new_url']=$new_url;
return $data;


}

    public function send_to_direct($array_to_json,$user){




        $adupdate=UpdateAdsRequest::create()->setAds($array_to_json);



     return   $response = $user->getAdsService()->update($adupdate);/*dd($response);*/

    }
}
