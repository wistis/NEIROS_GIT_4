<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Api\WidgetApiController;
use App\Models\Servies\ALpParam;
use App\Models\Vk\WidgetVk;
use App\Models\Vk\WidgetVkPage;
use App\Sites;
use App\Widgets;
use InstagramAPI\Request\Location;
use Log;
use DB;
use App\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\VkApi\VkApiController as Vk_Api;
use App\Http\Controllers\VkApi\VkApiGlobalController ;
use App\Http\Controllers\VkApi\VkBotGlobalController ;
use ElephantIO\Client as Clcl;
use ElephantIO\Engine\SocketIO\Version2X;
use VK\Actions\Pages;

class VkApiController extends Controller
{

    public function sendvk_from_neiros(){
        $data=request()->all();
       $npl=ALpParam::where('utm',$data['m'])->where('vk_group_id',$data['group_id'])->first();
       if(!$npl){
           return abort(404);
       }




$group=WidgetVkPage::where('vk_id',$data['group_id'])->first();

        $vk = new \VK\Client\VKApiClient();

        /*docs.getMessagesUploadServer*/

          $response = $vk->messages()->send($group->token, array(
              'peer_id' => $data['user_id'],
              'message' => $npl->mess. '',
              'random_id' =>rand(1,1000000000),

          ));
        $response = $vk->messages()->send($group->token, array(
            'peer_id' => $data['user_id'],
            'message' => '('.$npl->url_name.')<br>'.$npl->url,
            'random_id' =>rand(1,1000000000),

        ));

       /* "m" => "nlp1"
  "user_id" => "14513937"
  "group_id" => "195415914"*/
    }


    public static function adcallbackserver($group,$token){
        $widget= auth()->user()->get_site ->get_widget_on(4)->w4;

        $vkps=WidgetVkPage::where('vk_id',$group)->first();
        if($vkps->server_id!=''){
        $vk = new \VK\Client\VKApiClient();
            $response = $vk->groups()->deleteCallbackServer($token, array(
                'group_id' =>$group,
                'server_id' =>(int)$vkps->server_id,

            ));

        }
            $vk = new \VK\Client\VKApiClient();
            $response = $vk->groups()->addCallbackServer($token, array(
                'group_id' =>$group,
                'title' =>'Neiros',
                'url' =>'https://cloud.neiros.ru/api/vkapi/callback_handleEvent/'. auth()->user()->get_site->hash,


            ));
            $vkps=WidgetVkPage::where('vk_id',$group)->first();
            if($vkps){ $vkps->server_id=$response['server_id'];
                $vkps->save();
            }




        $response = $vk->groups()->setCallbackSettings($token, array(
            'group_id' =>$group,
            'server_id' =>$response['server_id'],
            'message_new' =>1,



        ));


    }

    public static function vkgrouptokens($request){
        $vk = new \VK\Client\VKApiClient();
      $data=$request->all();
        $groups=    WidgetVkPage::
        where('site_id',auth()->user()->get_site->id)
            ->pluck('vk_id')->toArray();
        foreach ($data as $key=>$val){
            $m=explode('_',$key);
            if(count($m)==3){
                $roups=    WidgetVkPage::
                where('site_id',auth()->user()->get_site->id)
                    ->where('vk_id',$m[2])->first();
                if($roups){

                    $roups->token=$val;


                    $response = $vk->groups()-> getCallbackConfirmationCode($val, array(
                        'group_id' =>$m[2],




                    ));
                    $roups->confirmation=$response['code'];
                    $roups->save();

                    VkApiController::adcallbackserver($m[2],$val);
                }







            }



        }

    }
    public function getkeygroup(){




return view('widgets.render.integration.vk_modal');
    }
public static function get_group_otcken(){

    $groups=    WidgetVkPage::
    where('site_id',auth()->user()->get_site->id)->where('status',1)
       ->pluck('vk_id')->toArray();
   if(count($groups)>0) {
       $oauth = new \VK\OAuth\VKOAuth();
       $client_id = env('VK_APP_ID');;
       $redirect_uri = 'https://cloud.neiros.ru/vkapi/getkeygroup';
       $display = \VK\OAuth\VKOAuthDisplay::PAGE;
       $scope = array(\VK\OAuth\Scopes\VKOAuthGroupScope::MESSAGES, \VK\OAuth\Scopes\VKOAuthGroupScope::MANAGE);
       $state = 'secret_state_code';
       $groups_ids = $groups;

       $browser_url = $oauth->getAuthorizeUrl(\VK\OAuth\VKOAuthResponseType::TOKEN, $client_id, $redirect_uri, $display, $scope, $state, $groups_ids);

       return '<a href="' . htmlspecialchars($browser_url) . '" class="btn  " style="background: #4267B2;color: white;font-weight: bold" target="_parent">Подключить группы</a>';
   }
}
    public static function safe_groups($groups){
        $widget= auth()->user()->get_site ->get_widget_on(4)->w4;
    $unchecks=    WidgetVkPage::
        where('site_id',auth()->user()->get_site->id)
            -> whereNOTIn('vk_id', $groups)->get();
foreach ($unchecks as $uncheck){
    $uncheck->status=0;
    $uncheck->token='';
    $uncheck->save();
}
        $unchecks=    WidgetVkPage::
        where('site_id',auth()->user()->get_site->id)
            -> whereIn('vk_id', $groups)->get();
foreach ($unchecks as $uncheck){
    $uncheck->status=1;

    $uncheck->save();
}


return VkApiController::get_group_otcken();
    }

