<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Controllers\ApiTelegram\TelegramController;
use App\Http\Controllers\FbApi\FbController;
use App\Http\Controllers\OkApi\OkApiController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ViberAPI\ViberApiController;
use App\Http\Controllers\VkApi\VkApiController as Vk_Api;
use App\Models\Fb\WidgetFbPage;
use App\Sites;
use Auth;
use DB;
use Illuminate\Http\Request;
use App\Models\MetricaCurrent;
;

class ChatController extends Controller
{

    public function setting_chat(Request $request){

        DB::table('users')->where('id',Auth::user()->id)->update(['chat_audio'=>$request->chat_audio,
            'users_push'=>$request->users_push]);

    }
    public function deleteTokenToServer(){
        $user=Auth::user();
        DB::table('users')->where('id',$user->id)->update(['users_push'=>0]);

    }
    public function send_token_push(Request $request){

        $user=Auth::user();
        $ua = \Request::server('HTTP_USER_AGENT');
        $token=$request->token;
        $prov_google_token = DB::table('users_push')->where('user_id', $user->id)->where('ua', $ua)->first();
        if ($prov_google_token) {

            DB::table('users_push')->where('id', $prov_google_token->id)->update([
                'time_online'=>time(),
                'token'=>$token


            ]);
        } else {
            DB::table('users_push')->insert([
                'time_online'=>time(),
                'token'=>$token,
                'user_id'=>$user->id,
                'ua'=>$ua,
                'time_online'=>time(),

            ]);

        }
DB::table('users')->where('id',$user->id)->update(['users_push'=>1]);

    }

    public function widgetchat(){
        $ChatController = new ChatController();
        $data = $ChatController->get_data_to_chat();

        return view('widgets.widgetchat');
    }

public function insertreq(Request $request){

    if($request->param=='setnotification'){
    $this->setnotification($request);

    }






}


public function get_data_to_chat($domen = null, $account = null){

    $user = Auth::user();

    if($user->selected_chat==0){
        $temas = DB::table('chat_tema')->where('my_company_id', $user->my_company_id)->orderby('status', 'desc')->orderby('updated_at', 'desc')->get();

    }else{
        $temas = DB::table('chat_tema')->where('my_company_id', $user->my_company_id)->where('sites_id', $user->selected_chat)->orderby('status', 'desc')->orderby('updated_at', 'desc')->get();
    }


    $data['app_chat'] = 'app';
    $data['temas'] = $temas;;;
    $data['user'] = $user;;;


        $data['app_chat'] = 'app_chat';


    $ua = \Request::server('HTTP_USER_AGENT');

    $prov_google_token = DB::table('users_push')->where('user_id', $user->id)->where('ua', $ua)->first();
    if ($prov_google_token) {
        $data['prov_google_token'] = 0;
        DB::table('users_push')->where('id', $prov_google_token->id)->update(['time_online'=> time()]);
    } else {

        $data['prov_google_token'] = 1;
    }
    return $data;
}

static function setchatsite($request){
    $user=Auth::user();
    $site=Sites::where('my_company_id',$user->my_company_id)->where('id',$request->id)->first();
 if($site){
     DB::table('users')->where('id',$user->id)->update(['selected_chat'=>$request->id]);


 }
 if($request->id==0){
     DB::table('users')->where('id',$user->id)->update(['selected_chat'=>0]);

 }
}
static function  setchatsitetext(Request $request){


    $user = Auth::user();
    $data['error'] = 0;
    $tema = DB::table('chat_tema')->where('my_company_id', $user->my_company_id)->where('id', $request->tema_search)->first();
    if (!$tema) {



            $data['error'] = 1;

    }
if($request->text!=''){
    $messages = DB::table('chat_with_client')->where('tema_id', $tema->id)->where('mess','LIKE','%'.$request->text.'%')->get();}else{
    $messages = DB::table('chat_with_client')->where('tema_id', $tema->id)->get();
}
    $data['messages'] = '';
    $datal['usermess'] = $tema;
    $data['usermess'] = $tema;
    $messages_arr_d = [];

    $today_mess=0;
    foreach ($messages as $message) {
        if (date('d.m.Y', strtotime($message->created_at)) == date('d.m.Y')) {
            $today_mess=1;
        }

        if (!in_array(date('d.m.Y', strtotime($message->created_at)), $messages_arr_d)) {




            if (date('d.m.Y', strtotime($message->created_at)) == date('d.m.Y')) {
                $data['messages'].=' <div class="diliver diliver--gray"><span>Сегодня</span></div>';

            } elseif (date('d.m.Y', strtotime($message->created_at)) == date('d.m.Y', strtotime('-1 day', time()))) {
                $data['messages'].=' <div class="diliver diliver--gray"><span>Вчера</span></div>';

            } else {

                $data['messages'].=' <div class="diliver diliver--gray"><span>'.date('d.m.Y', strtotime($message->created_at)).'</span></div>';
            }

        }

        $messages_arr_d[] = date('d.m.Y', strtotime($message->created_at));


        $datal['mess'] = $message;
        if ($message->from == 0) {
            $data['messages'] .= view('chat.left_dialog', $datal)->render();


        } else {
            $data['messages'] .= view('chat.right_dialog', $datal)->render();
        }
        DB::table('chat_with_client')->where('read_out_user_status', 0)->where('id', $message->id)->update(['read_out_user_status' => 1]);
    }
    $data['hash'] = $tema->hash;
    $data['hashmd5'] = md5($tema->hash);
    $data['today_mess']=$today_mess;
    $data['metrika_last']=DB::table('metrica_visits')->where('neiros_visit',$tema->neiros_visit)->orderby('id','desc')->first();

    if( $data['metrika_last']){
        $data['metrika_last']=date('H:i d.m.Y',strtotime($data['metrika_last']->updated_at));

    }else{
        $data['metrika_last']='';
    }

    return json_encode($data);




}
    public function index($domen = null, $account = null,Request $request)
    {
 $user=Auth::user();

$data=$this->get_data_to_chat($domen , $account );
$data['my_site']=Sites::find($user->site);
$data['fasts']=DB::table('widgets_chat_fastotvet')->where('my_company_id',$user->my_company_id)->get();
$data['from']=0;
         if($request->from=='cloud'){
             $data['from']=1;
         };

   $data['sites']=Sites::where('my_company_id',$user->my_company_id)->where('is_deleted',0)->get();

        return view('chat.chat', $data);


    }

