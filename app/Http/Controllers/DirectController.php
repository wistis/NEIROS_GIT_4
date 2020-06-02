<?php

namespace App\Http\Controllers;

use App\Models\MetricaCurrent;
use App\Models\NeirosUtm;
use App\User;
use App\Users_company;
use Auth;
use DB;
use Illuminate\Http\Request;
use Log;
use Symfony\Component\Process\Process;
use Yandex\Direct\Client;
use Yandex\Direct\Credentials;
use Yandex\Direct\Logger\EchoLog;
use Yandex\Direct\Transport\Json\Transport;
use Yandex\OAuth\Exception\AuthRequestException;
use Yandex\OAuth\OAuthClient;

class DirectController extends Controller
{


    public function go_procces()
    {

        $process = new Process('/opt/php72/bin/php artisan command:updatebalances >44.txt', $_ENV['ARTISAN_PATH']);
        $process->start();

    }

    public function reprow_direct($my_company_id,$site_id){
        $dates= \DB::connection('neiros_direct1')->table('direct_otchet_parcer_'.$my_company_id)->groupby('Date') ->pluck( 'Date');
        foreach ($dates as $key=>$val){
            $direct_company_id=DB::connection('neiros_direct1')->table('direct_otchet_parcer_'.$my_company_id)->where('Date',$val)->distinct('CampaignId')->pluck( 'CampaignId');
            $get_ids_metrika=NeirosUtm::wherein('neiros_p2',$direct_company_id)->pluck('neiros_visit');
            info(1);
            $result = DB::connection('neiros_metrica')->table('metrica_'.$my_company_id)
                ->where('site_id', $site_id)->where('reports_date', $val)->where('bot', 0)
                ->where(function ($query) use ($get_ids_metrika){
                    $query->orwherein('neiros_visit',$get_ids_metrika);
                    $query->orwhere('typ','direct','payment');

                })
                ->select('typ', 'src','cmp',
                    DB::raw($this->get_zapros('sdelka')  ),
                    DB::raw( $this ->get_zapros('lead')),
                    DB::raw( $this->get_zapros('summ')),
                    DB::raw('count(DISTINCT(src)) as count_group')
                )->first() ;





            \DB::connection('neiros_metrica')->table('metrica_'.$my_company_id)->where('typ','Директ')->where('reports_date',$val)->delete();
            $cost= DB::connection('neiros_direct1')->table('direct_otchet_parcer_'.$my_company_id)->where('Date',$val) ->sum( 'Cost');
            $cost=round($cost / 1000000*1.2, 2);

            $Clicks= DB::connection('neiros_direct1')->table('direct_otchet_parcer_'.$my_company_id)->where('Date',$val) ->sum( 'Clicks');



            $metrika = new MetricaCurrent();

            $metrika=$metrika->setTable('metrica_' . $my_company_id);
            $metrika->key_user = '';
            $metrika->fd = '';
            $metrika->ep = '';
            $metrika->rf = '';
            $metrika ->neiros_visit = 0;
            $metrika->typ = 'Директ';
            $metrika->mdm ='';
            $metrika->src = '';
            $metrika->cmp = '';
            $metrika->cnt = '';
            $metrika->trim = '';
            $metrika->uag = '';
            $metrika->visit =1;
            $metrika->sdelka =$result->sdelka;
            $metrika->lead =$result->lead;
            $metrika->summ =$result->summ;
            $metrika->promocod ='';
            $metrika->_gid = '';
            $metrika->_ym_uid ='';
            $metrika->olev_phone_track ='';
            $metrika->ip ='';
            $metrika->utm_source = '';
            $metrika-> site_id=$site_id;
            $metrika-> my_company_id= $my_company_id;
            $metrika->reports_date =$val;
            $metrika->updated_at = date('Y-m-d H:i:s');
            $metrika->created_at = date('Y-m-d H:i:s');

            $metrika->bot = 0;
            $metrika->cost=$cost;
            $metrika->unique_visit=$Clicks;
            $metrika->save();



        }





    }
    public function provotchet_correct()
    {


        $widget_direct = DB::table('widget_direct')->
        join('widgets', 'widgets.id', '=', 'widget_direct.widget_id')
            ->where('widgets.status', 1)->select('widget_direct.id as wdid', 'widget_direct.my_company_id as myc', 'widget_direct.email as wemail', 'widget_direct.token as token', 'widgets.sites_id as site_id')->get();

        foreach ($widget_direct as $wi_dir) {


          $process = new Process('/opt/php72/bin/php artisan command:getpersonaldirectcorrect ' . $wi_dir->wdid . ' >44.txt', $_ENV['ARTISAN_PATH']);
           $m = $process->start();


        }
        Log::info('DIR ' . $wi_dir->wdid);
        return $wi_dir->wdid;

    }
    public function provotchet()
    {


        $widget_direct = DB::table('widget_direct')->
        join('widgets', 'widgets.id', '=', 'widget_direct.widget_id')
            ->where('widgets.status', 1)->select('widget_direct.id as wdid', 'widget_direct.my_company_id as myc', 'widget_direct.email as wemail', 'widget_direct.token as token', 'widgets.sites_id as site_id')->get();

        foreach ($widget_direct as $wi_dir) {


          $process = new Process('/opt/php72/bin/php artisan command:getpersonaldirect ' . $wi_dir->wdid . ' >44.txt', $_ENV['ARTISAN_PATH']);
           $m = $process->start();


        }
        Log::info('DIR ' . $wi_dir->wdid);
        return $wi_dir->wdid;

    }

