<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes(); Route::get('widget/tip',
    function (){
        return abort(404);
    });
Route::get('/wwww', 'AjaxController@widget_api_routers');
Route::middleware(['auth','webs','operator'])->group(function () {


    Route::get('projects2','ProjectController@project2');//Форма редактирования
    Route::get('alldata/data','ProjectController@anyData');//Форма редактирования
    Route::post('alldata/data','ProjectController@anyData');//Форма редактирования


    Route::group(['domain' => 'cloud.neiros.ru'], function()
    {


        Route::get( '/reportsconstruct/{url}', 'ReportsController@reportsconstruct');

    Route::get('/home', 'IndexController@index');
    Route::get('/', 'IndexController@index');
    Route::get( '/allreports', 'ReportsController@index')->name('allreports');
    Route::get( '/allreports/setting', 'ReportsController@setting')->name('allreports.setting');
    Route::post( '/allreports/setting', 'ReportsController@setting')->name('allreports.setting');
    Route::post( '/allreports/{url}', 'ReportsController@index_ajax');


    Route::get('/widgetchat', 'ChatController@widgetchat');



        Route::get( '/allreports/get_all_data', 'ReportsController@get_all')->name('allreportsget_all');
        Route::get('/allreports/alldata/data','ReportsController@anyData');//Форма редактирования
        Route::post('/allreports/alldata/data','ReportsController@anyData');



        Route::get( '/allnewreports/{neiros_p0?}/{neiros_p1?}/{neiros_p2?}/{neiros_p3?}/{neiros_p4?}', 'AllNewReportsController@index')->name('allnewreports');
        Route::post( '/allnewreports/{url}', 'AllNewReportsController@index_ajax');
        Route::get('/allnewreports_table/{type_report}', 'AllNewReportsController@reports_table');
        Route::get('/allnewreports_table_direct/{type_report}', 'AllNewReportsController@reports_table_direct');
        Route::get('/allnewreports_table_adwords/{type_report}', 'AllNewReportsController@reports_table_adwords');
    /*
     Route::get('user/profile', function () {
         // Uses first & second Middleware
     });*/
/**/
/*Проекты*/


    Route::group([ 'prefix' => 'projects'], function () {///Проекты

    Route::get('add','ProjectController@add_view'); //Форма добавления
    Route::post('add','ProjectController@add_post');//Запрос на добавленник

    Route::get('edit/{id}','ProjectController@edit_view');//Форма редактирования
    Route::post('update','ProjectController@edit_post');//Запрос редактирования

    Route::get('/','ProjectController@get_all');//Все проэкты


    Route::post('edit/updatestage','ProjectController@updatestage');//Запись перетаскивания
    Route::post('get_form_task','ProjectController@get_form_task');//Запись перетаскивания
    Route::post('get_form_client','ProjectController@get_form_client');//Запись перетаскивания
    Route::post('start_date','ProjectController@start_date');//Запись перетаскивания
    Route::post('get_email_modal','ProjectController@get_email_modal');//Запись перетаскивания
    Route::post('save_field','ProjectController@save_field');//Запись перетаскивания
    Route::post('banclient','ProjectController@banclient');//Запись перетаскивания
    Route::get('get_all_email','EmailController@get_all');//Запись перетаскивания

        Route::get('/{ids}','ProjectController@get_all_ids');//Все проэкты

    Route::post('project_vid','ProjectController@project_vid');//Запись перетаскивания
    });
/*Проекты*/

/*Задачи*/

/*Задачи*/
        Route::group([ 'prefix' => 'contacts'], function () {///Проекты



            Route::get('edit/{id}','ClientController@edit_view');//Форма редактирования
            Route::post('edit/','ClientController@edit_post');//Форма редактирования
            Route::post('add_ajax','ClientController@add_ajax');//Форма редактирования
            Route::post('add_ajax_2','ClientController@add_ajax_2');//Форма редактирования



            Route::get('/','ClientController@get_all');//Все проэкты
            Route::delete('/del/{id?}','ClientController@destroy');//Все проэкты


            Route::get('create','ClientController@create');//Форма редактирования

        });
    /*Контакты*/
    Route::group([ 'prefix' => 'contacts'], function () {///Проекты



        Route::get('edit/{id}','ClientController@edit_view');//Форма редактирования
        Route::post('edit/','ClientController@edit_post');//Форма редактирования
        Route::post('add_ajax','ClientController@add_ajax');//Форма редактирования
        Route::post('add_ajax_2','ClientController@add_ajax_2');//Форма редактирования



        Route::get('/','ClientController@get_all');//Все проэкты
        Route::delete('/del/{id?}','ClientController@destroy');//Все проэкты


        Route::get('create','ClientController@create');//Форма редактирования

    });




    Route::post('widget/addphone','WidgetController@addphone');//Форма редактирования
    Route::post('widget/deletephone','WidgetController@deletephone');//Форма редактирования

        Route::resource('widget', WidgetController::class);
        Route::get('widget/tip/{id}', 'WidgetController@widget_tip');






        Route::get('widget/create_new_form/{id}/{pop?}', 'FormBuildnerController@createform');
        Route::get('create_pole', 'FormBuildnerController@create_pole');
        Route::post('widget/doform/{tip}', 'FormBuildnerController@doform');


        Route::get('/tickets/', 'Tickets\TicketsController@index')->name('wtickets.list');
        Route::get('/tickets/complete', 'Tickets\TicketsController@index_complete')->name('wtickets.complete')->middleware('isadmin');;
        Route::get('/tickets/admin_panel', 'Tickets\TicketsController@admin_panel')->name('wtickets.admin_panel')->middleware('isadmin');
        Route::get('/tickets/admin_panel/0', 'Tickets\TicketsController@subject')->name('wtickets.admin_panel.subject')->middleware('isadmin');;
        Route::match(['get','post'],'/tickets/admin_panel/0/create', 'Tickets\TicketsController@subject_create')->name('wtickets.admin_panel.subject.create')->middleware('isadmin');;
        Route::match(['get','post'],'/tickets/admin_panel/0/delete/{id}', 'Tickets\TicketsController@subject_delete')->name('wtickets.admin_panel.subject.subject_delete')->middleware('isadmin');;
        Route::match(['get','post'],'/tickets/admin_panel/0/edit/{id}', 'Tickets\TicketsController@subject_edit')->name('wtickets.admin_panel.subject.edit')->middleware('isadmin');


        Route::get('/tickets/view/{id}', 'Tickets\TicketsController@view')->name('wtickets.view');
        Route::get('/tickets/view/{id}/completed', 'Tickets\TicketsController@completed')->name('wtickets.set.completed');
        Route::get('/tickets/view/{id}/reopen', 'Tickets\TicketsController@reopen')->name('wtickets.set.reopen');
        Route::get('/tickets/delete/{id}', 'Tickets\TicketsController@delete')->name('wtickets.delete');
        Route::get('/tickets/create', 'Tickets\TicketsController@create')->name('wtickets.create');
        Route::post('/tickets/create', 'Tickets\TicketsController@store')->name('wtickets.store');
        Route::post('/tickets/add_comment', 'Tickets\TicketsController@add_comment')->name('wtickets.add_comment');



    /*Контакты*/
    /*Настройки*/
    Route::group([ 'prefix' => 'setting'], function () {///Проекты
        Route::get('partners', 'PartnersController@index');

        Route::get('billing_all', 'BillingController@billing_all');
        Route::get('billing/phones', 'BillingController@phones');
        Route::post('billing/add_rashod', 'BillingController@add_rashod');
        Route::get('billing/recs', 'BillingController@recs');
        Route::match(['post','get'],'advertisingchannel/delete1', 'Advertising_channelController@delete1');

        Route::resource('tarifs', TarifsController::class)->middleware('isadmin');;
        Route::resource('stages', StagesController::class);
        Route::resource('smsreports',  Reports\SmsReportsController::class);
        Route::resource('admintm', AdminTMController::class)->middleware('isadmin');;
        Route::resource('messages', Admin_messagesController::class);
        Route::post('stages/updatesort', 'StagesController@updatesort');



        Route::resource('projectfield', FieldController::class);
        Route::resource('clientfield', FieldClientController::class);

        Route::resource('users', UsersController::class);
        Route::post('/users/getajaxuser', 'UsersController@getajaxuser');
        Route::post('/users/set_user_group', 'UsersController@set_user_group');
        Route::post('/users/saveajaxuser', 'UsersController@saveajaxuser');
        Route::post('/users/getnewuser', 'UsersController@getnewuser');
        Route::post('/usersgroup/saveajaxgroup', 'UsersGroupdsController@store');
        Route::resource('usersgroup', UsersGroupdsController::class);
        Route::get('sites/reloadwidget', 'SitesController@reloadwidget');
        Route::post('sites/del/{id}', 'SitesController@delete_site');


        Route::resource('sites', SitesController::class);
        Route::post('sites/create', 'SitesController@sms_code');

        Route::resource('paycompanys', PayCompanyController::class);
        Route::resource('checkcompanys',CheckcompanysControllers::class);
        Route::get('checkcompanys/getschet/{id}','CheckcompanysControllers@getschet');



        Route::resource('adminclient', AdminclientController::class)->middleware('isadmin');
        Route::get('adminclient/set_active/{id}', 'AdminclientController@set_active')->middleware('isadmin');


        Route::get('/loginas/{id}', 'AdminclientController@loginas');




    });
    /*Настройки*/
    /*Статистика*/
    Route::group([ 'prefix' => 'stat'], function () {///Проекты


        Route::get('callback', 'CallStaticController@index');
        Route::get('other', 'CallStaticController@other');
        Route::post('other_ajax', 'CallStaticController@other_ajax');
        Route::get('generate_1', 'CallStaticController@generate_1');
        Route::get('generate_2', 'CallStaticController@generate_2');
        Route::get('generate_3', 'CallStaticController@generate_3');
        Route::get('generate_4', 'CallStaticController@generate_4');
        Route::post('start_date', 'CallStaticController@start_date');
        Route::post('start_load_data', 'CallStaticController@start_load_data');
        Route::post('two_load_data', 'CallStaticController@two_load_data');
        Route::post('tree_load_data', 'CallStaticController@tree_load_data');
        Route::get('phscript/catalog','PhscriptController@catalog');
        Route::get('phscript/read_data/{id}','PhscriptController@read_data');
        Route::match(['POST','GET'],'phscript/script_tab_conversion/{id}','PhscriptController@script_tab_conversion');
        Route::match(['POST','GET'],'phscript/script_tab_togoal/{id}','PhscriptController@script_tab_togoal');
        Route::match(['POST','GET'],'phscript/script_tab_productivity/{id}','PhscriptController@script_tab_productivity');
        Route::post('phscript/ajax/{tip_zaprpos}','PhscriptController@ajax');
        Route::post('phscript_get_data/{id}','PhscriptController@phscript_get_data');
        Route::get('phscript/read/{id}','PhscriptController@readscript');
        Route::get('phscript','PhscriptController@index');
        Route::get('phscript/{id}','PhscriptController@update');
        Route::post('/phscript_safe_project/{id}','PhscriptController@safe_project');
        Route::post('/phscript_safe_create/','PhscriptController@create_project');

    });
    });
    Route::group(['domain' => 'chat.neiros.ru'], function()
    {
        Route::get('logout',  'IndexController@logout' );
        Route::POST('setting_chat',  'ChatController@setting_chat' );
        Route::POST('send_token_push',  'ChatController@send_token_push' );
        Route::POST('deleteTokenToServer',  'ChatController@deleteTokenToServer' );

        Route::get('/{any?}',  'ChatController@index' );
        // Route::get('/home',  'IndexController@chatx' );

    });

    /*Статистика*/
});
Route::post('createsite', 'SitesController@createsite');
Route::post('/ajax/set_sites', 'IndexController@set_sites');
Route::post('/widget/status', 'WidgetController@set_status');
Route::post('/widget/get_setting', 'WidgetController@get_setting');
Route::post('/widget/safe', 'WidgetController@safe_widget');
Route::post('/widget/get_amo_data', 'WidgetController@get_amo_data');
Route::post('/widget/get_b24_data', 'WidgetController@get_b24_data');
Route::post('/widget/get_amo_data_safe', 'WidgetController@get_amo_data_safe');
Route::post('/widget/get_amo_data_safe_default', 'WidgetController@get_amo_data_safe_default');
Route::post('/widget/get_amo_data_safe_default_user', 'WidgetController@get_amo_data_safe_default_user');