    static function chatsearch($request){
        $user=Auth::user();
if($request->text!=''){

    $temas= DB::table('chat_tema')
        ->where('my_company_id', $user->my_company_id)

        ->where(
            DB::raw( 'CONCAT(name, \' \',  hid_id)')
           ,'LIKE','%'.$request->text.'%')


        ->orderby('status', 'desc')->orderby('updated_at', 'desc')->get();

}else{

    $temas = DB::table('chat_tema')->where('my_company_id', $user->my_company_id)->orderby('status', 'desc')->orderby('updated_at', 'desc')->get();
}

$text='';

foreach ($temas as $tema){

    $text.=view('chat.chat_tema',['tema'=>$tema])->render();

}
  return $text;




    }
    public function get_tek_tema(Request $request)
    {
        $user = Auth::user();

        if($user->selected_chat==0) {

            $tema = DB::table('chat_tema')->where('my_company_id', $user->my_company_id)->where('id', $request->tema)->first();
            if (!$tema) {
                $tema = DB::table('chat_tema')->where('my_company_id', $user->my_company_id)->where('hash', $request->tema)->first();

            }
        }else{

            $tema = DB::table('chat_tema')->where('my_company_id', $user->my_company_id)->where('id', $request->tema)->where('sites_id',$user->selected_chat)->first();
            if (!$tema) {
                $tema = DB::table('chat_tema')->where('my_company_id', $user->my_company_id)->where('sites_id',$user->selected_chat)->where('hash', $request->tema)->first();

            }

        }




$data['tema']=$tema;

        return   view('chat.chat_tema',$data)->render();
        
        
        
        

    }


