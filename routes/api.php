<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
/*Старый фильтр*/
Route::get('/v1/widget/form/call', 'ApiController@form_call_v1_old');
Route::get('/v1/widget/form/mail', 'ApiController@form_mail_v1_old') ; ;

/*Колбек в не рабочее время*/
Route::post('/v1/widget/form/call',  'ApiController@form_call_v1');
Route::post('/v1/sendcall',  'ApiController@sendcall_to_aster');
/*Обратная связь чат*/
Route::post('/v1/widget/form/mail', 'ApiController@form_mail_v1');
/*Клик по соц сети*/
Route::post('/v1/widget/form/socialclick', 'ApiController@socialclick');
Route::match(['GET','POST'],'/v1/myasterwebhock', 'ApiController@myasterwebhock');







    Route::post('/v1/catch_lead/send_step', 'Api\WidgetApiController@catch_lead_send_step') ; ;
    Route::post('/callback', 'ApiController@callback');
    Route::get('/callback', 'ApiController@callback');
    Route::match(['POST','GET'],'/ajax_form/{key}', 'ApiController@ajax_form');


Route::get('/widget/get/{key}', 'Api\WidgetApiController@get');
Route::get('/widget_site/get_bot/{key}', 'Api\WidgetApiController@get_bot');
Route::post('/widget_site/get_bot_metrika/{key}', 'Api\WidgetApiController@get_bot_metrika');
Route::get('/widget_site/get/{key}', 'Api\WidgetApiController@get_widget_site');

Route::post('/popup/{key}', 'Api\WidgetApiController@popup_input');
Route::post('/popup_doit/{key}', 'Api\WidgetApiController@popup_doit');
Route::post('/inputjs/{key}', 'Api\WidgetApiController@inputjs');
Route::get('/inputjs/{key}', 'Api\WidgetApiController@inputjs');




Route::post('/vkapi/callback_handleEvent/{key}', 'VkApiController@callback_handleEvent');
Route::get('/vkapi/callback_handleEvent/{key}', 'VkApiController@callback_handleEvent');
Route::post('/viberapi/callback_handleEvent/{key}', 'ViberAPI\ViberApiController@callback_handleEvent');
Route::post('/okapi/callback_handleEvent/{key}', 'OkApi\OkApiController@callback_handleEvent');
Route::match(['GET','POST'],'/fbapi/callback_handleEvent', 'FbApi\FbController@callback_handleEvent');
Route::match(['GET','POST'],'/fromasteraudio', 'ApiController@fromasteraudio');
Route::match(['GET','POST'],'/telegram/callback_handleEvent/{key}', 'ApiTelegram\TelegramController@callback_handleEvent');
Route::get('/widgetchatjs/{id}', 'Api\WidgetApiController@widgetchatjs');
Route::get('/widgetcallback/{id}', 'Api\WidgetApiController@widgetcallbackjs');
Route::get('/widgetcatchlead/{id}', 'Api\WidgetApiController@widgetcatchlead');

Route::get('/bitrix24', 'BitrixController@bitrix24');
Route::post('/bitrix24', 'BitrixController@bitrix24');

Route::match(['get','post'],'/jivosite/webhook/{key}', 'JivoSiteController@jivosite');

Route::match(['get','post'],'/webhook/amocrm', 'AmoCrmApiController@webhook');
Route::match(['get','post'],'/bt24callback', 'BitrixController@bt24callback');
Route::match(['get','post'],'/android', 'BitrixController@android');
Route::match(['get','post'],'/android2', 'BitrixController@android2');
Route::match(['get','post'],'/android3', 'BitrixController@android3');
Route::match(['get','post'],'/android4', 'BitrixController@android4');
Route::match(['get','post'],'/webhook/tilda/{id}', 'ApiController@tilda');
Route::match(['get','post'],'/gdrive', 'ApiController@gdrive');

Route::get('/route_widget/{apitouter}/{devise}/{hash}/{widget}','ApiController@route_widget');

Route::get('yandextalk',function (){

    return 'OK';
});