Route::post('/widget/get_b24_data_safe', 'WidgetController@get_b24_data_safe');
Route::post('/widget/get_b24_data_safe_default', 'WidgetController@get_b24_data_safe_default');

Route::post('/widgetd/imap_test', 'ImapController@imap_test');
Route::get('/widgetd/imap_test2', 'ImapController@imap_test2');


Route::get('/set_token/{id}', 'MetrikaController@set_token');

Route::get('/set_token_direct/{id}', 'DirectController@set_token');
Route::get('/set_token_adwords/{id}', 'AdwordsController@set_token');
Route::get('/widget_metrika_token', 'MetrikaController@widget_metrika_token');
Route::get('/yandex', 'DirectController@widget_metrika_token');
Route::get('/provotchet', 'DirectController@provotchet');




Route::get('/widget_metrika_get_forbot', 'MetrikaController@widget_metrika_get_forbot');


Route::get('/asterisk', 'IndexController@asterisk');
Route::post('/aster', 'IndexController@aster');
Route::post('/aster_another', 'IndexController@aster_another');
Route::post('/asterisk', 'IndexController@asterisk');
Route::post('/asterisk_ajax/{tip}', 'AsteriskController@asterisk_ajax');



/**/

Route::get('/runexis', 'RunexisController@index');

 Route::get('/bayphone/{amount}/{region}/{widget_id?}/{my_company_id?}', 'RunexisController@bayphone');