    public function addclientinfo(Request $request){
$ClientController=new ClientController();
$client=$ClientController->addfield($request);
        return $request;



    }
public function getuserinfourl(Request $request){
    $user = Auth::user();
    $data['error'] = 0;
    $tema = DB::table('chat_tema')->where('my_company_id', $user->my_company_id)->where('id', $request->tema)->first();
    if(!$tema){
        $data['error'] = 1;
        return json_encode($data);
    }
    $data['tema']=$tema;

    if($tema->neiros_visit>0) {
        $data['metrika_last'] = DB::table('metrica_visits')->select('created_at as ep', 'url as fd')->where('neiros_visit', $tema->neiros_visit)->orderby('created_at', 'desc')->get();;
    }else{
        $data['metrika_last'] =[];
    }

return view('chat.getuserinfourl',$data)->render();
}

public function getuserinfourladdopen(Request $request){
    $user = Auth::user();
    $data['error'] = 0;
    $tema = DB::table('chat_tema')->where('my_company_id', $user->my_company_id)->where('id', $request->tema)->first();



    if(!$tema){
        $data['error'] = 1;
        return json_encode($data);
    }
    $data['tema']=$tema;
    $data['client_id']=$tema->client_id;

    if($tema->client_id==0){

        $data['clients']=\App\Client::where('my_company_id',$user->my_company_id)->get();

    }

$data['clients_contacts_tip']=DB::table('clients_contacts_tip')->get();
    return view('chat.additional_info',$data)->render();

}
    public function getuserinfo(Request $request){
        $user = Auth::user();
        $data['error'] = 0;
        $tema = DB::table('chat_tema')->where('my_company_id', $user->my_company_id)->where('id', $request->tema)->first();
        if(!$tema){
            $data['error'] = 1;
            return json_encode($data);
        } 
$data['client']=\App\Client::find($tema->client_id);
$data['clinfo']=[];
if($data['client']){

    $data['clinfo']=\App\Clients_contacts::where('client_id',$tema->client_id)->get();
}
if($tema->neiros_visit>0){
$data['clients_contacts_tip']=DB::table('clients_contacts_tip')->pluck('name','keytip');
$data['metrika_last']=DB::table('metrica_visits')->where('neiros_visit',$tema->neiros_visit)->orderby('id','desc')->first();

    $MetricaCurrent=new MetricaCurrent();

$data['metrika_first']=$MetricaCurrent->setTable('metrica_'.$user->my_company_id)->where('neiros_visit',$tema->neiros_visit)->orderby('visit','acs')->first();
$data['metrika_count_page']=DB::table('metrica_visits')->where('neiros_visit',$tema->neiros_visit)->count();
        $data['tema']=$tema;
    }else{

    return '';
}
        return view('chat.chatinfobody',$data)->render();
    }


    public function clickchattema(Request $request)
    {
        $user = Auth::user();
        $data['error'] = 0;
        $tema = DB::table('chat_tema')->where('my_company_id', $user->my_company_id)->where('id', $request->tema)->first();
        if (!$tema) {

            $tema = DB::table('chat_tema')->where('my_company_id', $user->my_company_id)->where('hash', $request->tema)->first();
            if (!$tema) {
                $data['error'] = 1;
            }
        }
        DB::table('chat_tema')->where('id', $tema->id)->update([
            'status' => 0,
        ]);
        $messages = DB::table('chat_with_client')->where('tema_id', $tema->id)->get();
        $data['messages'] = '';
        $datal['usermess'] = $tema;
        $data['usermess'] = $tema;
        $messages_arr_d = [];

        $today_mess=0;
        foreach ($messages as $message) {
            if (date('d.m.Y', strtotime($message->created_at)) == date('d.m.Y')) {
                $today_mess=1;
            }

            if (!in_array(date('d.m.Y', strtotime($message->created_at)), $messages_arr_d)) {




                if (date('d.m.Y', strtotime($message->created_at)) == date('d.m.Y')) {
$data['messages'].=' <div class="diliver diliver--gray"><span>Сегодня</span></div>';

                } elseif (date('d.m.Y', strtotime($message->created_at)) == date('d.m.Y', strtotime('-1 day', time()))) {
                    $data['messages'].=' <div class="diliver diliver--gray"><span>Вчера</span></div>';

                } else {

                    $data['messages'].=' <div class="diliver diliver--gray"><span>'.date('d.m.Y', strtotime($message->created_at)).'</span></div>';
                }

            }

            $messages_arr_d[] = date('d.m.Y', strtotime($message->created_at));


            $datal['mess'] = $message;
            if ($message->from == 0) {
                $data['messages'] .= view('chat.left_dialog', $datal)->render();


            } else {
                $data['messages'] .= view('chat.right_dialog', $datal)->render();
            }
            DB::table('chat_with_client')->where('read_out_user_status', 0)->where('id', $message->id)->update(['read_out_user_status' => 1]);
        }
        $data['hash'] = $tema->hash;
        $data['hashmd5'] = md5($tema->hash);
        $data['today_mess']=$today_mess;
        $data['metrika_last']=DB::table('metrica_visits')->where('neiros_visit',$tema->neiros_visit)->orderby('id','desc')->first();

        if( $data['metrika_last']){
            $data['metrika_last']=date('H:i d.m.Y',strtotime($data['metrika_last']->updated_at));

        }else{
            $data['metrika_last']='';
        }

        return json_encode($data);


    }