    public function getkey(){
        $widget= auth()->user()->get_site ->get_widget_on(4)->w4;

        $oauth = new \VK\OAuth\VKOAuth();
        $client_id = env('VK_APP_ID');
        $client_secret =env('VK_APP_KEY');
        $redirect_uri = 'https://cloud.neiros.ru/vkapi/getkey';
        $code = request()->get('code');

        try {
                $response = $oauth->getAccessToken($client_id, $client_secret, $redirect_uri, $code);
        }catch (\VK\Exceptions\VKClientException $e){
 ;
        }

        $access_token = $response['access_token'];

        $widget= auth()->user()->get_site ->get_widget_on(4)->w4;

    $widget->vk_id=$response['user_id'];
    $widget->token=$access_token ;
    $widget->save();

$this->get_pages_from_token($widget);

        session()->flash('vk_sucess');

return redirect('/widget/tip/10');
    }

    public function get_pages_from_token  ($widget)
    {

        $vk = new \VK\Client\VKApiClient();
        $response = $vk->groups()->get($widget->token, array(
            'user_ids' => $widget->vk_id,

            'filter' => array('admin'),
        ));

        if($response['count']>0){
            WidgetVkPage::
            where('site_id',auth()->user()->get_site->id)
           -> whereNOTIn('vk_id', $response['items'])

                ->delete();
            for ($i = 0; $i < count($response['items']); $i++) {
$prov=WidgetVkPage:: where('site_id',auth()->user()->get_site->id)
    -> where ('vk_id', $response['items'][$i])->first();

if(!$prov) {
    $model = new WidgetVkPage();
    $model->widget_vk_id = $widget->id;
    $model->my_company_id = $widget->my_company_id;
    $model->site_id = auth()->user()->get_site->id;
    $model->vk_id = $response['items'][$i];
    $model->token = '';

    $model->name = '';
    $model->status =0;
    try {


    } catch (\Exception $e) {

    }


    $model->save();
}


            }
            /*$w=Widgets::find($widget->widget_id);
            $w->status=1;
            $w->save();*/



            $vk = new \VK\Client\VKApiClient();
            $response = $vk->groups()->getById(env('VK_APP_SER_KEY'), array(
                'group_ids' => $response['items'],
                'fields' => ['name','is_admin'],
                'filter' => array('admin',  'moder'),
            ));
for($i=0;$i<count($response);$i++){
    $model =  WidgetVkPage::where('site_id',auth()->user()->get_site->id)->where('vk_id',$response[$i]['id'])->first();
    if($model){
        $model->name= $response [$i]['name'];
        $model->save();
    }

}



        }


    }

