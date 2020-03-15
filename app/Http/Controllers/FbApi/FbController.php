<?php

namespace App\Http\Controllers\FbApi;

use App\Models\Fb\WidgetFbPage;
use App\Widgets;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;
use DB;
use App\Project;
use App\Http\Controllers\Api\WidgetApiController;
use pimax\FbBotApp;
use pimax\Messages\Message;
use pimax\Messages\MessageButton;
use pimax\Messages\StructuredMessage;
use pimax\Messages\MessageElement;
use pimax\Messages\MessageReceiptElement;
use pimax\Messages\Address;
use pimax\Messages\Summary;
use pimax\Messages\Adjustment;
use \Facebook\Facebook;

class FbController extends Controller
{
    public $fb;

    public $helper;
    public $_accessToken;
    public $widget;

    public function __construct()
    {

        $this->fb = new  Facebook([
            'app_id' => 629941544445367,
            'app_secret' =>'f76589abcb32b761cd02f39fcb72105b',
        ]);
       /* if($this->getuser()==1) {dd(1);
            $this->fb = new  Facebook([
                'app_id' => 629941544445367,
                'app_secret' =>'f76589abcb32b761cd02f39fcb72105b',
            ]);
        }else{
            $this->fb = new  Facebook([
                'app_id' => 629941544445367,
                'app_secret' =>'f76589abcb32b761cd02f39fcb72105b',
            ]);

        }*/

        $this->helper = $this->fb->getRedirectLoginHelper();

    }
public function getuser(){
        return auth()->user()->my_company_id;
}

    public function get_url_for_token()
    {

  if(auth()->user()->my_company_id==1){

      $permissions = ['email', 'manage_pages','pages_messaging' ,'instagram_basic','pages_show_list'];
      $loginUrl = $this->helper->getLoginUrl($_ENV['FB_CALLBACK'], $permissions);
      return '<a href="' . htmlspecialchars($loginUrl) . '" class="btn  " style="background: #4267B2;color: white;font-weight: bold" target="_blank">Продолжить с Facebook</a>';
  }else{
        $permissions = ['email', 'manage_pages','pages_messaging' ];
        $loginUrl = $this->helper->getLoginUrl($_ENV['FB_CALLBACK'], $permissions);
        return '<a href="' . htmlspecialchars($loginUrl) . '" class="btn  " style="background: #4267B2;color: white;font-weight: bold" target="_blank">Продолжить с Facebook</a>';}
    }

    public function get_pages_from_token()
    {
 
        $response = $this->fb->get(
            '/me/accounts',
            $this->_accessToken
        );

        $data = json_decode($response->getBody());

        WidgetFbPage::where('widget_fb_id', $this->widget->id)->delete();
        for ($i = 0; $i < count($data->data); $i++) {
            $model = new WidgetFbPage();
            $model->widget_fb_id = $this->widget->id;
            $model->my_company_id = $this->widget->my_company_id;
            $model->site_id = auth()->user()->get_site->id;
            $model->fb_id = $data->data[$i]->id;
            $model->token = $data->data[$i]->access_token;

            $model->name = $data->data[$i]->name;
try {
    $k = file_get_contents('https://graph.facebook.com/v5.0/' . $data->data[$i]->id . '?fields=instagram_business_account&access_token=' . $data->data[$i]->access_token);
    $inid = json_decode($k);

    if(isset($inid->instagram_business_account->id)){
        $model->instaid=$inid->instagram_business_account->id;
    }
}catch (\Exception $e){

}


            $model->save();

             $this->fb->post(
                '/'. $data->data[$i]->id.'/subscribed_apps',['subscribed_fields'=>'message_deliveries,messages,messaging_optins,messaging_postbacks'],
                 $data->data[$i]->access_token
             );

        }
        $w=Widgets::find($this->widget->widget_id);
        $w->status=1;
        $w->save();

    }