    public function sendmess(Request $request)
    {
        $user = Auth::user();
        $tema = DB::table('chat_tema')->where('my_company_id', $user->my_company_id)->where('id', $request->tema)->first();
        if (!$tema) {
            $data['error'] = 1;

        }


        switch ($tema->tip) {
            case 4:
                return $this->send_vk($tema, $request->message);
                break;
            case 5:
                return $this->send_viber($tema, $request->message);
                break;
            case 6:
                return $this->send_ok($tema, $request->message);
                break;
            case 7:
                return $this->send_fb($tema, $request->message);
                break;
            case 8:
                return $this->send_telegram($tema, $request->message);
                break;
            case 12:
                return $this->send_chat($tema, $request->message);
                break;
        }

    }

    public function get_tek_mess(Request $request)
    {
        $user = Auth::user();

        $tema = DB::table('chat_tema')->where('my_company_id', $user->my_company_id)->where('id', $request->tema)->first();
        if (!$tema) {
            $tema = DB::table('chat_tema')->where('my_company_id', $user->my_company_id)->where('hash', $request->tema)->first();
        }


        $datal['usermess'] = $tema;
         $datal['mess'] = DB::table('chat_with_client')->where('id', $request->message)->first();

        $data['messages'] = view('chat.left_dialog', $datal)->render();
        return json_encode($data);

    }

    public function send_chat($tema, $message)
    {
        $user = Auth::user();
        $site = DB::table('sites')->where('id', $tema->sites_id)->where('my_company_id', $user->my_company_id)->first();
        if (!$site) {

            return 'error01-.' . $site->id;
        }
        $widget = DB::table('widgets')->where('sites_id', $site->id)->where('tip', 12)->first();
        if (!$widget) {
            return 'error02';

        }

        $widget_vk = DB::table('widgets_chat')->where('widget_id', $widget->id)->first();

        if (!$widget_vk) {
            return 'error03';
        }


        $user_id_mess = DB::table('chat_with_client')->where('tema_id', $tema->id)->where('from', 0)->first();
        $user_id = DB::table('widget_chat_input')->where('my_company_id', $user->my_company_id)->where('vk_user_id', $user_id_mess->input_user_id)->first();;


        $idnewmes = DB::table('chat_with_client')->insertgetid([
            'widget_id' => $widget->id,
            'my_company_id' => $site->my_company_id,
            'tip' => 12,
            'input_user_id' => $user_id_mess->input_user_id,
            'mess' => $message,
            'from' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'out_user_id' => $user_id->id,
            'read_input_user_status' => 0,
            'read_out_user_status' => 0,
            'input_mess_id' => 0,
            'tema_id' => $tema->id,

        ]);


        $datal['usermess'] = $tema;
        $datal['mess'] = DB::table('chat_with_client')->where('id', $idnewmes)->first();

        $data['messages'] = view('chat.right_dialog', $datal)->render();
        return json_encode($data);

    }

