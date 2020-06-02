<?php

namespace App\Http\Controllers\ViberAPI;

use App\Models\Servies\ALpParam;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Viber\Client;
use Viber\Bot;
use DB;
use Viber\Api\Sender;
use Log;
use ElephantIO\Client as Clcl;
use ElephantIO\Engine\SocketIO\Version2X;
use App\Project;
use App\Http\Controllers\Api\WidgetApiController;
class ViberApiController extends Controller
{
    public function registerwebhook($keysite,$apiKey){



$webhookUrl = 'https://cloud.neiros.ru/api/viberapi/callback_handleEvent/'.$keysite; // <- PLACE-YOU-HTTPS-URL
try {
    $client = new Client([ 'token' => $apiKey ]);
    return   $result = $client->setWebhook($webhookUrl);

} catch (Exception $e) {
  return 0;
}
    }


public function create_viber_user($data,$widget_viber,$widget,$site){


if(!isset($data['user']['name'])){
    $data['user']['name']="Клиент";
}
    $prov_vk_user=DB::table('widget_viber_users')->where('vk_user_id',$data['user']['id'])->first();
    if(!$prov_vk_user){

        $avatar='';
        if(isset($data['user']['avatar'])){
            $avatar=$data['user']['avatar'];
        }
if(isset($data['context'])){
            $context=$data['context'];
}else{
            $context='';
}

        DB::table('widget_viber_users')->insert([
            'user_id'=>$site->user_id,
            'my_company_id'=>$site->my_company_id,
            'widget_id'=>$widget->id,
            'vk_user_id'=>$data['user']['id'],
            'first_name'=>$data['user']['name'],
           // 'last_name'=>$user['last_name'],
            'photo_50'=>$avatar,
           // 'photo_200'=>$itogo['object']['photo_200'],
            'context'=>$context,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),

            'tema_id'=>0,

        ]);
        $data_w['fio']=$data['user']['name'].'(Viber)';
        $getallwid = Project::where('widget_id', $widget->id)->count();
        $getallwid++;
        $WidgetApiController=new WidgetApiController();
        $neiros_visit=$WidgetApiController->get_neiros_visit(5,$widget->sites_id);
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

            'my_company_id' => $widget->my_company_id,

            'vst' => 0,
            'pgs' => 0,
            'url' => '',
            'site_id' => $widget->sites_id,
            'week' => date("W", time()),
            'hour' => date("H", time())
        ], $data_w);
        /*INSERT INTO `chat_tema`(`id`, `name`, `image`, `tip`, `created_at`, `updated_at`, `my_company_id`) */
        $idtmus=DB::table('chat_tema')->where('my_company_id',$site->my_company_id)->count();
        $hid_id=$idtmus+1;
        $tema_id=DB::table('chat_tema')->insertgetid([
            'name'=>$data['user']['name'],
            'image'=>$avatar,
            'tip'=>5,
            'my_company_id'=>$site->my_company_id,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
            'status'=>0,
            'sites_id'=>$site->id,
            'hid_id'=>$hid_id,
            'project_id'=>$projectId,
            'neiros_visit'=>$neiros_visit,
        ]);

        DB::table('widget_viber_users')->where('vk_user_id',$data['user']['id'])->update(['tema_id'=>$tema_id]);
