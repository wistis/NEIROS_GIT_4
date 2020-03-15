<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SSilence\ImapClient\ImapClientException;
use SSilence\ImapClient\ImapConnect;
use DB;
use Log;
use Webklex\IMAP\Client;
use \Webklex\IMAP\Folder;
use App\Http\Controllers\Api\WidgetApiController;
class ImapController extends Controller
{
    public function index($widget,$widget_email){

        $datastcanal=DB::table('widgets_email_static')->where('my_company_id', $widget->my_company_id)->get();

        $datab=[];

        foreach ($datastcanal as $datc){

            $datab[$datc->name_cod]=$datc->id;

        }


        $oClient = new Client([
            'host'          => $widget_email->server,
            'port'          => 993,
            'encryption'    => 'ssl',
            'validate_cert' => true,
            'username'      => $widget_email->login,
            'password'      => $widget_email->password,
        ]);

//Connect to the IMAP Server
        $oClient->connect();

//Get all Mailboxes
        /** @var \Webklex\IMAP\Support\FolderCollection $aFolder */
      $aFolder = $oClient->getFolder('INBOX');

//Loop through every Mailbox
        /** @var \Webklex\IMAP\Folder $oFolder */

if(is_null($widget_email)){
    $date=date('d M Y');
}else{
    $date=date('d M Y',strtotime($widget_email->updated_at));
}
$search_email=explode("@",$widget_email->email);
            $aMessage = $aFolder->searchMessages([['TO', $search_email[0].'+'],['SINCE',$date]]);
/*,*/



        Log::info('mess perebor'.$widget->id.' '.time());
            foreach($aMessage as $oMessage){
                Log::info('mess perebor'.$widget->id.' '.$oMessage->getUid());


$prov=DB::table('widgets_email_input')->where('widget__email_id',$widget_email->id)->where('uid',$oMessage->getUid())->first();
if(!$prov){

    $em=explode('@',$oMessage->to[0]->mail);
    $em1=explode('+',$em[0]);
    var_dump($em1);
if(isset($datab[$em1[1]])){
    $canal=$datab[$em1[1]];
}else{
    $canal=0;
}
    $emailId=DB::table('widgets_email_input')->insertGetId([
      'site_id'=>$widget->sites_id,
      'my_company_id'=>$widget->my_company_id,
      'widget_id'=>$widget->id,
      'widget__email_id'=>$widget_email->id,
      'from'=>$oMessage->from[0]->mail,
      'to'=> $oMessage->to[0]->mail ,
      'subject'=>$oMessage->subject,
      'message'=>$oMessage->getHTMLBody(true),
      'attach'=>$oMessage->getAttachments()->count(),
      'promocod'=>$em1[1],
      'uid'=>$oMessage->getUid(),
      'canal'=>$canal,

      'created_at'=>date('Y-m-d H:i:s'),


    ]);

$WidgetApiController=new WidgetApiController();

    $pnone_email=['email'=>$oMessage->from[0]->mail,'phone'=>'','promocod'=>$em1[1]];
if(isset($oMessage->from[0]->personal)){
    $pnone_email=['email'=>$oMessage->from[0]->mail,'phone'=>'','fio'=>$oMessage->from[0]->personal];
}
    $project_id=$WidgetApiController->create_project('promocod',$em1[1],$widget,$pnone_email);
    DB::table('widgets_email_input')->where('id',$emailId)->update([
       'project_id'=>$project_id
    ]);
}


            }
        $from_name="";
      /*  if(isset($oMessage->from[0]->personal)){
            $from_name=$oMessage->from[0]->personal;
        }*/

            /*from_name*/
DB::table('widgets_email')->where('id',$widget_email->id)->update([
    'updated_at'=>date('Y-m-d H:i:s'),
   // 'from_name'=>$from_name
]);
}
public function imap_test2(){





    $oClient = new Client([
        'host'          => 'imap.yandex.ru',
        'port'          => 993,
        'encryption'    => 'ssl',
        'validate_cert' => false,
        'username'      => 'ceo@wistis.ru',
        'password'      => 'HellRestor',
    ]);

//Connect to the IMAP Server
    try{
        $oClient->connect();
        return 1;
    }catch (\Exception $e){
dd($e);
        return 0;
    }
}


    public function imap_test(Request $request){


        $oClient = new Client([
            'host'          => $request->server1,
            'port'          => 993,
            'encryption'    => 'ssl',
            'validate_cert' => true,
            'username'      => $request->login,
            'password'      => $request->password,
        ]);

//Connect to the IMAP Server
    try{
        $oClient->connect();
        return 1;
    }catch (\Exception $e){

        return 0;
    }





    }
}