    public function provotchet_test()
    {


        $widget_direct = DB::table('widget_direct')->
        join('widgets', 'widgets.id', '=', 'widget_direct.widget_id')
            ->where('widgets.status', 1)->select('widget_direct.id as wdid', 'widget_direct.my_company_id as myc', 'widget_direct.email as wemail', 'widget_direct.token as token', 'widgets.sites_id as site_id')->get();

        foreach ($widget_direct as $wi_dir) {


            $process = new Process('/opt/php72/bin/php artisan command:getpersonaldirect ' . $wi_dir->wdid . ' >44.txt', $_ENV['ARTISAN_PATH']);
            $m = $process->start();


        }
        Log::info('DIR ' . $wi_dir->wdid);
        return $wi_dir->wdid;

    }
    public function get_companyotchet_new_test()
    {

        $wi_dir = DB::table('widget_direct')->
        join('widgets', 'widgets.id', '=', 'widget_direct.widget_id')
            ->where('widgets.status', 1)
            ->where('widget_direct.id', 1)
            ->select('widget_direct.id as wdid', 'widget_direct.my_company_id as myc', 'widget_direct.email as wemail', 'widget_direct.token as token','widgets.sites_id as site_id')->first();

        $id=$wi_dir->wdid;
        $is_first=0;


        $email = $wi_dir->wemail;
        $token = $wi_dir->token;

        $my_company_id = $wi_dir->myc;
        Log::info('Старт отчета -' . $my_company_id);

        $company = DB::table('metrika_direct_company')->where('status', 1)->where('widget_direct_id', $wi_dir->wdid)->pluck('company')->toArray();

//--- Входные данные ---------------------------------------------------//
// Адрес сервиса Reports для отправки JSON-запросов (регистрозависимый)
        $url = 'https://api.direct.yandex.ru/json/v5/reports';
// OAuth-токен пользователя, от имени которого будут выполняться запросы

// Логин клиента рекламного агентства
// Обязательный параметр, если запросы выполняются от имени рекламного агентства
        $clientLogin = $email;
        $time = time();

        $lastdate = date('Y-m-d', $time);

//--- Подготовка запроса -----------------------------------------------//

        $DateFrom ='2020-03-16';
        $DateTo = '2020-03-22';





        $params = [
            "params" => [
                "SelectionCriteria" => [
                    "DateFrom" => $DateFrom,
                    "DateTo" => $DateTo,
                    'Filter' => [
                        [
                            'Field' => 'CampaignId',
                            'Operator' => 'IN',
                            'Values' => $company,

                        ],[
                            'Field' => 'Clicks',
                            'Operator' => 'GREATER_THAN',
                            'Values' => ["0"],

                        ]
                    ],
                ],
                "FieldNames" => ['CampaignId', 'CampaignName', 'AdGroupId', 'AdGroupName', 'Date', 'Cost', 'Criteria', 'Bounces',
                    'Clicks',
                    'Impressions',
                    'Placement', 'AdId', 'AdNetworkType'],
                "ReportName" => "myotchet_" . md5(implode('-', $company)) . '_' . $time,
                "ReportType" => "CUSTOM_REPORT",
                "DateRangeType" => "CUSTOM_DATE",
                "Format" => "TSV",
                "IncludeVAT" => "NO",
                "IncludeDiscount" => "NO"
            ]
        ];

        $body = json_encode($params);

        $headers = array(
            // OAuth-токен. Использование слова Bearer обязательно
            "Authorization: Bearer $token",
            // Логин клиента рекламного агентства
            "Client-Login: $clientLogin",
            // Язык ответных сообщений
            "Accept-Language: ru",
            // Режим формирования отчета
            "processingMode: auto",

        );

// Инициализация cURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);

        /*
        Для полноценного использования протокола HTTPS можно включить проверку SSL-сертификата сервера API Директа.
        Чтобы включить проверку, установите опцию CURLOPT_SSL_VERIFYPEER в true, а также раскомментируйте строку с опцией CURLOPT_CAINFO и укажите путь к локальной копии корневого SSL-сертификата.
        */
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($curl, CURLOPT_CAINFO, getcwd().'\CA.pem');

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

// --- Запуск цикла для выполнения запросов ---
// Если получен HTTP-код 200, то выводится содержание отчета
// Если получен HTTP-код 201 или 202, выполняются повторные запросы
        while (true) {

            $result = curl_exec($curl);

            if (!$result) {

                echo('Ошибка cURL: ' . curl_errno($curl) . ' - ' . curl_error($curl));

                break;

            } else {

                // Разделение HTTP-заголовков и тела ответа
                $responseHeadersSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
                $responseHeaders = substr($result, 0, $responseHeadersSize);
                $responseBody = substr($result, $responseHeadersSize);

                // Получение кода состояния HTTP
                $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

                // Извлечение HTTP-заголовков ответа
                // Идентификатор запроса
                $requestId = preg_match('/RequestId: (\d+)/', $responseHeaders, $arr) ? $arr[1] : false;
                //  Рекомендуемый интервал в секундах для проверки готовности отчета
                $retryIn = preg_match('/retryIn: (\d+)/', $responseHeaders, $arr) ? $arr[1] : 60;

                if ($httpCode == 400) {

                    echo "Параметры запроса указаны неверно или достигнут лимит отчетов в очереди<br>";
                    echo "RequestId: {$requestId}<br>";
                    echo "JSON-код запроса:<br>{$body}<br>";
                    echo "JSON-код ответа сервера:<br>{$responseBody}<br>";


                    break;

                } elseif ($httpCode == 200) {

                    echo "Отчет создан успешно<br>";
                    echo "RequestId: {$requestId}<br>";

                    $fle_name = $DateTo."-11.tvs";






                    /*"my_otchet-".implode('-',$company)*/
                    $fd = fopen(public_path() . '/directreport_test/' . $fle_name, 'w') or die("не удалось создать файл");
                    $str = $responseBody;

                    fwrite($fd, $str);
                    fclose($fd);
                    /*$this->tsv_to_array_new(public_path() . '/directreport/' . $prov_first_otchet->file_name, array('header_row' => true, 'remove_header_row' => true), $wi_dir->myc, $prov_first_otchet->id,$wi_dir->site_id);*/

                    break;

                } elseif ($httpCode == 201) {

                    echo "Отчет успешно поставлен в очередь в режиме офлайн<br>";
                    echo "Повторная отправка запроса через {$retryIn} секунд<br>";
                    echo "RequestId: {$requestId}<br>";

                    sleep($retryIn);

                } elseif ($httpCode == 202) {

                    echo "Отчет формируется в режиме offline.<br>";
                    echo "Повторная отправка запроса через {$retryIn} секунд<br>";
                    echo "RequestId: {$requestId}<br>";

                    sleep($retryIn);

                } elseif ($httpCode == 500) {

                    echo "При формировании отчета произошла ошибка. Пожалуйста, попробуйте повторить запрос позднее<br>";
                    echo "RequestId: {$requestId}<br>";
                    echo "JSON-код ответа сервера:<br>{$responseBody}<br>";

                    break;

                } elseif ($httpCode == 502) {

                    echo "Время формирования отчета превысило серверное ограничение.<br>";
                    echo "Пожалуйста, попробуйте изменить параметры запроса - уменьшить период и количество запрашиваемых данных.<br>";
                    echo "RequestId: {$requestId}<br>";

                    break;

                } else {

                    echo "Произошла непредвиденная ошибка.<br>";
                    echo "RequestId: {$requestId}<br>";
                    echo "JSON-код запроса:<br>{$body}<br>";
                    echo "JSON-код ответа сервера:<br>{$responseBody}<br>";

                    break;

                }
            }
        }

        curl_close($curl);


    }
    public function get_companyotchet_correct($wi_dir)
    {$id=$wi_dir->wdid;
        $is_first=0;


        $email = $wi_dir->wemail;
        $token = $wi_dir->token;

        $my_company_id = $wi_dir->myc;
if($my_company_id!=46){
    return ;
}

        $company = DB::table('metrika_direct_company')->where('status', 1)->where('widget_direct_id', $wi_dir->wdid)->pluck('company')->toArray();

//--- Входные данные ---------------------------------------------------//
// Адрес сервиса Reports для отправки JSON-запросов (регистрозависимый)
        $url = 'https://api.direct.yandex.ru/json/v5/reports';

        $clientLogin = $email;
        $time = time();

        $lastdate = date('Y-m-d', $time);






               $prov_ob_otchet = DB::connection('neiros_direct1')->table('direct_otchet_' . $my_company_id)
                    ->where('first_otchet', 0)
                   ->where('status', 200)
                   ->where('status_upload', 1)

                   ->where('DateTo', '<',date('Y-m-d'))->orderby('DateTo','asc')
                   ->first();
if(!$prov_ob_otchet) {
    return '';
}


                   $isset_otchet = $prov_ob_otchet->id;

                   $new_otchet = $prov_ob_otchet->id;
                   $DateFrom = $prov_ob_otchet->DateFrom;
                   $DateTo = $prov_ob_otchet->DateTo;

        \DB::connection('neiros_direct1')->table('direct_otchet_' . $my_company_id)->where('id', $isset_otchet)->update([ 'status'=>'2']);




        $params = [
            "params" => [
                "SelectionCriteria" => [
                    "DateFrom" => $DateFrom,
                    "DateTo" => $DateTo,
                    'Filter' => [
                        [
                            'Field' => 'CampaignId',
                            'Operator' => 'IN',
                            'Values' => $company,

                        ],[
                            'Field' => 'Clicks',
                            'Operator' => 'GREATER_THAN',
                             'Values' => ["0"],

                        ]
                    ],
                ],
                "FieldNames" => ['CampaignId', 'CampaignName', 'AdGroupId', 'AdGroupName', 'Date', 'Cost', 'Criteria', 'Bounces',
                    'Clicks',
                    'Impressions',
                    'Placement', 'AdId', 'AdNetworkType'],
                "ReportName" => "myotchet_" . md5(implode('-', $company)) . '_' . $time,
                "ReportType" => "CUSTOM_REPORT",
                "DateRangeType" => "CUSTOM_DATE",
                "Format" => "TSV",
                "IncludeVAT" => "NO",
                "IncludeDiscount" => "NO"
            ]
        ];

        Log::info('DIR 3' . $new_otchet);
// Преобразование входных параметров запроса в формат JSON
        $body = json_encode($params);

// Создание HTTP-заголовков запроса
        $headers = array(
            // OAuth-токен. Использование слова Bearer обязательно
            "Authorization: Bearer $token",
            // Логин клиента рекламного агентства
            "Client-Login: $clientLogin",
            // Язык ответных сообщений
            "Accept-Language: ru",
            // Режим формирования отчета
            "processingMode: auto",
            // Формат денежных значений в отчете
            // "returnMoneyInMicros: false",
            // Не выводить в отчете строку с названием отчета и диапазоном дат
            // "skipReportHeader: true",
            // Не выводить в отчете строку с названиями полей
            // "skipColumnHeader: true",
            // Не выводить в отчете строку с количеством строк статистики
            // "skipReportSummary: true"
        );

// Инициализация cURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);

        /*
        Для полноценного использования протокола HTTPS можно включить проверку SSL-сертификата сервера API Директа.
        Чтобы включить проверку, установите опцию CURLOPT_SSL_VERIFYPEER в true, а также раскомментируйте строку с опцией CURLOPT_CAINFO и укажите путь к локальной копии корневого SSL-сертификата.
        */
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($curl, CURLOPT_CAINFO, getcwd().'\CA.pem');

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

// --- Запуск цикла для выполнения запросов ---
// Если получен HTTP-код 200, то выводится содержание отчета
// Если получен HTTP-код 201 или 202, выполняются повторные запросы
        while (true) {

            $result = curl_exec($curl);

            if (!$result) {

                echo('Ошибка cURL: ' . curl_errno($curl) . ' - ' . curl_error($curl));

                break;

            } else {

                // Разделение HTTP-заголовков и тела ответа
                $responseHeadersSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
                $responseHeaders = substr($result, 0, $responseHeadersSize);
                $responseBody = substr($result, $responseHeadersSize);

                // Получение кода состояния HTTP
                $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

                // Извлечение HTTP-заголовков ответа
                // Идентификатор запроса
                $requestId = preg_match('/RequestId: (\d+)/', $responseHeaders, $arr) ? $arr[1] : false;
                //  Рекомендуемый интервал в секундах для проверки готовности отчета
                $retryIn = preg_match('/retryIn: (\d+)/', $responseHeaders, $arr) ? $arr[1] : 60;

                if ($httpCode == 400) {

                    echo "Параметры запроса указаны неверно или достигнут лимит отчетов в очереди<br>";
                    echo "RequestId: {$requestId}<br>";
                    echo "JSON-код запроса:<br>{$body}<br>";
                    echo "JSON-код ответа сервера:<br>{$responseBody}<br>";


                    break;

                } elseif ($httpCode == 200) {

                    echo "Отчет создан успешно<br>";
                    echo "RequestId: {$requestId}<br>";

                    $fle_name = $my_company_id.'_'.rand(1,1000).md5(implode('-', $company)) . '_' . $lastdate . ".tvs";



                    DB::connection('neiros_direct1')->table('direct_otchet_' . $my_company_id)->where('id', $new_otchet)->update([  'comment' => 'Отчет получен', 'file_name' => $fle_name,'updated_at'=>date('Y-m-d H:i:s'),'status_upload'=>0,'status'=>3]);
                    /*"my_otchet-".implode('-',$company)*/
                    $fd = fopen(public_path() . '/directreport/' . $fle_name, 'w') or die("не удалось создать файл");
                    $str = $responseBody;

                    fwrite($fd, $str);
                    fclose($fd);


                    break;

                } elseif ($httpCode == 201) {


                    sleep($retryIn);

                } elseif ($httpCode == 202) {

                    sleep($retryIn);

                } elseif ($httpCode == 500) {

                    break;

                } elseif ($httpCode == 502) {


                    break;

                } else {


                    break;

                }
            }
        }

        curl_close($curl);


    }
    public function get_companyotchet_new_1($wi_dir)
    {$id=12;
        $is_first=0;


        $email = '';
        $token = 'AgAAAAAbmCJlAAVPR1y7g6Dm9kiWrbXdgoWqA8w';



        $company = DB::table('metrika_direct_company')->where('status', 1)->where('widget_id', 98)->pluck('company')->toArray();

//--- Входные данные ---------------------------------------------------//
// Адрес сервиса Reports для отправки JSON-запросов (регистрозависимый)
        $url = 'https://api.direct.yandex.ru/json/v5/reports';
// OAuth-токен пользователя, от имени которого будут выполняться запросы

// Логин клиента рекламного агентства
// Обязательный параметр, если запросы выполняются от имени рекламного агентства
        $clientLogin = $email;
        $time = time();

        $lastdate = date('Y-m-d', $time);

//--- Подготовка запроса -----------------------------------------------//







        $DateFrom = '2020-05-09';
        $DateTo =  '2020-05-13';
        $params = [
            "params" => [
                "SelectionCriteria" => [
                    "DateFrom" => $DateFrom,
                    "DateTo" => $DateTo,
                    'Filter' => [
                        [
                            'Field' => 'CampaignId',
                            'Operator' => 'IN',
                            'Values' => [25976343],

                        ],[
                            'Field' => 'Clicks',
                            'Operator' => 'GREATER_THAN',
                            'Values' => ["0"],

                        ]
                    ],
                ],
                "FieldNames" => ['CampaignId', 'CampaignName', 'AdGroupId', 'AdGroupName', 'Date', 'Cost', 'Criterion', 'Bounces',
                    'Clicks',
                    'Impressions',
                    'Placement', 'AdId', 'AdNetworkType'],
                "ReportName" => "1958_222344myotchet_" . md5(implode('-', $company)) . '_' . $time,
                "ReportType" => "CUSTOM_REPORT",
                "DateRangeType" => "CUSTOM_DATE",
                "Format" => "TSV",
                "IncludeVAT" => "NO",
                "IncludeDiscount" => "NO"
            ]
        ];

      info($params);
// Преобразование входных параметров запроса в формат JSON
        $body = json_encode($params);

// Создание HTTP-заголовков запроса
        $headers = array(
            // OAuth-токен. Использование слова Bearer обязательно
            "Authorization: Bearer $token",
            // Логин клиента рекламного агентства
            "Client-Login: $clientLogin",
            // Язык ответных сообщений
            "Accept-Language: ru",
            // Режим формирования отчета
            "processingMode: auto",
            // Формат денежных значений в отчете
            // "returnMoneyInMicros: false",
            // Не выводить в отчете строку с названием отчета и диапазоном дат
            // "skipReportHeader: true",
            // Не выводить в отчете строку с названиями полей
            // "skipColumnHeader: true",
            // Не выводить в отчете строку с количеством строк статистики
            // "skipReportSummary: true"
        );

// Инициализация cURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);

        /*
        Для полноценного использования протокола HTTPS можно включить проверку SSL-сертификата сервера API Директа.
        Чтобы включить проверку, установите опцию CURLOPT_SSL_VERIFYPEER в true, а также раскомментируйте строку с опцией CURLOPT_CAINFO и укажите путь к локальной копии корневого SSL-сертификата.
        */
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($curl, CURLOPT_CAINFO, getcwd().'\CA.pem');

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

// --- Запуск цикла для выполнения запросов ---
// Если получен HTTP-код 200, то выводится содержание отчета
// Если получен HTTP-код 201 или 202, выполняются повторные запросы
        while (true) {

            $result = curl_exec($curl);

            if (!$result) {

                echo('Ошибка cURL: ' . curl_errno($curl) . ' - ' . curl_error($curl));

                break;

            } else {

                // Разделение HTTP-заголовков и тела ответа
                $responseHeadersSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
                $responseHeaders = substr($result, 0, $responseHeadersSize);
                $responseBody = substr($result, $responseHeadersSize);

                // Получение кода состояния HTTP
                $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

                // Извлечение HTTP-заголовков ответа
                // Идентификатор запроса
                $requestId = preg_match('/RequestId: (\d+)/', $responseHeaders, $arr) ? $arr[1] : false;
                //  Рекомендуемый интервал в секундах для проверки готовности отчета
                $retryIn = preg_match('/retryIn: (\d+)/', $responseHeaders, $arr) ? $arr[1] : 60;

                if ($httpCode == 400) {

                    echo "Параметры запроса указаны неверно или достигнут лимит отчетов в очереди<br>";
                    echo "RequestId: {$requestId}<br>";
                    echo "JSON-код запроса:<br>{$body}<br>";
                    echo "JSON-код ответа сервера:<br>{$responseBody}<br>";


                    break;

                } elseif ($httpCode == 200) {

                    echo "Отчет создан успешно<br>";
                    echo "RequestId: {$requestId}<br>";

                    $fle_name = '12_wistis'.rand(1,1000).md5(implode('-', $company)) . '_' . $lastdate . ".tvs";








                    /*"my_otchet-".implode('-',$company)*/
                    $fd = fopen(public_path() . '/directreport_test/' . $fle_name, 'w') or die("не удалось создать файл");
                    $str = $responseBody;

                    fwrite($fd, $str);
                    fclose($fd);
                    /*$this->tsv_to_array_new(public_path() . '/directreport/' . $prov_first_otchet->file_name, array('header_row' => true, 'remove_header_row' => true), $wi_dir->myc, $prov_first_otchet->id,$wi_dir->site_id);*/

                    break;

                } elseif ($httpCode == 201) {

                    echo "Отчет успешно поставлен в очередь в режиме офлайн<br>";
                    echo "Повторная отправка запроса через {$retryIn} секунд<br>";
                    echo "RequestId: {$requestId}<br>";

                    sleep($retryIn);

                } elseif ($httpCode == 202) {

                    echo "Отчет формируется в режиме offline.<br>";
                    echo "Повторная отправка запроса через {$retryIn} секунд<br>";
                    echo "RequestId: {$requestId}<br>";

                    sleep($retryIn);

                } elseif ($httpCode == 500) {

                    echo "При формировании отчета произошла ошибка. Пожалуйста, попробуйте повторить запрос позднее<br>";
                    echo "RequestId: {$requestId}<br>";
                    echo "JSON-код ответа сервера:<br>{$responseBody}<br>";

                    break;

                } elseif ($httpCode == 502) {

                    echo "Время формирования отчета превысило серверное ограничение.<br>";
                    echo "Пожалуйста, попробуйте изменить параметры запроса - уменьшить период и количество запрашиваемых данных.<br>";
                    echo "RequestId: {$requestId}<br>";

                    break;

                } else {

                    echo "Произошла непредвиденная ошибка.<br>";
                    echo "RequestId: {$requestId}<br>";
                    echo "JSON-код запроса:<br>{$body}<br>";
                    echo "JSON-код ответа сервера:<br>{$responseBody}<br>";

                    break;

                }
            }
        }

        curl_close($curl);


    }
    public function get_companyotchet_new($wi_dir)
    {$id=$wi_dir->wdid;
        $is_first=0;


        $email = $wi_dir->wemail;
        $token = $wi_dir->token;

        $my_company_id = $wi_dir->myc;
        Log::info('Старт отчета -' . $my_company_id);

        $company = DB::table('metrika_direct_company')->where('status', 1)->where('widget_direct_id', $wi_dir->wdid)->pluck('company')->toArray();

//--- Входные данные ---------------------------------------------------//
// Адрес сервиса Reports для отправки JSON-запросов (регистрозависимый)
        $url = 'https://api.direct.yandex.ru/json/v5/reports';
// OAuth-токен пользователя, от имени которого будут выполняться запросы

// Логин клиента рекламного агентства
// Обязательный параметр, если запросы выполняются от имени рекламного агентства
        $clientLogin = $email;
        $time = time();

        $lastdate = date('Y-m-d', $time);

//--- Подготовка запроса -----------------------------------------------//

        $prov_first_otchet = DB::connection('neiros_direct1')->table('direct_otchet_' . $my_company_id)->where('first_otchet', 1)->first();


        if (!$prov_first_otchet) {
            $company_my = User::where('my_company_id', $my_company_id)->orderby('id', 'asc')->first();
            $DateFrom = date('Y-m-d', strtotime($company_my->created_at));
            $DateTo = date('Y-m-d', (time() - 86400));

            $new_otchet = DB::connection('neiros_direct1')->table('direct_otchet_' . $my_company_id)->insertGetId([

                'name' => "myotchet_" . $time,
                'status' => 0,
                'DateFrom' => $DateFrom,
                'DateTo' => $DateTo,
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
                'first_otchet' => 1,
                'status_upload' => 0,

            ]);
            $prov_first_otchet = DB::connection('neiros_direct1')->table('direct_otchet_' . $my_company_id)->where('first_otchet', 1)->first();
            $is_first=1;

        } else {

            if ($prov_first_otchet->status != 200) {

                $new_otchet = $prov_first_otchet->id;
                $DateFrom = $prov_first_otchet->DateFrom;
                $DateTo = $prov_first_otchet->DateTo;

            }


        }



        if($is_first==0) {
            $prov_first_otchet = DB::connection('neiros_direct1')->table('direct_otchet_' . $my_company_id)
                ->where('first_otchet', 1)
                ->where('status', 200)
                ->first();
            if ($prov_first_otchet) {

                $prov_ob_otchet = DB::connection('neiros_direct1')->table('direct_otchet_' . $my_company_id)
                    ->where('first_otchet', 0)
                    ->where('DateFrom', date('Y-m-d'))
                    ->where('DateTo', date('Y-m-d'))
                    ->first();

                if ($prov_ob_otchet) {

                    $isset_otchet = $prov_ob_otchet->id;

                    $new_otchet = $prov_ob_otchet->id;
                    $DateFrom = $prov_ob_otchet->DateFrom;
                    $DateTo = $prov_ob_otchet->DateTo;

                } else {
                    $DateFrom = date('Y-m-d');
                    $DateTo = date('Y-m-d');

                    $new_otchet = DB::connection('neiros_direct1')->table('direct_otchet_' . $my_company_id)->insertGetId([

                        'name' => "myotchet_" . $time,
                        'status' => 0,
                        'DateFrom' => $DateFrom,
                        'DateTo' => $DateTo,
                        'created_at' => date('Y-m-d'),
                        'updated_at' => date('Y-m-d'),
                        'first_otchet' => 0,
                        'status_upload' => 0,

                    ]);

                }


            }
        }
        $params = [
            "params" => [
                "SelectionCriteria" => [
                    "DateFrom" => $DateFrom,
                    "DateTo" => $DateTo,
                    'Filter' => [
                        [
                            'Field' => 'CampaignId',
                            'Operator' => 'IN',
                            'Values' => $company,

                        ],[
                            'Field' => 'Clicks',
                            'Operator' => 'GREATER_THAN',
                            'Values' => ["0"],

                        ]
                    ],
                ],
                "FieldNames" => ['CampaignId', 'CampaignName', 'AdGroupId', 'AdGroupName', 'Date', 'Cost', 'Criteria', 'Bounces',
                    'Clicks',
                    'Impressions',
                    'Placement', 'AdId', 'AdNetworkType'],
                "ReportName" => "myotchet_" . md5(implode('-', $company)) . '_' . $time,
                "ReportType" => "CUSTOM_REPORT",
                "DateRangeType" => "CUSTOM_DATE",
                "Format" => "TSV",
                "IncludeVAT" => "NO",
                "IncludeDiscount" => "NO"
            ]
        ];

        Log::info('DIR 3' . $new_otchet);
// Преобразование входных параметров запроса в формат JSON
        $body = json_encode($params);

// Создание HTTP-заголовков запроса
        $headers = array(
            // OAuth-токен. Использование слова Bearer обязательно
            "Authorization: Bearer $token",
            // Логин клиента рекламного агентства
            "Client-Login: $clientLogin",
            // Язык ответных сообщений
            "Accept-Language: ru",
            // Режим формирования отчета
            "processingMode: auto",
            // Формат денежных значений в отчете
            // "returnMoneyInMicros: false",
            // Не выводить в отчете строку с названием отчета и диапазоном дат
            // "skipReportHeader: true",
            // Не выводить в отчете строку с названиями полей
            // "skipColumnHeader: true",
            // Не выводить в отчете строку с количеством строк статистики
            // "skipReportSummary: true"
        );

// Инициализация cURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);

        /*
        Для полноценного использования протокола HTTPS можно включить проверку SSL-сертификата сервера API Директа.
        Чтобы включить проверку, установите опцию CURLOPT_SSL_VERIFYPEER в true, а также раскомментируйте строку с опцией CURLOPT_CAINFO и укажите путь к локальной копии корневого SSL-сертификата.
        */
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($curl, CURLOPT_CAINFO, getcwd().'\CA.pem');

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

// --- Запуск цикла для выполнения запросов ---
// Если получен HTTP-код 200, то выводится содержание отчета
// Если получен HTTP-код 201 или 202, выполняются повторные запросы
        while (true) {

            $result = curl_exec($curl);

            if (!$result) {

                echo('Ошибка cURL: ' . curl_errno($curl) . ' - ' . curl_error($curl));

                break;

            } else {

                // Разделение HTTP-заголовков и тела ответа
                $responseHeadersSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
                $responseHeaders = substr($result, 0, $responseHeadersSize);
                $responseBody = substr($result, $responseHeadersSize);

                // Получение кода состояния HTTP
                $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

                // Извлечение HTTP-заголовков ответа
                // Идентификатор запроса
                $requestId = preg_match('/RequestId: (\d+)/', $responseHeaders, $arr) ? $arr[1] : false;
                //  Рекомендуемый интервал в секундах для проверки готовности отчета
                $retryIn = preg_match('/retryIn: (\d+)/', $responseHeaders, $arr) ? $arr[1] : 60;

                if ($httpCode == 400) {

                    echo "Параметры запроса указаны неверно или достигнут лимит отчетов в очереди<br>";
                    echo "RequestId: {$requestId}<br>";
                    echo "JSON-код запроса:<br>{$body}<br>";
                    echo "JSON-код ответа сервера:<br>{$responseBody}<br>";


                    break;

                } elseif ($httpCode == 200) {

                    echo "Отчет создан успешно<br>";
                    echo "RequestId: {$requestId}<br>";

                    $fle_name = $my_company_id.'_'.rand(1,1000).md5(implode('-', $company)) . '_' . $lastdate . ".tvs";







                    DB::connection('neiros_direct1')->table('direct_otchet_' . $my_company_id)->where('id', $new_otchet)->update(['status' => 200, 'comment' => 'Отчет получен', 'file_name' => $fle_name,'updated_at'=>date('Y-m-d H:i:s'),'status_upload'=>0]);
                    /*"my_otchet-".implode('-',$company)*/
                    $fd = fopen(public_path() . '/directreport/' . $fle_name, 'w') or die("не удалось создать файл");
                    $str = $responseBody;

                    fwrite($fd, $str);
                    fclose($fd);
                    /*$this->tsv_to_array_new(public_path() . '/directreport/' . $prov_first_otchet->file_name, array('header_row' => true, 'remove_header_row' => true), $wi_dir->myc, $prov_first_otchet->id,$wi_dir->site_id);*/

                    break;

                } elseif ($httpCode == 201) {

                    echo "Отчет успешно поставлен в очередь в режиме офлайн<br>";
                    echo "Повторная отправка запроса через {$retryIn} секунд<br>";
                    echo "RequestId: {$requestId}<br>";
                    DB::connection('neiros_direct1')->table('direct_otchet_' . $my_company_id)->where('id', $new_otchet)->update(['status' => 201,
                        'comment' => 'Отчет успешно поставлен в очередь в режиме офлайн'

                    ]);
                    sleep($retryIn);

                } elseif ($httpCode == 202) {

                    echo "Отчет формируется в режиме offline.<br>";
                    echo "Повторная отправка запроса через {$retryIn} секунд<br>";
                    echo "RequestId: {$requestId}<br>";
                    DB::connection('neiros_direct1')->table('direct_otchet_' . $my_company_id)->where('id', $new_otchet)->update(['status' => 202,
                        'comment' => 'Отчет формируется в режиме offline.'

                    ]);
                    sleep($retryIn);

                } elseif ($httpCode == 500) {

                    echo "При формировании отчета произошла ошибка. Пожалуйста, попробуйте повторить запрос позднее<br>";
                    echo "RequestId: {$requestId}<br>";
                    echo "JSON-код ответа сервера:<br>{$responseBody}<br>";
                    DB::connection('neiros_direct1')->table('direct_otchet_' . $my_company_id)->where('id', $new_otchet)->update(['status' => 500,
                        'comment' => 'При формировании отчета произошла ошибка. Пожалуйста, попробуйте повторить запрос позднее'

                    ]);
                    break;

                } elseif ($httpCode == 502) {

                    echo "Время формирования отчета превысило серверное ограничение.<br>";
                    echo "Пожалуйста, попробуйте изменить параметры запроса - уменьшить период и количество запрашиваемых данных.<br>";
                    echo "RequestId: {$requestId}<br>";
                    DB::connection('neiros_direct1')->table('direct_otchet_' . $my_company_id)->where('id', $new_otchet)->update(['status' => 502,
                        'comment' => 'Время формирования отчета превысило серверное ограничение.'

                    ]);
                    break;

                } else {

                    echo "Произошла непредвиденная ошибка.<br>";
                    echo "RequestId: {$requestId}<br>";
                    echo "JSON-код запроса:<br>{$body}<br>";
                    echo "JSON-код ответа сервера:<br>{$responseBody}<br>";
                    DB::connection('neiros_direct1')->table('direct_otchet_' . $my_company_id)->where('id', $new_otchet)->update(['status' => $httpCode,
                        'comment' => 'Произошла непредвиденная ошибка.'

                    ]);
                    break;

                }
            }
        }

        curl_close($curl);


    }
    public function uploadfile_correct($id = null)
    {

        $wi_dir = DB::table('widget_direct')->
        join('widgets', 'widgets.id', '=', 'widget_direct.widget_id')
            ->where('widgets.status', 1)
            ->where('widget_direct.id', $id)
            ->select('widget_direct.id as wdid', 'widget_direct.my_company_id as myc', 'widget_direct.email as wemail', 'widget_direct.token as token','widgets.sites_id as site_id')->first();

            $prov_first_otchets = DB::connection('neiros_direct1')->table('direct_otchet_' . $wi_dir->myc)->where('status', '=', 3)->get();
            info('get11._'.$wi_dir->myc);
foreach($prov_first_otchets as $prov_first_otchet){
    info('get12._'.$wi_dir->myc);
    DB::connection('neiros_direct1')->table('direct_otchet_' . $wi_dir->myc)->where('id', $prov_first_otchet->id)->update(['status_upload' => 4]);
            info('correct direct not upload my_id' . $wi_dir->myc);
            info('correct direct not upload' . $prov_first_otchet->id);
            info('correct direct not upload' . $id);
            if ($prov_first_otchet->file_name != '') {




                $this->tsv_to_array_new_correct(public_path() . '/directreport/' . $prov_first_otchet->file_name, array('header_row' => true, 'remove_header_row' => true), $wi_dir->myc, $prov_first_otchet->id,$wi_dir->site_id);

            }
            }

    }
    public function uploadfile($id = null)
    {

        $wi_dir = DB::table('widget_direct')->
        join('widgets', 'widgets.id', '=', 'widget_direct.widget_id')
            ->where('widgets.status', 1)
            ->where('widget_direct.id', $id)
            ->select('widget_direct.id as wdid', 'widget_direct.my_company_id as myc', 'widget_direct.email as wemail', 'widget_direct.token as token','widgets.sites_id as site_id')->first();

            $prov_first_otchets = DB::connection('neiros_direct1')->table('direct_otchet_' . $wi_dir->myc)->where('status_upload', '!=', 1)->get();
foreach($prov_first_otchets as $prov_first_otchet){
            info('direct not upload my_id' . $wi_dir->myc);
            info('direct not upload' . $prov_first_otchet->id);
            info('direct not upload' . $id);
            if ($prov_first_otchet->file_name != '') {




                $this->tsv_to_array_new(public_path() . '/directreport/' . $prov_first_otchet->file_name, array('header_row' => true, 'remove_header_row' => true), $wi_dir->myc, $prov_first_otchet->id,$wi_dir->site_id);

            }
            }

    }

