<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Log;
use Auth;
class RunexisController extends Controller
{



    public function send_sms($sms_code,$phone){

        $phone = $phone;
        $phone = str_replace('+', '', $phone);
        $phone = str_replace('-', '', $phone);
        $phone = str_replace(')', '', $phone);
        $phone = str_replace('(', '', $phone);
        $phone = str_replace(' ', '', $phone);


            $headers = array(
                // OAuth-токен. Использование слова Bearer обязательно
                "Authorization: Bearer cEv8PxuGo4c1LtKOjUjJHfqt5MBVavdO",
                // Логин клиента рекламного агентства
                "Content-Type: application/json",

            );
       // '{"jsonrpc":"2.0", "method":"sms/send", "id":"1", "params":{"from":"79991111111","to":"79692222222", "reject_long":true, "text":"test sms"}}
// Инициализация cURL
$body='{"jsonrpc":"2.0", "method":"sms/send", "id":"1", "params":{"from":"79770009416","to":"'.$phone.'", "reject_long":true, "text":"Neiros code:'.$sms_code.'"}}';



        $result = file_get_contents('https://sms-api.runexis.ru', null, stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Authorization: Bearer cEv8PxuGo4c1LtKOjUjJHfqt5MBVavdO' . "\r\n". 'Content-Type: application/json' . "\r\n"
                    . 'Content-Length: ' . strlen($body) . "\r\n",
                'content' => $body,
            ),
        )));


    }
    public function send_sms_1($sms_code,$phone){

        $phone = $phone;
        $phone = str_replace('+', '', $phone);
        $phone = str_replace('-', '', $phone);
        $phone = str_replace(')', '', $phone);
        $phone = str_replace('(', '', $phone);
        $phone = str_replace(' ', '', $phone);


        $headers = array(
            // OAuth-токен. Использование слова Bearer обязательно
            "Authorization: Bearer cEv8PxuGo4c1LtKOjUjJHfqt5MBVavdO",
            // Логин клиента рекламного агентства
            "Content-Type: application/json",

        );
        // '{"jsonrpc":"2.0", "method":"sms/send", "id":"1", "params":{"from":"79991111111","to":"79692222222", "reject_long":true, "text":"test sms"}}
// Инициализация cURL
        $body='{"jsonrpc":"2.0", "method":"sms/send", "id":"1", "params":{"from":"79770009416","to":"'.$phone.'", "reject_long":true, "text":"'.$sms_code.'"}}';



        $result = file_get_contents('https://sms-api.runexis.ru', null, stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Authorization: Bearer cEv8PxuGo4c1LtKOjUjJHfqt5MBVavdO' . "\r\n". 'Content-Type: application/json' . "\r\n"
                    . 'Content-Length: ' . strlen($body) . "\r\n",
                'content' => $body,
            ),
        )));
        info('Отправка смс');
info($result);info($body);
        info('Отправка смс');
    }
    public function bayphone($amount,$region,$widget_id,$my_company_id){


        $array_phone2=[];

        $token=$this->rpc_did_api_connect('vog@olever.ru','h?PJPacH8uaP');

       $phones= $this->get_numbe( $token->result ,$amount,$region);

       /*INSERT INTO `widgets_phone`(`id`, `widget_id`, `phone`, `time`, `my_company_id`, `rezerv`, `input`, `provider`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8])*/
        $array_phone=[];
      ;$amount_phones=count($phones->result);
      if($amount_phones>0) {
          for ($i = 0; $i < count($phones->result); $i++) {

              DB::table('widgets_phone')->insert([
                  'widget_id' => $widget_id,
                  'phone' => '7' . $phones->result[$i]->full_number,
                  'time' => 0,
                  'my_company_id' => $my_company_id,
                  'rezerv' => 0,
                  'input' => '7' . $phones->result[$i]->full_number,
                  'new' => 0,
                  'created_at' => date('Y-m-d')


              ]);

              DB::table('bay_phones')->insert([
               'phone'=>   '7' . $phones->result[$i]->full_number,
                  'my_company_id' => $my_company_id,
                  'created_at' => date('Y-m-d'),
                  'updated_at' =>date('Y-m-d'),
                  'was_deleted' => 0,


              ]);




              $array_phone[] = $phones->result[$i]->full_number;
        $array_phone2[]= '7' . $phones->result[$i]->full_number;

          }

          //  dd(json_encode($array_phone));

          $rezerv = $this->rezerv($token->result, $array_phone);


          $rezerv = $this->install($token->result, $array_phone);
      }

        $data['phones']=[];
if($amount_phones==0){
    $data['status']=0;
    $data['message']='Отсутствуют номераданного региона';
}else{
    $data['status']=$amount_phones;
    $data['message']=$amount_phones;
    $data['phones']=$array_phone2;
}
return $data;
    }