Route::get('/imap', 'ImapController@index');


 Route::get('logout','IndexController@logout');
 Route::get('chat','ChatController@index');

 Route::post('chat/clickchattema','ChatController@clickchattema');;
 Route::post('chat/getuserinfo','ChatController@getuserinfo');;
 Route::post('chat/getuserinfourl','ChatController@getuserinfourl');;
 Route::post('chat/getuserinfourladdopen','ChatController@getuserinfourladdopen');;
 Route::post('chat/addclientinfo','ChatController@addclientinfo');;
 Route::post('/chat/get_tek_tema','ChatController@get_tek_tema');;
 Route::post('chat/sendmess','ChatController@sendmess');;
 Route::post('chat/get_tek_mess','ChatController@get_tek_mess');;
 Route::get('registerwebhook','ViberAPI\ViberApiController@registerwebhook');;
 Route::get('chat/{devise}/{neiros_visit}/{widget}','WidgetChatController@index');;
Route::get('/xcallback/{devise}/{hash}/{widget}','WidgetChatController@xcallback');
 Route::post('send_chat','WidgetChatController@send_chat');;
 Route::get('send_chat','WidgetChatController@send_chat');;
 Route::get('admain','AdwordsController@index');;

 Route::post('chat_insertreq/{param}','ChatController@insertreq');;