    function tsv_to_array($file, $args = array(), $my_company_id, $new_otchet)
    {
        $debug = 1;
info('start parsing direct '.$my_company_id);
        DB::connection('neiros_direct1')->table('direct_otchet_parcer_' . $my_company_id)->where('otchet', $new_otchet)->delete();
        //key => default
        $fields = array(
            'header_row' => true,
            'remove_header_row' => true,
            'trim_headers' => true, //trim whitespace around header row values
            'trim_values' => true, //trim whitespace around all non-header row values
            'debug' => false, //set to true while testing if you run into troubles
            'lb' => "\n", //line break character
            'tab' => "\t", //tab character
        );

        foreach ($fields as $key => $default) {
            if (array_key_exists($key, $args)) {
                $$key = $args[$key];
            } else {
                $$key = $default;
            }
        }

        if (!file_exists($file)) {

            $error = 'File does not exist.';

            info($error);
        }

        if ($debug) {
            info('<p>Opening ' . htmlspecialchars($file) . '&hellip;</p>');
        }
        $data = array();

        if (($handle = fopen($file, 'r')) !== false) {
            $contents = fgets($handle, filesize($file));
            fclose($handle);
        } else {
            info('There was an error opening the file.');
        }

        $lines = explode($lb, $contents);
        if ($debug) {
            info('<p>Reading ' . count($lines) . ' lines&hellip;</p>');
        }

        $row = 1;
        $rowm = -2;
        foreach ($lines as $line) {
            $row++;
            if ($row > 2) {
                $rowm++;
                if (($header_row) && ($row == 2)) {
                    $data['headers'] = array();
                }


                $values = explode($tab, $line);
                foreach ($values as $c => $value) {
                    if (($header_row) && ($row == 3)) { //if this is part of the header row

                        //if (in_array($value,$data['headers'])) { custom_die('There are duplicate values in the header row: '.htmlspecialchars($value).'.'); }

                        if ($trim_headers) {
                            $value = trim($value);
                        }
                        $data['headers'][$c] = $value . ''; //the .'' makes sure it's a string

                    } elseif ($header_row) { //if this isn't part of the header row, but there is a header row


                        $key = $data['headers'][$c];
                        if ($trim_values) {
                            $value = trim($value);
                        }
                        $data[$rowm][$key] = $value;
                    } else { //if there's not a header row at all
                        $data[$rowm][$c] = $value;
                    }
                }
            }

        }

        if ($remove_header_row) {
            unset($data['headers']);
        }

        if ($debug) {
            echo '<pre>' . print_r($data, true) . '</pre>';
        }

        for ($ih = 0; $ih < count($data); $ih++) {


            if (count($data[$ih]) > 3) {

                DB::connection('neiros_direct1')->table('direct_otchet_parcer_' . $my_company_id)->insert([
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                    'CampaignId' => $data[$ih]['CampaignId'],
                    'CampaignName' => $data[$ih]['CampaignName'],
                    'AdGroupId' => $data[$ih]['AdGroupId'],
                    'AdGroupName' => $data[$ih]['AdGroupName'],
                    'Query' => explode('-', $data[$ih]['Criteria'])[0],
                    'Criteria' => $data[$ih]['Criteria'],
                    'Bounces' => $data[$ih]['Bounces'],
                    'Clicks' => $data[$ih]['Clicks'],
                    'Impressions' => $data[$ih]['Impressions'],
                    'Placement' => $data[$ih]['Placement'],
                    'AdId' => $data[$ih]['AdId'],
                    'AdNetworkType' => $data[$ih]['AdNetworkType'],


                    'Cost' => $data[$ih]['Cost'],
                    'Date' => $data[$ih]['Date'],
                    'my_company_id' => $my_company_id,
                    'otchet' => $new_otchet,

                ]);

            }

        }

        DB::connection('neiros_direct1')->table('direct_otchet_' . $my_company_id)->where('id', $new_otchet)->update(['status_upload' => 1]);
        //return $data;
    }

