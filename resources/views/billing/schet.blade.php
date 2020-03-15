<!doctype html>
<html>
<head>@inject('Check','\App\Http\Controllers\CheckcompanysControllers')
    <title>Счет № {{$zakaz->id}} от {{date('d.m.Y',strtotime($zakaz->created_at))}}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        body { width: 210mm; margin-left: auto; margin-right: auto;  solid; font-size: 11pt;}
        table.invoice_bank_rekv { border-collapse: collapse; border: 1px solid; }
        table.invoice_bank_rekv > tbody > tr > td, table.invoice_bank_rekv > tr > td { border: 1px solid; }
        table.invoice_items { border: 1px solid; border-collapse: collapse;}
        table.invoice_items td, table.invoice_items th { border: 1px solid;}
    </style>
    <script>window.print() ;</script>
</head>
<body>@php
        $rec=\App\PayCompany::find(7);

        @endphp
<table width="100%">
    <tr>
        <td><img src="https://cloud.neiros.ru/images/logo.png">&nbsp;</td>
        <td style="width: 155mm;">
            <div style="width:155mm; ">Внимание! Счет действителен в течение 3-х банковских дней. Оплата данного счета означает согласие с условиями поставки товара. Уведомление об оплате  обязательно, в противном случае не гарантируется наличие товара на складе. Товар отпускается по факту прихода денег на р/с Поставщика, самовывозом, при наличии доверенности и паспорта.</div>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <div style="text-align:center;  font-weight:bold;">
                Образец заполнения платежного поручения                                                                                                                                            </div>
        </td>
    </tr>
</table>

{{--"id" => "7"
    "my_company_id" => "20"
    "tip" => "0"
    "short_name" => "ООО "Нейрос""
    "full_name" => "Общество с ограниченной ответственностью "Нейрос""
    "kpp" => "780401001"
    "ogrn" => "1197847211880"
    "phone" => "+7 (812) 200-93-57"
    "email" => "vog@olever.ru"
    "fio" => "Мария"
    "ur_adres" => "195265 ГОРОД САНКТ-ПЕТЕРБУРГ УЛИЦА ЛУЖСКАЯ ДОМ 3 КОРПУС 2 ЛИТЕР А ОФИС 226"
    "post_adres" => "195265 ГОРОД САНКТ-ПЕТЕРБУРГ УЛИЦА ЛУЖСКАЯ ДОМ 3 КОРПУС 2 ЛИТЕР А ОФИС 226"
    "bik" => "044525999"
    "rs" => "40702810503500021661"
    "bank_info" => "{"bik":"044525999","ks":"30101810845250000999","name":"ТОЧКА ПАО БАНКА &quot;ФК ОТКРЫТИЕ&quot;","namemini":"ТОЧКА ПАО БАНКА &quot;ФК ОТКРЫТИЕ&quot;","index":"11 ▶"
    "created_at" => null
    "updated_at" => null
    "inn" => "7804660063"--}}
<table width="100%" cellpadding="2" cellspacing="2" class="invoice_bank_rekv">
    <tr>
        <td colspan="2" rowspan="2" style="min-height:13mm; width: 105mm;">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="height: 13mm;">
                <tr>
                    <td valign="top">
                        <div>{{$rec->bank_info['namemini']}}</div>
                    </td>
                </tr>
                <tr>
                    <td valign="bottom" style="height: 3mm;">
                        <div style="font-size:10pt;">Банк получателя        </div>
                    </td>
                </tr>
            </table>
        </td>
        <td style="min-height:7mm;height:auto; width: 25mm;">
            <div>БИK</div>
        </td>
        <td rowspan="2" style="vertical-align: top; width: 60mm;">
            <div style=" height: 7mm; line-height: 7mm; vertical-align: middle;">{{$rec->bank_info['bik']}}</div>
            <div>{{$rec->bank_info['ks']}}</div>
        </td>
    </tr>
    <tr>
        <td style="width: 25mm;">
            <div>Сч. №</div>
        </td>
    </tr>
    <tr>
        <td style="min-height:6mm; height:auto; width: 50mm;">
            <div>ИНН {{$rec->inn}}</div>
        </td>
        <td style="min-height:6mm; height:auto; width: 55mm;">
            <div>КПП {{$rec->kpp}}</div>
        </td>
        <td rowspan="2" style="min-height:19mm; height:auto; vertical-align: top; width: 25mm;">
            <div>Сч. №</div>
        </td>
        <td rowspan="2" style="min-height:19mm; height:auto; vertical-align: top; width: 60mm;">
            <div>{{$rec->rs}}</div>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="min-height:13mm; height:auto;">

            <table border="0" cellpadding="0" cellspacing="0" style="height: 13mm; width: 105mm;">
                <tr>
                    <td valign="top">
                        <div>{{$rec->short_name}}</div>
                    </td>
                </tr>
                <tr>
                    <td valign="bottom" style="height: 3mm;">
                        <div style="font-size: 10pt;">Получатель</div>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>
<br/>

<div style="font-weight: bold; font-size: 16pt; padding-left:5px;">
    Счет № {{$zakaz->id}} от {{date('d.m.Y',strtotime($zakaz->created_at))}}</div>
<br/>

<div style="background-color:#000000; width:100%; font-size:1px; height:2px;">&nbsp;</div>

<table width="100%">
    <tr>
        <td style="width: 30mm;">
            <div style=" padding-left:2px;">Поставщик:    </div>
        </td>
        <td>
            <div style="font-weight:bold;  padding-left:2px;">
                {{$rec->short_name}}, ИНН {{$rec->inn}}, {{$rec->ur_adres}}, тел.:  {{$rec->phone}}				            </div>
        </td>
    </tr>
    <tr>
        <td style="width: 30mm;">
            <div style=" padding-left:2px;">Покупатель:    </div>
        </td>
        <td>
            <div style="font-weight:bold;  padding-left:2px;">
                {{$company->short_name}}, ИНН {{$company->inn}}, {{$company->ur_adres}}, тел.: {{$company->phone}}            </div>
        </td>
    </tr>
</table>


<table class="invoice_items" width="100%" cellpadding="2" cellspacing="2">
    <thead>
    <tr>
        <th style="width:13mm;">№</th>
        <th >Наименование товара, работы, услуги</th>
        <th style="width:20mm;">Сумма</th>

    </tr>
    </thead>
    <tbody >
    <td style="width:13mm;">1</td>
    <td >За предоставление неисключительной лицензии сервиса Neiros</td>
    <td style="width:20mm;">{{$zakaz->summ}}</td>
    </tbody>
</table>



<br />
<div>
   Всего наименований 1 на сумму {{$zakaz->summ}} рублей.<br />
    <!-- Ноль рублей 00 копеек--></div>
<br /><br />
<div style="background-color:#000000; width:100%; font-size:1px; height:2px;">&nbsp;</div>
<br/>

<div ><div style="position: absolute;
margin-top: 45px;
margin-left: 87px;"><img src="https://cloud.neiros.ru/images/pechat.png" style="width: 145px;
margin-top: -49px;"></div>
    <div style="position: absolute;

margin-top: -29px;
margin-left: 140px;"><img src="https://cloud.neiros.ru/images/podpis.png" style="width: 103px;"></div>


    Руководитель ______________________ (Вершинина М.Б)</div>
<br/>

{{--div>Главный бухгалтер ______________________ (Дьяков М.В.)</div>
<br/>--}}

<div style="width: 85mm;text-align:center;">М.П.</div>
<br/>


<div style="width:800px;text-align:left;font-size:10pt;"> </div>

</body>
</html>