    public static  function get_url_for_token(){/*получим токен контакта*/
        $oauth = new \VK\OAuth\VKOAuth();
        $client_id = env('VK_APP_ID');
        $redirect_uri = 'https://cloud.neiros.ru/vkapi/getkey';
        $display = \VK\OAuth\VKOAuthDisplay::PAGE;
        $scope = array(\VK\OAuth\Scopes\VKOAuthUserScope::WALL, \VK\OAuth\Scopes\VKOAuthUserScope::GROUPS,
            \VK\OAuth\Scopes\VKOAuthUserScope::OFFLINE);
        $state = 'secret_state_code';
        $browser_url = $oauth->getAuthorizeUrl (\VK\OAuth\VKOAuthResponseType::CODE, $client_id, $redirect_uri, $display, $scope, $state);
        return  '<a href="' . htmlspecialchars($browser_url) . '" class="btn  " style="background: #4267B2;color: white;font-weight: bold" target="_blank">Продолжить с ВКОНТАКТЕ</a>';
    }




    /*https://cloud.neiros.ru/api/vkapi/callback_handleEvent/{{$sites->hash}}*/
    public function vk_6(){
     return redirect('/');
    }
    public function vk_5(){
    $vk = new \VK\Client\VKApiClient();
    $response = $vk->messages()->send('48525770fd7bde11299a63ec91dfaa6a9bef5589ad26044618d2a12e887921d33fcf6fcc8fb0e87f66dd2', array(
        'peer_id' => '14513937',
        'message' => 'qwqeqweqweqwe',
        'random_id' =>rand(1,1000000000),

    ));


/*48525770fd7bde11299a63ec91dfaa6a9bef5589ad26044618d2a12e887921d33fcf6fcc8fb0e87f66dd2*/
}
    public function vk_4(){

    }



