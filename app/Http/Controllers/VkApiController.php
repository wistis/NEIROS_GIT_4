<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Api\WidgetApiController;
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
class VkApiController extends Controller
{

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
              return  $widget_vk->confirmation;
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



    $prov=DB::table('widget_vk_input')
        ->where('my_company_id',$site->my_company_id)

        ->where('group_id',$data['group_id'])
        ->where('mess_id',$data['object']['id'])
        ->where('vk_user_id',$data['object']['from_id'])->first();
    if($prov){  Log::info("widget_vk_input return 117");
        return '';
    }

    $widget_vk_input_id=DB::table('widget_vk_input')->insertGetId([
       'user_id'=>$site->user_id,
       'my_company_id'=>$site->my_company_id,
       'widget_id'=>$widget->id,
       'widget_vk_id'=>$widget_vk->id,
       'group_id'=>$data['group_id'],
       'mess_id'=>$data['object']['id'],
       'date'=>$data['object']['date'],
       'out'=>$data['object']['out'],
       'vk_user_id'=>$data['object']['from_id'],
       'read_state'=>0,
       'title'=>'',
       'body'=>$data['object']['text'],
       'created_at'=>date('Y-m-d H:i:s'),
       'updated_at'=>date('Y-m-d H:i:s')
    ]);
    Log::info("widget_vk_input 121 insert");
$prov_vk_user=DB::table('widget_vk_users')->where('vk_user_id',$data['object']['from_id'])->where('my_company_id',$site->my_company_id)->first();
if(!$prov_vk_user){
    Log::info("widget_vk_input 139 notprovuser".$data['object']['from_id'].'- - '.$site->my_company_id);

    $users_get_response = Vk_Api::vkApi_usersGet($data['object']['from_id'],$widget_vk);
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
    'vk_user_id'=>$data['object']['from_id'],
    'first_name'=>$user['first_name'],
    'last_name'=>$user['last_name'],
    'photo_50'=>$itogo['object']['photo_50'],
    'photo_200'=>$itogo['object']['photo_200'],
    'city'=>$itogo['object']['city'],
    'created_at'=>date('Y-m-d H:i:s'),
    'updated_at'=>date('Y-m-d H:i:s'),
    'widget_vk_input_id'=>$widget_vk_input_id,
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
'widgets_model'=>'App\Models\Widgets\WidgetVkUsers',
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
    ]);

DB::table('widget_vk_users')->where('vk_user_id',$data['object']['from_id'])->update(['tema_id'=>$tema_id]);

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
    'input_user_id'=>$data['object']['from_id'],
    'mess'=>$data['object']['text'],
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