    function tsv_to_array_new_correct($file, $args = array(), $my_company_id, $new_otchet,$site_id)
    {
        $debug = 1;
        $date_to_metrika=[];
        DB::connection('neiros_direct1')->table('direct_otchet_parcer_' . $my_company_id)->where('otchet', $new_otchet)->delete();
        //key => default
        $fields = array(
            'header_row' => true,
            'remove_header_row' => true,
            'trim_headers' => true, //trim whitespace around header row values
            'trim_values' => true, //trim whitespace around all non-header row values
            'debug' => false, //set to true while testing if you run into troubles
            'lb' => "\n", //line break character
            'tab' => "\t", //tab character
        );

        foreach ($fields as $key => $default) {
            if (array_key_exists($key, $args)) {
                $$key = $args[$key];
            } else {
                $$key = $default;
            }
        }

        if (!file_exists($file)) {

            $error = 'File does not exist.';

            info($error);
            return '';
        }

        $data = array();


        $str = 0;$z=0;
        if ($file = fopen($file, "r")) {
            while (!feof($file)) {
                $line = fgets($file);
                # do same stuff with the $line
                $line_data = explode("\t", $line);;
                if ($str == 1) {
                    for($m=0;$m<count($line_data);$m++) {
                        $header[$m]=str_replace("\n",'',$line_data[$m]);

                    }

 
                }
                if ($str >1) {
                    for($k=0;$k<count($line_data);$k++) {
                        $data[$z][$header[$k]]=str_replace("\n",'',$line_data[$k]);
                        if($header[$k]=='Date'){

                            $date_to_metrika[$data[$z][$header[$k]]]=$data[$z][$header[$k]];
                        }
                 } $z++  ;



                }
                $str++;



                if($z==1000){
                    $this->insertTodirect($data,$my_company_id,$new_otchet,$site_id);
                    $z=0;
                }
            }


        }

        fclose($file);
        if($z>0){
        $this->insertTodirect($data,$my_company_id,$new_otchet,$site_id);
            }


        DB::connection('neiros_direct1')->table('direct_otchet_' . $my_company_id)->where('id', $new_otchet)->update(['status_upload' => 5]);
        //return $data;
        try{
    unlink($file);
    }catch(\Exception $e){

        }

        

    }
    function tsv_to_array_new($file, $args = array(), $my_company_id, $new_otchet,$site_id)
    {
        $debug = 1;
        $date_to_metrika=[];
        DB::connection('neiros_direct1')->table('direct_otchet_parcer_' . $my_company_id)->where('otchet', $new_otchet)->delete();
        //key => default
        $fields = array(
            'header_row' => true,
            'remove_header_row' => true,
            'trim_headers' => true, //trim whitespace around header row values
            'trim_values' => true, //trim whitespace around all non-header row values
            'debug' => false, //set to true while testing if you run into troubles
            'lb' => "\n", //line break character
            'tab' => "\t", //tab character
        );

        foreach ($fields as $key => $default) {
            if (array_key_exists($key, $args)) {
                $$key = $args[$key];
            } else {
                $$key = $default;
            }
        }

        if (!file_exists($file)) {

            $error = 'File does not exist.';

            info($error);
            return '';
        }

        $data = array();


        $str = 0;$z=0;
        if ($file = fopen($file, "r")) {
            while (!feof($file)) {
                $line = fgets($file);
                # do same stuff with the $line
                $line_data = explode("\t", $line);;
                if ($str == 1) {
                    for($m=0;$m<count($line_data);$m++) {
                        $header[$m]=str_replace("\n",'',$line_data[$m]);

                    }


                }
                if ($str >1) {
                    for($k=0;$k<count($line_data);$k++) {
                        $data[$z][$header[$k]]=str_replace("\n",'',$line_data[$k]);
                        if($header[$k]=='Date'){

                            $date_to_metrika[$data[$z][$header[$k]]]=$data[$z][$header[$k]];
                        }
                 } $z++  ;



                }
                $str++;



                if($z==1000){
                    $this->insertTodirect($data,$my_company_id,$new_otchet,$site_id);
                    $z=0;
                }
            }


        }

        fclose($file);
        if($z>0){
        $this->insertTodirect($data,$my_company_id,$new_otchet,$site_id);
            }


        DB::connection('neiros_direct1')->table('direct_otchet_' . $my_company_id)->where('id', $new_otchet)->update(['status_upload' => 1]);
        //return $data;
        try{
    unlink($file);
    }catch(\Exception $e){

        }

        $this->create_metrika_from_direct($date_to_metrika,$my_company_id,$site_id);

    }
public function insertTodirect($data,$my_company_id,$new_otchet,$site_id){
$date_to_metrika=[];
info('insert todirect. ' .$my_company_id);
    for ($ih = 0; $ih < count($data); $ih++) {


        if (count($data[$ih]) > 3) {



         try {
             DB::connection('neiros_direct1')->table('direct_otchet_parcer_' . $my_company_id)->insert([
                 'created_at' => date('Y-m-d'),
                 'updated_at' => date('Y-m-d'),
                 'CampaignId' => $data[$ih]['CampaignId'],
                 'CampaignName' => $data[$ih]['CampaignName'],
                 'AdGroupId' => $data[$ih]['AdGroupId'],
                 'AdGroupName' => $data[$ih]['AdGroupName'],
                 'Query' => explode('-', $data[$ih]['Criteria'])[0],
                 'Criteria' => $data[$ih]['Criteria'],
                 'Bounces' => $data[$ih]['Bounces'],
                 'Clicks' => $data[$ih]['Clicks'],
                 'Impressions' => $data[$ih]['Impressions'],
                 'Placement' => $data[$ih]['Placement'],
                 'AdId' => $data[$ih]['AdId'],
                 'AdNetworkType' => $data[$ih]['AdNetworkType'],


                 'Cost' => $data[$ih]['Cost'],
                 'Date' => $data[$ih]['Date'],
                 'my_company_id' => $my_company_id,
                 'otchet' => $new_otchet,

             ]);

         }catch (\Exception $e){


         }
        }

    }


}
    /**/