    public function encode($payload, $type = 'text', $masked = false)
    {
        $frameHead = array();
        $payloadLength = strlen($payload);

        switch ($type) {
            case 'text':
                // first byte indicates FIN, Text-Frame (10000001):
                $frameHead[0] = 129;
                break;

            case 'close':
                // first byte indicates FIN, Close Frame(10001000):
                $frameHead[0] = 136;
                break;

            case 'ping':
                // first byte indicates FIN, Ping frame (10001001):
                $frameHead[0] = 137;
                break;

            case 'pong':
                // first byte indicates FIN, Pong frame (10001010):
                $frameHead[0] = 138;
                break;
        }

        // set mask and payload length (using 1, 3 or 9 bytes)
        if ($payloadLength > 65535) {
            $payloadLengthBin = str_split(sprintf('%064b', $payloadLength), 8);
            $frameHead[1] = ($masked === true) ? 255 : 127;
            for ($i = 0; $i < 8; $i++) {
                $frameHead[$i + 2] = bindec($payloadLengthBin[$i]);
            }
            // most significant bit MUST be 0
            if ($frameHead[2] > 127) {
                return array('type' => '', 'payload' => '', 'error' => 'frame too large (1004)');
            }
        } elseif ($payloadLength > 125) {
            $payloadLengthBin = str_split(sprintf('%016b', $payloadLength), 8);
            $frameHead[1] = ($masked === true) ? 254 : 126;
            $frameHead[2] = bindec($payloadLengthBin[0]);
            $frameHead[3] = bindec($payloadLengthBin[1]);
        } else {
            $frameHead[1] = ($masked === true) ? $payloadLength + 128 : $payloadLength;
        }

        // convert frame-head to string:
        foreach (array_keys($frameHead) as $i) {
            $frameHead[$i] = chr($frameHead[$i]);
        }
        if ($masked === true) {
            // generate a random mask:
            $mask = array();
            for ($i = 0; $i < 4; $i++) {
                $mask[$i] = chr(rand(0, 255));
            }

            $frameHead = array_merge($frameHead, $mask);
        }
        $frame = implode('', $frameHead);

        // append payload to frame:
        for ($i = 0; $i < $payloadLength; $i++) {
            $frame .= ($masked === true) ? $payload[$i] ^ $mask[$i % 4] : $payload[$i];
        }

        return $frame;
    }

    public function send_telegram($tema, $message)
    {
        $user = Auth::user();
        $site = DB::table('sites')->where('id', $tema->sites_id)->where('my_company_id', $user->my_company_id)->first();
        if (!$site) {

            return 'error01-.' . $site->id;
        }
        $widget = DB::table('widgets')->where('sites_id', $site->id)->where('tip', 8)->first();
        if (!$widget) {
            return 'error02';

        }

        $widget_vk = DB::table('widget_telegram')->where('widget_id', $widget->id)->first();

        if (!$widget_vk) {
            return 'error03';
        }


        $user_id_mess = DB::table('chat_with_client')->where('tema_id', $tema->id)->where('from', 0)->first();
        $user_id = DB::table('widget_telegram_input')->where('my_company_id', $user->my_company_id)->where('vk_user_id', $user_id_mess->input_user_id)->first();
        $ViberApiController = new TelegramController();
        $otvet = $ViberApiController->send_mess($widget_vk->apikey, $user_id->group_id, $message);;


        $idnewmes = DB::table('chat_with_client')->insertgetid([
            'widget_id' => $widget->id,
            'my_company_id' => $site->my_company_id,
            'tip' => 8,
            'input_user_id' => $user_id_mess->input_user_id,
            'mess' => $message,
            'from' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'out_user_id' => $user_id->id,
            'read_input_user_status' => 0,
            'read_out_user_status' => 0,
            'input_mess_id' => 0,
            'tema_id' => $tema->id,

        ]);

        $datal['usermess'] = $tema;
        $datal['mess'] = DB::table('chat_with_client')->where('id', $idnewmes)->first();

        $data['messages'] = view('chat.right_dialog', $datal)->render();
        return json_encode($data);

    }