/*{ "jsonrpc" : "2.0" , "method" : "return_numbers" , "params" : [ "<session-id>" , [ <numbers> ] ] , "id" : 21 }*/

    public function deleteNumber( $number_array){
$user=Auth::user();
Log::info($number_array);
Log::info($user->my_company_id);
       DB::table('bay_phones')->where('phone','7'.$number_array[0])->where('my_company_id',$user->my_company_id)->update([  'updated_at' =>date('Y-m-d'),
          'was_deleted' => 1,   ]);

        $token=$this->rpc_did_api_connect('vog@olever.ru','h?PJPacH8uaP');



       $res=$this->rpc_did_api_send_request(

            '{ "jsonrpc" : "2.0" , "method" : "return_numbers" , "params" : [ "'.$token->result.'" , '.json_encode($number_array).' ] , "id" : 21 }');



    }

    public function get_perator($token){

        return(

        $this->rpc_did_api_send_request(

            '{ "jsonrpc" : "2.0" , "method" : "get_operators" , "params" : [ "'.$token.'" ] , "id" : 16 }'

        )

        );

    }

    public function index(){

//$res=$this->rpc_did_api_connect('vog@olever.ru','0123456789');

  //      dd( $res );

$res=$this->get_region( "jl403b720i2j3rlktan9s3r3h1" );





    }

    public function get_region($token){

        return(

        $this->rpc_did_api_send_request(

            '{ "jsonrpc" : "2.0" , "method" : "get_regions" , "params" : [ "'.$token.'" ] , "id" : 13 }'

        )

        );

    }
    public function install($token,$array_phone){
        /**/
        return(

        $this->rpc_did_api_send_request(

            '
{ "jsonrpc" : "2.0" , "method" : "install_numbers" , "params" : [ "'.$token.'" , '.json_encode($array_phone).' , "01.2346" , "819" ] , "id" : 20 }'

        )

        );

    }
    public function rezerv($token,$array_phone){
  /**/
        return(

        $this->rpc_did_api_send_request(

            '
{ "jsonrpc" : "2.0" , "method" : "sell_numbers" , "params" : [ "'.$token.'" , '.json_encode($array_phone).' ] , "id" : 5 }'

        )

        );

    }


    public function get_numbe( $token, $amount,$region)

    {
 
        return(

        $this->rpc_did_api_send_request(

            '{ "jsonrpc" : "2.0" , "method" : "search_numbers" , "params" : [ "'.$token.'" , { "usage_statuses" : ["free"],"city_code" :"'.$region.'","number_type":"0"} , "0" , "'.$amount.'" ] , "id" : 9 }'

        )

        );

    }
    public function rpc_did_api_connect( $Login , $Password )

    {

        return(

        $this->rpc_did_api_send_request(

            '{ "jsonrpc" : "2.0" , "method" : "connect" , "params" : [ "'.$Login.

            '" , "'.$Password.'" ] , "id" : 1 }'

        )

        );

    }

   public function			rpc_did_api_send_request( $Parameters )

    {

         		$DIDAPIHost='https://did-api.tellan.ru/';



        $PostParameters = array( 'jsonrpc' => $Parameters );



        $Result = $this->send_post_request( $DIDAPIHost , '' , $PostParameters );



        $Result = json_decode( $Result );



        return( $Result  );

    }
  public  function			send_post_request( $Host , $URL , $PostParameters )

    {

        $Params = array();

        foreach( $PostParameters as $Key => $Value )

        {

            $Params [] = $Key.'='.$Value;

        }



        $Curl = curl_init();

        curl_setopt( $Curl , CURLOPT_FOLLOWLOCATION , 1 );

        curl_setopt( $Curl , CURLOPT_MAXREDIRS , 5 );

        curl_setopt( $Curl , CURLOPT_POST , 1 );

        curl_setopt( $Curl , CURLOPT_POSTFIELDS , $PostParameters );

        curl_setopt( $Curl , CURLOPT_RETURNTRANSFER , 1 );

        curl_setopt( $Curl , CURLOPT_SSL_VERIFYPEER , 0 );

        curl_setopt( $Curl , CURLOPT_URL , "$Host/$URL" );

        curl_setopt( $Curl , CURLOPT_REFERER , "$Host/" );

        $Result = curl_exec( $Curl );



        if( $Result === false )

        {

            $Error = curl_error( $Curl );

            curl_close( $Curl );

          //  throw( new Exception( $Error ) );

        }

        else

        {

            curl_close( $Curl );

        }



        return( $Result );

    }
}