    public function create_metrika_from_direct($date,$my_company_id,$site_id){
if($my_company_id==99){
    print('NIKITENKO');
    info($date);


}

var_dump($date);
$text='';print time().'<br>';
foreach ($date as $key=>$val){







 /*   \DB::connection('neiros_metrica')->table('metrica_'.$my_company_id)->where('typ','Директ')->where('reports_date',$key)->delete();*/

    $get_ids_metrika=NeirosUtm::where('neiros_p0','direct1')->where('site_id',$site_id)->pluck('neiros_visit');

    $result = DB::connection('neiros_metrica')->table('metrica_'.$my_company_id)
        ->where('site_id', $site_id)->where('reports_date', $key)->where('bot', 0)
        ->where(function ($query) use ($get_ids_metrika){
            $query->orwherein('neiros_visit',$get_ids_metrika);
            $query->orwhere('typ','direct');
            $query->orwhere('typ','payment');

        })
        ->select('typ', 'src','cmp',
            DB::raw($this->get_zapros('sdelka')  ),
            DB::raw( $this ->get_zapros('lead')),
            DB::raw( $this->get_zapros('summ')),
           DB::raw('count(DISTINCT(src)) as count_group')
        )->first() ;






    $cost= DB::connection('neiros_direct1')->table('direct_otchet_parcer_'.$my_company_id)->where('Date',$key) ->sum( 'Cost');
    $cost=round($cost / 1000000*1.2, 2);

    $Clicks= DB::connection('neiros_direct1')->table('direct_otchet_parcer_'.$my_company_id)->where('Date',$key) ->sum( 'Clicks');


    $metrika = new MetricaCurrent();

    $metrika=$metrika->setTable('metrica_' . $my_company_id)->where('typ','Директ')
        ->where('reports_date',$val)->first();
    if($metrika){
        $metrika ->setTable('metrica_' . $my_company_id);
        $metrika->sdelka = $result->sdelka;
        $metrika->lead = $result->lead;
        $metrika->summ = $result->summ;
        $metrika->cost = $cost;
        $metrika->unique_visit = $Clicks;
        $metrika->save();




    }else {
        $metrika = new MetricaCurrent();

        $metrika = $metrika->setTable('metrica_' . $my_company_id);
        $metrika->key_user = '';
        $metrika->fd = '';
        $metrika->ep = '';
        $metrika->rf = '';
        $metrika->neiros_visit = 0;
        $metrika->typ = 'Директ';
        $metrika->mdm = '';
        $metrika->src = '';
        $metrika->cmp = '';
        $metrika->cnt = '';
        $metrika->trim = '';
        $metrika->uag = '';
        $metrika->visit = 1;
        $metrika->sdelka = $result->sdelka;
        $metrika->lead = $result->lead;
        $metrika->summ = $result->summ;
        $metrika->promocod = '';
        $metrika->_gid = '';
        $metrika->_ym_uid = '';
        $metrika->olev_phone_track = '';
        $metrika->ip = '';
        $metrika->utm_source = '';
        $metrika->site_id = $site_id;
        $metrika->my_company_id = $my_company_id;
        $metrika->reports_date = $key;
        $metrika->updated_at = date('Y-m-d H:i:s');
        $metrika->created_at = date('Y-m-d H:i:s');

        $metrika->bot = 0;
        $metrika->cost = $cost;
        $metrika->unique_visit = $Clicks;
        $metrika->save();
    }

}
        print time().'<br>';
echo $text;
}
    public function get_zapros($pole)
    {
        $text = 'sum(' . $pole . ') as ' . $pole;

        return $text;

    }
    public function get_companys($widget_direct,$is_first=null)
    {


        $wm = DB::table('widget_direct')->where('id', $widget_direct) ->first();
        $widget = DB::table('widgets')->where('id', $wm->widget_id)->first();
  if(!is_null($is_first)) {    DB::table('metrika_direct_company')->where('my_company_id', $widget->my_company_id)->where('site_id',  $widget->sites_id)->delete();}
        $credentials = new Credentials($wm->email, $wm->token);
        $transport = new Transport([
            'baseUrl' => 'https://api.direct.yandex.ru',
            'logger' => new EchoLog
        ]);
        $client = new Client($credentials, $transport);
        $resp = $client->campaigns->get(['Types' => ['TEXT_CAMPAIGN', 'MOBILE_APP_CAMPAIGN', 'DYNAMIC_TEXT_CAMPAIGN']/*,
            "States" => ["OFF", "ON","ARCHIVED"]*/], ['Id', 'Type', 'Name']);//получение списка компаний

        if (isset($resp['result']['Campaigns'])) {
            /*(`id`, `my_company_id`, `site_id`, `widget_id`, `widget_direct_id`, `company`, `name`, `status`) */
            $company_array = $resp['result']['Campaigns'];
            for ($i = 0; $i < count($company_array); $i++) {

                $prov = DB::table('metrika_direct_company')->where('my_company_id', $widget->my_company_id)->where('site_id',$widget->sites_id)->where('company', $company_array[$i]['Id'])->first();
                if (!$prov) {
                    DB::table('metrika_direct_company')->insert([
                        'my_company_id' => $widget->my_company_id,
                        'site_id' => $widget->sites_id,
                        'widget_id' => $wm->widget_id,
                        'widget_direct_id' => $wm->id,
                        'company' => $company_array[$i]['Id'],
                        'name' => $company_array[$i]['Name'],
                        'Type' => $company_array[$i]['Type'],
                        'status' => 0


                    ]);

                }


            }


        }


    }