    public function get_token()
    {
        session_start();
        $this->widget = auth()->user()->get_site->get_widget_on(7)->w7;


        if (request()->get('code')) {


            if (request()->get('state')) {
                $this->helper->getPersistentDataHandler()->set('state', request()->get('state'));

            }

            $accessToken = $this->helper->getAccessToken();


            $this->_accessToken = $accessToken->getValue();
            $this->widget->apikey = $this->_accessToken;
            $this->widget->save();

            $this->get_pages_from_token();

        }else{

        };
        if (request()->get('error')) {

            session()->flash('fb_error');

        } else {
            session()->flash('fb_sucess');
        }
        return redirect('/widget/tip/10');
    }

    public function error_access()
    {

        if ($this->helper->getError()) {
            header('HTTP/1.0 401 Unauthorized');
            echo "Error: " . $this->helper->getError() . "\n";
            echo "Error Code: " . $this->helper->getErrorCode() . "\n";
            echo "Error Reason: " . $this->helper->getErrorReason() . "\n";
            echo "Error Description: " . $this->helper->getErrorDescription() . "\n";
        } else {
            header('HTTP/1.0 400 Bad Request');
            echo 'Bad request';
        }
        exit;
    }

    public function callback_handleEvent(Request $request)
    {
        Log::useFiles(base_path() . '/storage/logs/facebook.log', 'info');
        Log::info($request->all());
        $input_data = $request->all();

if(isset($_REQUEST['hub_challenge'])){
    return $_REQUEST['hub_challenge'];
}

        if (!isset($input_data['entry'][0]['messaging'])) {
            return '';
        }
        $data_mess = $input_data['entry'][0]['messaging'];
        $page_id = $input_data['entry'][0]['id'];

        $WidgetFbPage = WidgetFbPage::with('widgetfb')->where('fb_id', $page_id)->first();
        if (!$WidgetFbPage) {
            return '';
        }
        $widgetFb=$WidgetFbPage->widgetfb;
        $widget=$widgetFb->widget;
        $site=$widget->sites;
        $token = $widgetFb->start_message;
        $bot = new FbBotApp($token);





                foreach ($data_mess as $message) {
                    $userProfile = $bot->userProfile($message['sender']['id']);


                    $datauser['id'] = $message['sender']['id'];
                    $datauser['LastName'] = $getLastName = $userProfile->getLastName();
                    $datauser['FirstName'] = $getLastName = $userProfile->getFirstName();
                    $datauser['Picture'] = $getLastName = $userProfile->getPicture();


                    $this->input_message($site, $widget, $widgetFb, $message, $datauser,$WidgetFbPage);;


                }



    }