    public function new_vk(){







    }
    public function new_vk_group(){
        $vk = new \VK\Client\VKApiClient();
        $oauth = new \VK\OAuth\VKOAuth();
        $client_id = env('VK_APP_ID');
        $redirect_uri = 'https://cloud.neiros.ru/vk_1';
        $display = \VK\OAuth\VKOAuthDisplay::PAGE;
        $scope = array(\VK\OAuth\Scopes\VKOAuthGroupScope::MESSAGES);
        $state = 'secret_state_code';
        $groups_ids = array(1, 2);

        return   $browser_url = $oauth->getAuthorizeUrl(\VK\OAuth\VKOAuthResponseType::CODE, $client_id, $redirect_uri, $display, $scope, $state, $groups_ids);
    }
    public function __construct(){


        define('CALLBACK_API_EVENT_CONFIRMATION', 'confirmation');
        define('CALLBACK_API_EVENT_MESSAGE_NEW', 'message_new');

/*config*/

        define('BOT_BASE_DIRECTORY', '/var/www');
        define('BOT_LOGS_DIRECTORY', BOT_BASE_DIRECTORY.'/logs');
        define('BOT_IMAGES_DIRECTORY', BOT_BASE_DIRECTORY.'/static');
        define('BOT_AUDIO_DIRECTORY', BOT_BASE_DIRECTORY.'/audio');

        define('CALLBACK_API_CONFIRMATION_TOKEN', '13edee11'); //Строка для подтверждения адреса сервера из настроек Callback API
        define('VK_API_ACCESS_TOKEN', 'cc34a7440d062a40c108aabe103927724701ecb6545f3b5d66a6d6ee315b80bb6594d637726e8e3107bcc'); //Ключ доступа сообщества
        define('YANDEX_API_KEY', '30e3213440-61233-1294-b3415-471212369886'); //Ключ для доступа к Yandex Speech Kit

/*config*/
}



/*if (!isset($_REQUEST)) {
exit;
}*/

/*callback_handleEvent();*/

function callback_handleEvent(Request $request) {
    Log::info("______WISTIS");
    Log::info($request->all());

   $site=DB::table('sites')->where('hash',$request->key)->first();
   if(!$site){
       Log::info('error01');
       return 'error01-.'.$site->id;
   }
$widget=DB::table('widgets')->where('sites_id',$site->id)->where('status',1)->where('tip',4)->first();
   if(!$widget){Log::info($site->id);
       return Log::info('error012');
 
   }

$widget_vk=DB::table('widget_vk')->where('widget_id',$widget->id)->first();

   if(!$widget_vk)
   {
       Log::info('error0123');return;
}


    $event = $this->_callback_getEvent();

    try {
        switch ($event['type']) {
            //Подтверждение сервера

            case CALLBACK_API_EVENT_CONFIRMATION:

               $gr= WidgetVkPage::

                     where('vk_id',$event['group_id'])->first();
                if($gr){

                    return  $gr->confirmation;  }



                break;

            //Получение нового сообщения
            case CALLBACK_API_EVENT_MESSAGE_NEW:

                $this->_callback_handleMessageNew($event,$site,$widget,$widget_vk);
                break;

            default:
                $this->_callback_response('Unsupported event');
                break;
        }
    } catch (Exception $e) {
        Log::info($e);
    }

    $this->_callback_okResponse();
}

function _callback_getEvent() {
    return json_decode(file_get_contents('php://input'), true);
}

function _callback_handleConfirmation() {
    $this->_callback_response(CALLBACK_API_CONFIRMATION_TOKEN);
}

function _callback_handleMessageNew($data,$site,$widget,$widget_vk) {
    Log::useFiles(base_path() . '/storage/logs/vk.log', 'info');

    Log::info("data");
    Log::info($data);
    $group_id=WidgetVkPage::where('vk_id',$data['group_id'])->first();
if(!$group_id){
    info('notgroup');
    return  false;
}

    $prov=DB::table('widget_vk_input')
        ->where('my_company_id',$site->my_company_id)

        ->where('group_id',$data['group_id'])
        ->where('mess_id',$data['object']['id'])
        ->where('vk_user_id',$data['object']['user_id'])->first();
    if($prov){
        return '';
    }
info('about vk');
info(json_encode($site));
    $widget_vk_input_id=DB::table('widget_vk_input')->insertGetId([
       'user_id'=>$site->user_id,
       'my_company_id'=>$site->my_company_id,
       'widget_id'=>$widget->id,
       'widget_vk_id'=>$widget_vk->id,
       'group_id'=>$data['group_id'],
       'mess_id'=>$data['object']['id'],
       'date'=>$data['object']['date'],
       'out'=>$data['object']['out'],
       'vk_user_id'=>$data['object']['user_id'],
       'read_state'=>0,
       'title'=>'',
       'body'=>$data['object']['body'],
       'created_at'=>date('Y-m-d H:i:s'),
       'updated_at'=>date('Y-m-d H:i:s')
    ]);
    Log::info("widget_vk_input 121 insert");


$prov_vk_user=DB::table('widget_vk_users')->where('vk_user_id',$data['object']['user_id'])->where('group_id',$data['group_id'])->where('my_company_id',$site->my_company_id)->first();
if(!$prov_vk_user){
    Log::info("widget_vk_input 139 notprovuser".$data['object']['user_id'].'- - '.$site->my_company_id);

    $users_get_response = Vk_Api::vkApi_usersGet($data['object']['user_id'],$group_id);
    $user = array_pop($users_get_response);


    if(isset($user['city']['title'])){
        $itogo['object']['city']=$user['city']['title'];

    }else{
        $itogo['object']['city']='';
    }
      if(isset($user['photo_50'])){
        $itogo['object']['photo_50']=$user['photo_50'];

    }else{
        $itogo['object']['photo_50']='';
    }
    if(isset($user['photo_200'])){
        $itogo['object']['photo_200']=$user['photo_200'];

    }else{
        $itogo['object']['photo_200']='';
    }

$user_ids=DB::table('widget_vk_users')->insertGetId([
    'user_id'=>$site->user_id,
    'my_company_id'=>$site->my_company_id,
    'widget_id'=>$widget->id,
    'vk_user_id'=>$data['object']['user_id'],
    'first_name'=>$user['first_name'],
    'last_name'=>$user['last_name'],
    'photo_50'=>$itogo['object']['photo_50'],
    'photo_200'=>$itogo['object']['photo_200'],
    'city'=>$itogo['object']['city'],
    'created_at'=>date('Y-m-d H:i:s'),
    'updated_at'=>date('Y-m-d H:i:s'),
    'widget_vk_input_id'=>$widget_vk_input_id,
    'group_id'=>$data['group_id'],
    'tema_id'=>0,

]);

$data_w['fio']=$user['first_name'].' '.$user['last_name'].'';
    $getallwid = Project::where('widget_id', $widget->id)->count();
    $getallwid++;
    $WidgetApiController=new WidgetApiController();
    $neiros_visit=$WidgetApiController->get_neiros_visit(4,$widget->sites_id);
    $data_w['neiros_visit']=$neiros_visit;
    $projectId = $WidgetApiController->create_lead([
        'name' => $widget->name . ' № ' . $getallwid,
        'stage_id' => $widget->stage_id,
        'user_id' => $widget->user_id,
        'summ' => 0,
        'comment' => $widget->name,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
        'fio' => '',
        'company' => '',
        'widget_id' => $widget->id,
'widgets_client_id'=>$user_ids,
'widgets_model'=>'App\Models\Widgets\WidgetFbUsers',
        'my_company_id' => $widget->my_company_id,
        'neiros_visit' => '',
        'vst' => 0,
        'pgs' => 0,
        'url' => '',
        'site_id' => $widget->sites_id,
        'week' => date("W", time()),
        'hour' => date("H", time())
    ], $data_w);



    /*INSERT INTO `chat_tema`(`id`, `name`, `image`, `tip`, `created_at`, `updated_at`, `my_company_id`) */
    Log::info("chat_tema 214  ");
    $idtmus=DB::table('chat_tema')->where('my_company_id',$site->my_company_id)->count();
    $hid_id=$idtmus+1;

    Log::info("chat_tema 218  ");
    $tema_id=DB::table('chat_tema')->insertgetid([
        'name'=>$user['first_name'].' '.$user['last_name'],
        'image'=>$itogo['object']['photo_50'],
        'tip'=>4,
        'my_company_id'=>$site->my_company_id,
        'created_at'=>date('Y-m-d H:i:s'),
        'updated_at'=>date('Y-m-d H:i:s'),
        'status'=>1,
        'sites_id'=>$site->id,
        'hid_id'=>$hid_id,
        'project_id'=>$projectId,
        'neiros_visit'=>$neiros_visit,
        'group_id'=>$data['group_id'],
    ]);

DB::table('widget_vk_users')->where('vk_user_id',$data['object']['user_id'])->update(['tema_id'=>$tema_id]);

}else{
    Log::info("chat_tema 236  ");
    $tema_id=$prov_vk_user->tema_id;
    DB::table('chat_tema')->where('id',$tema_id)->update([
        'status'=>1,
        'updated_at'=>date('Y-m-d H:i:s'),
        ]);
}
/*INSERT INTO `chat_with_client`(`id`, `my_company_id`, `widget_id`, `tip`, `input_user_id`, `mess`, `from`, `updated_at`, `created_at`, `out_user_id`, `read_input_user_status`, `read_out_user_status`) */
    $mess_id=DB::table('chat_with_client')->insertGetId([
    'widget_id'=>$widget->id,
    'my_company_id'=>$site->my_company_id,
    'tip'=>4,
    'input_user_id'=>$data['object']['user_id'],
    'mess'=>$data['object']['body'],
    'from'=>0,
    'created_at'=>date('Y-m-d H:i:s'),
    'updated_at'=>date('Y-m-d H:i:s'),
    'out_user_id'=>0,
    'read_input_user_status'=>0,
    'read_out_user_status'=>0,
    'input_mess_id'=>    $widget_vk_input_id ,
    'tema_id'=> $tema_id ,

]);
    Log::info("chat_with_client ".$mess_id);
$datatochat['site']=$site->hash;
$datatochat['hash']=$tema_id;
$datatochat['hiddenmes']=$mess_id;
$datatochat['my_company_id']=$widget->my_company_id;
$datatochat['typ']=4;
$datatochat['admin']=$site->hash;

    \Ratchet\Client\connect('wss://cloud.neiros.ru/wss2/robot')->then(function($conn)use($site,$tema_id,$data,$mess_id) {


        $conn->send('{
        "mess_id":"'.$mess_id.'",
        
        "message":"newmess","hash":"robot","tema_id":"'.$tema_id.'","site":"'.$site->hash.'","admin":0,"my_company_id":"'.md5($site->my_company_id).'","tip_message":"text","typ":4}');$conn->close();
    }, function ($e) {
        echo "Could not connect: {$e->getMessage()}\n";
    });

    $this->_callback_okResponse();


}

function _callback_okResponse() {
    $this->_callback_response('ok');
}

function _callback_response($data) {
    echo $data;
    exit();
}


}
