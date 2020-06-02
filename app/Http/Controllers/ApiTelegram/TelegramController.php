<?php

namespace App\Http\Controllers\ApiTelegram;

use App\Models\Servies\ALpParam;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;
use DB;
use App\Project;
use App\Http\Controllers\Api\WidgetApiController;
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;
class TelegramController extends Controller
{
    public function set_webhook($apikey, $hash)
    {

        return $this->makeRequest($apikey, $hash);


    }

    public static function makeRequest($token, $hash)
    {
        $site = DB::table('sites')->where('id', $hash)->first();

        $requestStr  = 'https://telega.neiros.ru/input.php?user_id=' . $site->hash;
        $stroka="https://api.telegram.org/bot".$token."/setWebhook?url=".$requestStr;
$data['data']=$stroka;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://telega.neiros.ru/webhook.php');
       // curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=utf-8'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, "stroka=".json_encode($data));
        $out = curl_exec($curl);

        curl_close($curl);
        return $out;

    }

    public function callback_handleEvent(Request $request)
    {



        /*[2018-06-27 20:45:35] local.INFO: array (
          'sender' =>
          array (
            'name' => 'Михаил Ворсин',
            'user_id' => 'user:563696152904',
          ),
          'recipient' =>
          array (
            'chat_id' => 'chat:C3e7eb44e3c00',
          ),
          'message' =>
          array (
            'text' => 'sdfsdf',
            'seq' => 100278044892469443,
            'mid' => 'mid:C3e7eb44e3c00.1644259bc9618c3',
          ),
          'timestamp' => 1530121534614,
        )
        */
      ;
      Log::info("старт");
      $datam = $request->all();
      Log::info("from_telegram");
      Log::info($datam);




        $site = DB::table('sites')->where('hash', $request->key)->first();

        ;
        if (!$site) {

            return 'error01';
        }
        $widget = DB::table('widgets')->where('sites_id', $site->id)->where('tip', 8)->first();
        if (!$widget) {
            return 'error02';

        }

        $widget_ok = DB::table('widget_telegram')->where('widget_id', $widget->id)->first();

        if (!$widget_ok) {

            return 'error03';
        }

info(json_encode($widget_ok));
        $data=$datam['message'];

            $provlp=ALpParam::where('utm',str_replace('/start ','',$data['text']))->first();
        info(json_encode($provlp));
        if($provlp){
            $datas['apikey']=$widget_ok->apikey;
            $datas['chat_id']=$data['chat']['id'];
            $datas['file']=$provlp->url;

            return  $this->send_mess_1($datas);
        }

        $widget_vk_input_id = DB::table('widget_telegram_input')->insertGetId([
            'user_id' => $site->user_id,
            'my_company_id' => $site->my_company_id,
            'widget_id' => $widget->id,
            'widget_vk_id' => $widget_ok->id,
            'group_id' => $data['chat']['id'],
            'date' => time(),
            'vk_user_id' => $data['from']['id'],
            'body' => $data['text'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $prov_vk_user = DB::table('widget_telegram_users')->where('vk_user_id', $data['from']['id'])
            ->where('my_company_id', $site->my_company_id)->first();
        if (!$prov_vk_user) {
            $data['user'] = $data['from'];
            $tema_id = $this->create_ok_user($data, $widget_ok, $widget, $site);
        } else {

            $tema_id = $prov_vk_user->tema_id;
            DB::table('chat_tema')->where('id', $tema_id)->update([
                'status' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
        /*INSERT INTO `chat_with_client`(`id`, `my_company_id`, `widget_id`, `tip`, `input_user_id`, `mess`, `from`, `updated_at`, `created_at`, `out_user_id`, `read_input_user_status`, `read_out_user_status`) */
        $mess_id=DB::table('chat_with_client')->insertGetId([
            'widget_id' => $widget->id,
            'my_company_id' => $site->my_company_id,
            'tip' => 8,
            'input_user_id' => $data['from']['id'],
            'mess' => $data['text'],
            'from' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'out_user_id' => 0,
            'read_input_user_status' => 0,
            'read_out_user_status' => 0,
            'input_mess_id' => $widget_vk_input_id,
            'tema_id' => $tema_id,

        ]);
        $datatochat['hash']=$tema_id;
        $datatochat['hiddenmes']=$mess_id;
        $datatochat['typ']=4;
        $datatochat['admin']=$site->hash;
        \Ratchet\Client\connect('wss://cloud.neiros.ru/wss2/robot')->then(function($conn)use($site,$tema_id,$data,$mess_id) {
            \Log::info('viber 36');

            $conn->send('{
        "mess_id":"'.$mess_id.'",
        
        "message":"newmess","hash":"robot","tema_id":"'.$tema_id.'","site":"'.$site->hash.'","admin":0,"my_company_id":"'.md5($site->my_company_id).'","tip_message":"text","typ":8}');$conn->close();
        }, function ($e) {
            echo "Could not connect: {$e->getMessage()}\n";
        });

    }

    public function create_ok_user($data, $widget_viber, $widget, $site)
    {

        $prov_vk_user = DB::table('widget_telegram_users')->where('vk_user_id', $data['user']['id'])->where('my_company_id',  $site->my_company_id)->first();
        if (!$prov_vk_user) {


            DB::table('widget_telegram_users')->insert([
                'user_id' => $site->user_id,
                'my_company_id' => $site->my_company_id,
                'widget_id' => $widget->id,
                'vk_user_id' => $data['user']['id'],
                'first_name' => $data['user']['first_name'],
                // 'last_name'=>$user['last_name'],


                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),

                'tema_id' => 0,

            ]);





            $data_w['fio']=$data['user']['first_name'].'(Telegram)';
            $getallwid = Project::where('widget_id', $widget->id)->count();
            $getallwid++;
            $WidgetApiController=new WidgetApiController();
            $neiros_visit=$WidgetApiController->get_neiros_visit(8,$widget->sites_id);
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

            $idtmus=DB::table('chat_tema')->where('my_company_id',$site->my_company_id)->count();
            $hid_id=$idtmus+1;
            $tema_id = DB::table('chat_tema')->insertgetid([
                'name' => $data['user']['first_name'],
                'image' => '',
                'tip' => 8,
                'my_company_id' => $site->my_company_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'status' => 0,
                'sites_id' => $site->id,
                'hid_id'=>$hid_id,
                'project_id'=>$projectId,
                'neiros_visit'=>$neiros_visit,
            ]);

            DB::table('widget_telegram_users')->where('vk_user_id', $data['user']['id'])->update(['tema_id' => $tema_id]);

            return $tema_id;
        }

    }
    public function send_mess($apiKey,$user_id,$message){


       /* echo  file_get_contents('https://api.telegram.org/bot'.$_POST['apikey'].'/sendMessage?chat_id='.$_POST['chat_id'].'&text='.$_POST['message'].'');*/

        $data['apikey']=$apiKey;
        $data['chat_id']=$user_id;
        $data['message']=$message;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://telega.neiros.ru/sendmessage.php');
        // curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=utf-8'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, "stroka=".json_encode($data));
        $out = curl_exec($curl);

        curl_close($curl);
        return $out;

    }
    public function send_mess_1($data){


       /* echo  file_get_contents('https://api.telegram.org/bot'.$_POST['apikey'].'/sendMessage?chat_id='.$_POST['chat_id'].'&text='.$_POST['message'].'');*/


        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://telega.neiros.ru/sendmessage.php');
        // curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=utf-8'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, "stroka=".json_encode($data));
        $out = curl_exec($curl);

        curl_close($curl);
        return $out;

    }

}