    public function send_fb($tema, $message)
    {
        $user = Auth::user();
        $site = DB::table('sites')->where('id', $tema->sites_id)->where('my_company_id', $user->my_company_id)->first();
        if (!$site) {

            return 'error01-.' . $site->id;
        }
        $widget = DB::table('widgets')->where('sites_id', $site->id)->where('tip', 7)->first();
        if (!$widget) {
            return 'error02';

        }

        $widget_vk = DB::table('widget_fb')->where('widget_id', $widget->id)->first();

        if (!$widget_vk) {
            return 'error03';
        }


        $user_id_mess = DB::table('chat_with_client')->where('tema_id', $tema->id)->where('from', 0)->first();
        $user_id = DB::table('widget_fb_input')->where('my_company_id', $user->my_company_id)->where('vk_user_id', $user_id_mess->input_user_id)->first();

        $page=WidgetFbPage::find($user_id->page_id);

        $ViberApiController = new FbController();
        $otvet = $ViberApiController->send_mess($widget_vk->apikey, $widget_vk->start_message, $user_id->vk_user_id, $message,$page);;


        $idnewmes = DB::table('chat_with_client')->insertgetid([
            'widget_id' => $widget->id,
            'my_company_id' => $site->my_company_id,
            'tip' => 7,
            'input_user_id' => $user_id_mess->input_user_id,
            'mess' => $message,
            'from' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'out_user_id' => $user_id->id,
            'read_input_user_status' => 0,
            'read_out_user_status' => 0,
            'input_mess_id' => 0,
            'tema_id' => $tema->id,

        ]);

        $datal['usermess'] = $tema;
        $datal['mess'] = DB::table('chat_with_client')->where('id', $idnewmes)->first();

        $data['messages'] = view('chat.right_dialog', $datal)->render();
        return json_encode($data);

    }

    public function send_ok($tema, $message)
    {
        $user = Auth::user();
        $site = DB::table('sites')->where('id', $tema->sites_id)->where('my_company_id', $user->my_company_id)->first();
        if (!$site) {

            return 'error01-.' . $site->id;
        }
        $widget = DB::table('widgets')->where('sites_id', $site->id)->where('tip', 6)->first();
        if (!$widget) {
            return 'error02';

        }

        $widget_vk = DB::table('widget_ok')->where('widget_id', $widget->id)->first();

        if (!$widget_vk) {
            return 'error03';
        }


        $user_id_mess = DB::table('chat_with_client')->where('tema_id', $tema->id)->where('from', 0)->first();
        $user_id = DB::table('widget_ok_input')->where('my_company_id', $user->my_company_id)->where('vk_user_id', $user_id_mess->input_user_id)->first();
        $ViberApiController = new OkApiController();
        $otvet = $ViberApiController->send_mess($widget_vk->apikey, $user_id->group_id, $message);;


        $idnewmes = DB::table('chat_with_client')->insertgetid([
            'widget_id' => $widget->id,
            'my_company_id' => $site->my_company_id,
            'tip' => 6,
            'input_user_id' => $user_id_mess->input_user_id,
            'mess' => $message,
            'from' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'out_user_id' => $user_id->id,
            'read_input_user_status' => 0,
            'read_out_user_status' => 0,
            'input_mess_id' => 0,
            'tema_id' => $tema->id,

        ]);

        $datal['usermess'] = $tema;
        $datal['mess'] = DB::table('chat_with_client')->where('id', $idnewmes)->first();

        $data['messages'] = view('chat.right_dialog', $datal)->render();
        return json_encode($data);

    }

    public function send_viber($tema, $message)
    {
        $user = Auth::user();
        $site = DB::table('sites')->where('id', $tema->sites_id)->where('my_company_id', $user->my_company_id)->first();
        if (!$site) {

            return 'error01-.' . $site->id;
        }
        $widget = DB::table('widgets')->where('sites_id', $site->id)->where('tip', 5)->first();
        if (!$widget) {
            return 'error02';

        }

        $widget_vk = DB::table('widget_viber')->where('widget_id', $widget->id)->first();

        if (!$widget_vk) {
            return 'error03';
        }


        $user_id = DB::table('chat_with_client')->where('tema_id', $tema->id)->where('from', 0)->first();

        $ViberApiController = new ViberApiController();
        $otvet = $ViberApiController->send_mess($widget_vk->apikey, $user_id->input_user_id, $message);;


        $idnewmes = DB::table('chat_with_client')->insertgetid([
            'widget_id' => $widget->id,
            'my_company_id' => $site->my_company_id,
            'tip' => 5,
            'input_user_id' => $user_id->input_user_id,
            'mess' => $message,
            'from' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'out_user_id' => $user_id->id,
            'read_input_user_status' => 0,
            'read_out_user_status' => 0,
            'input_mess_id' => 0,
            'tema_id' => $tema->id,

        ]);

        $datal['usermess'] = $tema;
        $datal['mess'] = DB::table('chat_with_client')->where('id', $idnewmes)->first();

        $data['messages'] = view('chat.right_dialog', $datal)->render();
        return json_encode($data);

    }