    public function set_token($id)
    {


        $user = Auth::user();;
        $states = $id;
        $client = new OAuthClient('304416a2cfd8473da365c2ed67c5698a');


//Передать в запросе какое-то значение в параметре state, чтобы Yandex в ответе его вернул

        $client->authRedirect(true, OAuthClient::CODE_AUTH_TYPE, $states);

    }

    public function widget_metrika_token(Request $request)
    {


        $user = Auth::user();;
        $client = new OAuthClient('304416a2cfd8473da365c2ed67c5698a', 'f3f7e8f021d34a329ca49403b876c610');

        try {
            if (!isset($_REQUEST['code'])) {
                return redirect('https://cloud.neiros.ru/widget/tip/10');
            }
            $client->requestAccessToken($_REQUEST['code']);
        } catch (AuthRequestException $ex) {
            echo $ex->getMessage();
        }


        $token = $client->getAccessToken();

        DB::table('widget_direct')->where('id', $_REQUEST['state'])->where('my_company_id', $user->my_company_id)->update(['token' => $token]);
        $wm = DB::table('widget_direct')->where('id', $_REQUEST['state'])->first();

        $this->get_companys($wm->id,1);
        return redirect('https://cloud.neiros.ru/widget/tip/10');


        /*283243},{"Id":283244},{"Id":283245*/

        $n = $client->reports->get(
        /* Selection criteria */
            [
                /*'Filter'=> [
                    [
                        'Field' => 'CampaignId',
                        'Operator' => 'IN',
                        'Values' => ['283243','283244','283245' ]
                    ]
                ]*/
            ],
            /* Field names */
            ['CampaignId', 'CampaignName', 'AdGroupId', 'AdGroupName', 'Query', 'Date', 'Cost', 'Criteria'],
            /* Report name */
            'Campaign #t, n-1' . date('M'),
            /* Report type */
            'SEARCH_QUERY_PERFORMANCE_REPORT',
            /* Date range type */
            'ALL_TIME',
            /* Page */
            null,
            /* OrderBy */
            /* ['Field' => 'Date']*/
            null,
            /* Include VAT, Include discount, Format */
            'NO', 'NO', 'TSV'
        );


    }