    public function input_message($site, $widget, $widget_ok, $data, $datauser,$WidgetFbPage)
    {

        $widget_vk_input_id = DB::table('widget_fb_input')->insertGetId([
            'user_id' => $site->user_id,
            'my_company_id' => $site->my_company_id,
            'widget_id' => $widget->id,
            'widget_vk_id' => $widget_ok->id,

            //  'mess_id'=>$data_ev,
            'date' => time(),
            //'out'=>$data['object']['out']//,
            'vk_user_id' => $data['sender']['id'],
            // 'read_state'=>$data['object']['read_state'],
            //   'title'=>$data['object']['title'],
            'body' => $data['message']['text'],
            'page_id' =>$WidgetFbPage->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        /*(`id`, `my_company_id`, `user_id`, `widget_id`, `vk_user_id`, `first_name`, `created_at`, `updated_at`, `tema_id`)*/
        $prov_vk_user = DB::table('widget_fb_users')->where('vk_user_id', $data['sender']['id'])->first();
        if (!$prov_vk_user) {
            $data['user'] = $data['sender'];
            $tema_id = $this->create_ok_user($datauser, $widget_ok, $widget, $site);
        } else {

            $tema_id = $prov_vk_user->tema_id;
            DB::table('chat_tema')->where('id', $tema_id)->update([
                'status' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
        /*INSERT INTO `chat_with_client`(`id`, `my_company_id`, `widget_id`, `tip`, `input_user_id`, `mess`, `from`, `updated_at`, `created_at`, `out_user_id`, `read_input_user_status`, `read_out_user_status`) */
        $mess_id = DB::table('chat_with_client')->insertGetId([
            'widget_id' => $widget->id,
            'my_company_id' => $site->my_company_id,
            'tip' => 7,
            'input_user_id' => $data['sender']['id'],
            'mess' => $data['message']['text'],
            'from' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'out_user_id' => 0,
            'read_input_user_status' => 0,
            'read_out_user_status' => 0,
            'input_mess_id' => $widget_vk_input_id,
            'tema_id' => $tema_id,

        ]);




        $datatochat['hash'] = $tema_id;
        $datatochat['hiddenmes'] = $mess_id;
        $datatochat['typ'] = 4;
        $datatochat['admin'] = $site->hash;
        \Ratchet\Client\connect('wss://cloud.neiros.ru/wss2/robot')->then(function($conn)use($site,$tema_id,$data,$mess_id) {
            \Log::info('viber 36');

            $conn->send('{
        "mess_id":"'.$mess_id.'",
        
        "message":"newmess","hash":"robot","tema_id":"'.$tema_id.'","site":"'.$site->hash.'","admin":0,"my_company_id":"'.md5($site->my_company_id).'","tip_message":"text","typ":7}');$conn->close();
        }, function ($e) {
            echo "Could not connect: {$e->getMessage()}\n";
        });



    }

    public function send_mess($apikey, $start_message, $user_id, $message,$page)
    {Log::info('sendMess');
    Log::info($user_id);
        $bot = new FbBotApp($page->token);
        return $bot->send(new Message($user_id, $message));
        //  $VkBotGlobalController->bot_sendMessage($user_id,$site,$widget,$widget_vk);
    }

    public function create_message()
    {

    }

    public function create_ok_user($datauser, $widget_ok, $widget, $site)
    {
        /*(`id`, `my_company_id`, `user_id`, `widget_id`, `vk_user_id`, `first_name`, `created_at`, `updated_at`, `tema_id`)*/

        /*array (
    'id' => '1777243918978503',
    'LastName' => 'Wistis',
    'FirstName' => 'Vitalik',
    'Picture' => 'https://platform-lookaside.fbsbx.com/platform/profilepic/?psid=1777243918978503&width=1024&ext=1530865426&hash=AeRcwXLAyXiY1mSz',
  ),*/
        $prov_vk_user = DB::table('widget_fb_users')->where('vk_user_id', $datauser['id'])->first();
        if (!$prov_vk_user) {


            DB::table('widget_fb_users')->insert([
                'user_id' => $site->user_id,
                'my_company_id' => $site->my_company_id,
                'widget_id' => $widget->id,
                'vk_user_id' => $datauser['id'],
                'first_name' => $datauser['LastName'] . ' ' . $datauser['FirstName'],
                // 'last_name'=>$user['last_name'],
                'photo_50' => $datauser['Picture'],

                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),

                'tema_id' => 0,

            ]);

            $data_w['fio']= $datauser['LastName'] . ' ' . $datauser['FirstName'].'(FB)';
            $getallwid = Project::where('widget_id', $widget->id)->count();
            $getallwid++;
            $WidgetApiController=new WidgetApiController();

            $neiros_visit=$WidgetApiController->get_neiros_visit(7,$widget->sites_id);
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
            $idtmus = DB::table('chat_tema')->where('my_company_id', $site->my_company_id)->count();
            $hid_id = $idtmus + 1;
            $tema_id = DB::table('chat_tema')->insertgetid([
                'name' => $datauser['LastName'] . ' ' . $datauser['FirstName'],
                'image' => '',
                'tip' => 7,
                'my_company_id' => $site->my_company_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'status' => 0,
                'sites_id' => $site->id,
                'hid_id' => $hid_id,
                'project_id'=>$projectId,
                'neiros_visit'=>$neiros_visit,
            ]);

            DB::table('widget_fb_users')->where('vk_user_id', $datauser['id'])->update(['tema_id' => $tema_id]);
            return $tema_id;
        }
    }
}