    public function send_vk($tema, $message)
    {
        $user = Auth::user();
        $site = DB::table('sites')->where('id', $tema->sites_id)->where('my_company_id', $user->my_company_id)->first();
        if (!$site) {

            return 'error01-.' . $site->id;
        }
        $widget = DB::table('widgets')->where('sites_id', $site->id)->where('tip', 4)->first();
        if (!$widget) {
            return 'error02';

        }

        $widget_vk = DB::table('widget_vk')->where('widget_id', $widget->id)->first();

        if (!$widget_vk) {
            return 'error03';
        }


        $user_id = DB::table('chat_with_client')->where('tema_id', $tema->id)->where('from', 0)->first();

        $Vk_Api = new Vk_Api();
        $otvet = $Vk_Api->_vkApi_call('messages.send', array(
            'peer_id' => $user_id->input_user_id,
            'message' => $message,
            'attachment' => implode(',', array())
        ), $widget_vk);


        $idnewmes = DB::table('chat_with_client')->insertgetid([
            'widget_id' => $widget->id,
            'my_company_id' => $site->my_company_id,
            'tip' => 4,
            'input_user_id' => $user_id->input_user_id,
            'mess' => $message,
            'from' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'out_user_id' => $user_id->id,
            'read_input_user_status' => 0,
            'read_out_user_status' => 0,
            'input_mess_id' => 0,
            'tema_id' => $tema->id,

        ]);

        $datal['usermess'] = $tema;
        $datal['mess'] = DB::table('chat_with_client')->where('id', $idnewmes)->first();

        $data['messages'] = view('chat.right_dialog', $datal)->render();
        return json_encode($data);

    }

    public function send_push($token){
        $url = 'https://fcm.googleapis.com/fcm/send';


        $headers = array(
            "Authorization:key =AAAAuyLEoU4:APA91bFXajGwOURe_JSk7u7jxmsLoZVnCG_rQyZukCqwe6LF4hu1e-sbGf25zR48dAUUGVZ7ZzVje38Y4EFqIr5Wq0RmgiYiAUP1HhsDStJoMO2nmsBfoXgMabFiXYyxNF7s4tXxnQdpOGzb3wpawCDLbspubNmgfg",
            "Content-Type: application/json"
        );

        $send_Data = array(
            "registration_ids" => $token,
            "notification" => array(
                "body"  => "Новое сообщение вчате".date('H:i:s'),
                "title" => "Wistis_Olever",
                "icon"=>"https://autokover.ru/images/logo.png",
                "click_action"=>'https://chat.neiros.ru/'
            )

        );

        $ch = curl_init(); //curl 사용전 초기화 필수
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);                  //0이 default 값이며 POST 통신을 위해 1로 설정
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); //header 지정하기
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);        //이 옵션이 0으로 지정되면 curl_exec의 결과값을 브라우저에 바로 보여준다.
        //이 값을 1로 하면 결과값을 return하게 되어 변수에 저장 가능
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);          //호스트에 대한 인증서 이름 확인
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);      //인증서 확인
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($send_Data));   //POST로 보낼 데이터 지정하기
        //curl_setopt($ch, CURLOPT_POSTFIELDSIZE, 0);         //이 값을 0으로 해야 알아서 &post_data 크기를 측정하는듯

        $res = curl_exec($ch);
        Log::info('-----');
        Log::info($ch);
Log::info($res);
        //에러 발생시 실행
        if ($res === FALSE) {
            Log::info( $ch);
        }

        curl_close($ch);





    }

}