Route::post('/ajax/{tip}', 'AjaxController@router');
Route::get('/upaudio/{id}', 'IndexController@upaudio');
Route::get('/bt24', 'BitrixController@getLead');
Route::get('/start_prov', 'BitrixController@start_prov');
Route::post('/bt24', 'BitrixController@getLead');
Route::get('/evator', 'BitrixController@evator');
Route::get('/amo', 'AmoCrmApiController@start_prov');
Route::get('/amowebhook', 'AmoCrmApiController@webhook');
Route::get('/fortest', 'AmoCrmApiController@fortest');
Route::get('/reports/{type_report}', 'ReportsController@router');
Route::get('/reports_pdf/{type_report}', 'ReportsController@get_pdf');
Route::get('/reports_table/{type_report}', 'ReportsController@reports_table');
Route::get('/reports_table_direct/{type_report}', 'ReportsController@reports_table_direct');
Route::get('/reports_table_adwords/{type_report}', 'ReportsController@reports_table_adwords');
Route::match(['get','post'],'api/requestAccessToken', 'BitrixController@requestAccessToken');
Route::get('test-broadcast', function(){
    broadcast(new \App\Events\ExampleEvent);
});
Route::get('sad/{type}','SimpleAdController@index');

Route::get('schema/{id}','SchemaController@index');
Route::get('my_api','Api\RoistatController@index');

Route::get('my_api0','BenefisController@index');

Route::get('my_api3/{tip}','AdwordsController@get_report');
Route::get('my_api4/{tip}','AdwordsController@parse_report');
Route::get('my_api5','FbApi\FbController@get_token');




Route::post('v1/api/metrika/{key}', 'Api\WidgetApiController@metrika');
Route::post('v1/api/metrika_first/{key}', 'Api\WidgetApiController@metrika_first');




Route::get('my_api2','AdwordsController@getCompany');
Route::get('my_api6','RunexisController@send_sms');
Route::get('my_api7/{id}','Api\RoistatController@form_lead');
Route::get('my_api8','DirectApiEditController@index');
Route::get('my_api9','DirectController@uploadfile');


Route::match(["POST","get"],'wistis/{id?}','Developer\ServiesController@index')->middleware('isadmin');;

/*Курс валют на сегодня*/
Route::get('get_curs','IndexController@get_curs');