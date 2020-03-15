<?php

namespace App\Http\Controllers\VkApi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log;
class VkApiController extends Controller
{
    public function __construct(){


//        define('VK_API_VERSION', '5.67'); //Используемая версия API
        //define('VK_API_ENDPOINT', 'https://api.vk.com/method/');
    }


    function vkApi_messagesSend($peer_id, $message, $attachments = array()) {
          $VkApiController=new VkApiController();
        return $VkApiController->_vkApi_call('messages.send', array(
            'peer_id'    => $peer_id,
            'message'    => $message,
            'attachment' => implode(',', $attachments)
        ));
    }

    static function vkApi_usersGet($user_id,$widget_vk) {
        $VkApiController=new VkApiController();
        return $VkApiController->_vkApi_call('users.get', array(
            'user_id' => $user_id,'fields'=>'photo_50,city,verified,photo_200'
        ),$widget_vk);
    }

    function vkApi_photosGetMessagesUploadServer($peer_id) {
        return $this->_vkApi_call('photos.getMessagesUploadServer', array(
            'peer_id' => $peer_id,
        ));
    }

    function vkApi_photosSaveMessagesPhoto($photo, $server, $hash) {
        return $this->_vkApi_call('photos.saveMessagesPhoto', array(
            'photo'  => $photo,
            'server' => $server,
            'hash'   => $hash,
        ));
    }

    function vkApi_docsGetMessagesUploadServer($peer_id, $type) {
        return $this->_vkApi_call('docs.getMessagesUploadServer', array(
            'peer_id' => $peer_id,
            'type'    => $type,
        ));
    }

    function vkApi_docsSave($file, $title) {
        return $this->_vkApi_call('docs.save', array(
            'file'  => $file,
            'title' => $title,
        ));
    }

    function _vkApi_call($method, $params = array(),$widget_vk=null) {
        $params['access_token'] = $widget_vk->apikey;
        $params['v'] = '5.80';

        $query = http_build_query($params);
        $url = 'https://api.vk.com/method/'.$method.'?'.$query;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($curl);
        $error = curl_error($curl);
        if ($error) {
            Log::info($error);
            throw new Exception("Failed {$method} request");
        }

        curl_close($curl);

        $response = json_decode($json, true);
        if (!$response || !isset($response['response'])) {
            Log::info($json);
     //       throw new Exception("Invalid response for {$method} request");
        }

        return $response['response'];
    }

    function vkApi_upload($url, $file_name) {
        if (!file_exists($file_name)) {
            throw new Exception('File not found: '.$file_name);
        }

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, array('file' => new CURLfile($file_name)));
        $json = curl_exec($curl);
        $error = curl_error($curl);
        if ($error) {
            Log::info($error);
            throw new Exception("Failed {$url} request");
        }

        curl_close($curl);

        $response = json_decode($json, true);
        if (!$response) {
            throw new Exception("Invalid response for {$url} request");
        }

        return $response;
    }

}