    /* public function widget_metrika_get_keywords($widget, $widget_email, $last_upload)
     {



         $zapros = 'https://api-metrika.yandex.ru/stat/v1/data?preset=sources_search_phrases&dimensions=ym:s:lastSearchPhrase,ym:s:clientID,ym:s:dateTime,ym:s:lastSearchEngine,ym:s:lastSearchEngineRoot&id=' . $widget_email->counter . '&oauth_token=' . $widget_email->token . '&limit=300&date1=' . $last_upload;

         $otvet = file_get_contents($zapros);
         $otvet_encode = json_decode($otvet);
         $datas = $otvet_encode->data;
         $insert = array();
         for ($i = 0; $i < count($datas); $i++) {


             $insert[$i]['keyword'] = $datas[$i]->dimensions[0]->name;
             $insert[$i]['ids'] = $datas[$i]->dimensions[1]->name;
             $insert[$i]['created_at'] = $datas[$i]->dimensions[2]->name;
             $insert[$i]['my_company_id'] = $widget->my_company_id;
             $insert[$i]['widget_metrika_id'] = $widget_email->id;
             $insert[$i]['counter'] = $widget_email->counter;
             $insert[$i]['widget_id'] = $widget->id;
             $insert[$i]['SearchEngine'] = $datas[$i]->dimensions[3]->name;;
             $insert[$i]['SearchEngine_id'] = $datas[$i]->dimensions[3]->id;
             $insert[$i]['SearchEngineRoot'] = $datas[$i]->dimensions[4]->name;


         }
         DB::table('metrika_keywords_import')->insert($insert);
         $total_rows = $otvet_encode->total_rows;
         $amount = floor($total_rows / 300);

         for ($is = 1; $is <= $amount; $is++) {
             $ofset = $is * 300 + 1;
             $zapros = 'https://api-metrika.yandex.ru/stat/v1/data?preset=sources_search_phrases&dimensions=ym:s:lastsignSearchPhrase,ym:s:clientID,ym:s:dateTime,ym:s:lastSearchEngine,ym:s:lastSearchEngineRoot&id=' . $widget_email->counter . '&oauth_token=' . $widget_email->token . '&offset=' . $ofset . '&limit=300&date1=' . $last_upload;

             $otvet = file_get_contents($zapros);
             $otvet_encode = json_decode($otvet);
             $datas = $otvet_encode->data;
             $insert = array();
             for ($i = 0; $i < count($datas); $i++) {


                 $insert[$i]['keyword'] = $datas[$i]->dimensions[0]->name;
                 $insert[$i]['ids'] = $datas[$i]->dimensions[1]->name;
                 $insert[$i]['created_at'] = $datas[$i]->dimensions[2]->name;
                 $insert[$i]['my_company_id'] = $widget->my_company_id;
                 $insert[$i]['widget_metrika_id'] = $widget_email->id;
                 $insert[$i]['counter'] = $widget_email->counter;
                 $insert[$i]['widget_id'] = $widget->id;
                 $insert[$i]['SearchEngine'] = $datas[$i]->dimensions[3]->name;;
                 $insert[$i]['SearchEngine_id'] = $datas[$i]->dimensions[3]->id;
                 $insert[$i]['SearchEngineRoot'] = $datas[$i]->dimensions[4]->name;


             }

             DB::table('metrika_keywords_import')->insert($insert);

         }


     }*/
}