return $tema_id;
    }

}
    public function callback_handleEvent($key,Request $request){
      $data=$request->all();

 \Log::info('foromviber');
 \Log::info($data);

        $site=DB::table('sites')->where('hash',$request->key)->first();
        if(!$site){

            \Log::info('viber error01'); return '';
        }
        $widget=DB::table('widgets')->where('sites_id',$site->id)->where('tip',5)->first();
        if(!$widget){
            \Log::info('viber error02'); return '';

        }

        $widget_viber=DB::table('widget_viber')->where('widget_id',$widget->id)->first();

        if(!$widget_viber)
        {
            \Log::info('viber error03'); return '';
        }

        if($data['event']=='conversation_started'){
            $this->create_viber_user($data,$widget_viber,$widget,$site);
        }

        \Log::info('viber step1');
        $apiKey=$widget_viber->apikey;


// так будет выглядеть наш бот (имя и аватар - можно менять)
        $botSender = new Sender([
            'name' => 'Neiros',
            'avatar' => 'https://developers.viber.com/img/favicon.ico',
        ]);
        \Log::info('viber 2');
        try {
            \Log::info('viber 32');
$provlp=ALpParam::where('utm',$request->context)->first();
info(json_encode($provlp));
            if($provlp){

                $bot = new Bot(['token' => $apiKey]);
                $bot ->onConversation(function ($event) use ($bot, $botSender,$widget_viber,$widget,$site,$data,$provlp) {
                    // это событие будет вызвано, как только пользователь перейдет в чат
                    // вы можете отправить "привествие", но не можете посылать более сообщений


                        return (new \Viber\Api\Message\File())
                            ->setSender($botSender)
                            ->setMedia($provlp->url)
                            ->setSize($provlp->massa)
                            ->setFileName($provlp->url_name);

                })  ->run();



            }


            $bot = new Bot(['token' => $apiKey]);
            $bot ->onConversation(function ($event) use ($bot, $botSender,$widget_viber,$widget,$site,$data) {
                    // это событие будет вызвано, как только пользователь перейдет в чат
                    // вы можете отправить "привествие", но не можете посылать более сообщений
                 if(strlen($widget_viber->start_message)>2) {

                     return (new \Viber\Api\Message\Text())
                         ->setSender($botSender)
                         ->setText($widget_viber->start_message);
                 }
                })
                ->onText('|.*|s', function ($event) use ($bot, $botSender,$widget_viber,$widget,$site,$data) {


                    // это событие будет вызвано если пользователь пошлет сообщение
                    // которое совпадет с регулярным выражением
                    \Log::info('viber 33');
                    $this->_callback_handleMessageNew($event,$site,$widget,$widget_viber,$data);
                    /*$bot->getClient()->sendMessage(
                        (new \Viber\Api\Message\Text())
                            ->setSender($botSender)
                            ->setReceiver($event->getSender()->getId())
                            ->setText("I do not know )")
                    );*/
                })
                ->run();
        } catch (Exception $e) {

            info($e);

            // todo - log exceptions
        }


    }

    public function _callback_handleMessageNew($event,$site,$widget,$widget_vk,$data){




        \Log::info('viber 34');
        $widget_vk_input_id=DB::table('widget_viber_input')->insertGetId([
            'user_id'=>$site->user_id,
            'my_company_id'=>$site->my_company_id,
            'widget_id'=>$widget->id,
            'widget_vk_id'=>$widget_vk->id,
            //'group_id'=>$data['group_id'],//
          //  'mess_id'=>$data_ev,
            'date'=>time(),
            //'out'=>$data['object']['out']//,
            'vk_user_id'=>$data['sender']['id'],
           // 'read_state'=>$data['object']['read_state'],
         //   'title'=>$data['object']['title'],
            'body'=>$data['message']['text'],
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);

        $prov_vk_user=DB::table('widget_viber_users')->where('vk_user_id',$data['sender']['id'])->first();
        if(!$prov_vk_user){
            $data['user']=$data['sender'];
            $tema_id=$this->create_viber_user($data,$widget_vk,$widget,$site);
        }else{

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
            'tip'=>5,
            'input_user_id'=>$data['sender']['id'],
            'mess'=>$data['message']['text'],
            'from'=>0,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
            'out_user_id'=>0,
            'read_input_user_status'=>0,
            'read_out_user_status'=>0,
            'input_mess_id'=>    $widget_vk_input_id ,
            'tema_id'=> $tema_id ,

        ]);
        //  $VkBotGlobalController->bot_sendMessage($user_id,$site,$widget,$widget_vk);


        $datatochat['hash']=$tema_id;
        $datatochat['hiddenmes']=$mess_id;
        $datatochat['typ']=4;
        $datatochat['admin']=$site->hash;
        \Log::info('viber 35');

        \Ratchet\Client\connect('wss://cloud.neiros.ru/wss2/robot')->then(function($conn)use($site,$tema_id,$data,$mess_id) {
            \Log::info('viber 36');

            $conn->send('{
        "mess_id":"'.$mess_id.'",
        
        "message":"newmess","hash":"robot","tema_id":"'.$tema_id.'","site":"'.$site->hash.'","admin":0,"my_company_id":"'.md5($site->my_company_id).'","tip_message":"text","typ":5}');$conn->close();
        }, function ($e) {
            echo "Could not connect: {$e->getMessage()}\n";
        });





    }
    public function send_mess($apiKey,$user_id,$message){
        $botSender = new Sender([
            'name' => 'Whois bot',
            'avatar' => 'https://developers.viber.com/img/favicon.ico',
        ]);
        $bot = new Bot(['token' => $apiKey]);
        $bot->getClient()->sendMessage(
                       (new \Viber\Api\Message\Text())
                           ->setSender($botSender)
                           ->setReceiver($user_id)
                           ->setText($message)
                   );

    }
}


