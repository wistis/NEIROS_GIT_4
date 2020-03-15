@extends('app')
@section('title')
    {{$title}}

@endsection
@section('newjs')
    <script type="text/javascript" src="/global_assets/js/plugins/forms/styling/switchery.min.js"></script>
    <link href="/default/assets/css/components.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/js/jscolor.js"></script>
    <script type="text/javascript" src="/default/assets/js/plugins/ui/moment/moment.min.js"></script>
    <script type="text/javascript" src="//cdn.bootcss.com/echarts/4.0.4/echarts.min.js"></script>
@endsection
@section('content')

@include('modal.openmodal')
<div class="row"> <div class="page-title col-md-2" style="padding: 10px">
    <h1><span class="text-semibold">@yield('title')</span>  </h1>

</div>
    <div class="col-md-1"><input type="checkbox"  id="status" class="switchery1"
                                 name="status" @if($widget->status==1) checked="checked"
                                 @endif  data-id="{{$widget->id}}">
    </div>


</div>

<div id="formodal"></div>
    <div class=" row"  >
        <ul class="nav nav-tabs"style="margin-bottom: 0px">
            <li class="active"><a href="#basic-tab6" data-toggle="tab">Статистика</a></li>
            <li  ><a href="#basic-tab1" data-toggle="tab">Основное</a></li>
            <li class=""><a href="#basic-tab2" data-toggle="tab">Номера</a></li>
            <li class=""><a href="#basic-tab3" data-toggle="tab">Сценарии</a></li>
            <li class=""><a href="#basic-tab4" data-toggle="tab">Входящие звонки</a></li>
            <li class=""><a href="#basic-tab5" data-toggle="tab">Промокоды</a></li>


        </ul>

    </div>


    <!-- Fieldset legend -->
    <div class="row">

        <!-- /fieldset legend -->


        <!-- 2 columns form -->
        <form class="form-horizontal" action="#" method="post">
            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>

            <div class="panel panel-flat">
                <div class="panel-heading">

                    <input name="widget_id" type="hidden" id="widget_id" value="{{$widget->id}}"/>
                    <input name="widget_callback_id" type="hidden" id="widget_callback_id"
                           value="{{$widget_callback->id}}"/>
                </div>


                <div class="panel-body">

                    <div class="tabbable">

                        <div class="tab-content">
                            <div class="row tab-pane active" id="basic-tab6">
                                <h2 class="panel-title">Статистика</h2>
                                <div class="col-md-12">
@include('stat.other')
                                </div>
                                {{--Дополнительные поля--}}

                            </div>
                            <div class="row tab-pane  " id="basic-tab1">
                                <h2 class="panel-title">Основное</h2>
                                <div class="col-md-6">
                                    <fieldset>



                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Номер для переадресации
                                                уведомлений:</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="outputcall" id="email"
                                                       value="{{$widget_callback->outputcall}}" required>

                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Class или ID:</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="element" id="tags"
                                                       value="{{$widget_callback->element}} ">

                                            </div>

                                        </div>
                                        <div class="text-right">
                                            <button type="button" class="btn btn-primary edit_widget">Сохранить<i
                                                        class="icon-arrow-right14 position-right"></i></button>
                                        </div>

                                    </fieldset>
                                </div>
                                {{--Дополнительные поля--}}

                            </div>
                            {{--Номера--}}
                            <div class="row tab-pane " id="basic-tab2">
                                <h2 class="panel-title">Номера</h2>
                                <div class="col-md-3"><a class="btn btn-info" href="#myModalBox" data-toggle="modal">Добавить
                                        номера</a></div>
                                <div class="col-md-3"><a class="btn btn-info" href="#"
                                                         onclick="delete_from_routing();return false">Удалить из
                                        сценария</a></div>
                                <div class="col-md-12">
                                    <fieldset>

                                        <table class="table table-bordered">
                                            <tr>
                                                <td></td>
                                                <td>Номер</td>
                                                <td>Сценарий</td>
                                                <td>Звонки</td>
                                                <td>Подключен</td>
                                                <td></td>


                                            </tr>
                                            @foreach($phones as $phone)
                                                <tr id="ids{{$phone->id}}">
                                                    <td><input type="checkbox" class="my_numberscheckbox switchery1"
                                                               value="{{$phone->input}}"></td>
                                                    <td>{{$phone->input}} </td>
                                                    <td id="phoneroutname{{$phone->input}}">@if(isset($phone->routingm->name)) {{$phone->routingm->name}} @endif</td>
                                                    <td>{{$phone->amout_call}}</td>
                                                    <td>{{date('d-m-Y',strtotime($phone->created_at))}}</td>
                                                    <td><a href="#"
                                                           onclick="delete_number({{$phone->input}},{{$phone->id}})"><i
                                                                    class="glyphicon  glyphicon-trash"
                                                                    style="color: red"></i> </a></td>


                                                </tr>
                                            @endforeach

                                        </table>
                                    </fieldset>
                                </div>
                                {{--Дополнительные поля--}}

                            </div>
                            {{--Номера--}}
                            <div  class="row tab-pane " id="basic-tab4">
                                <h2 class="panel-title">Входящие звонки</h2>
                                <table class="table table-bordered">
                                    <tr>
                                        <td>Дата</td>
                                        <td>НаНомер</td>
                                        <td>Номер</td>
                                        <td>Ожидание</td>
                                        <td>Длительность разговора</td>
                                        <td>Статус</td>
                                        <td>Запись</td>
                                        <td>Расшифровка</td>
                                    </tr>
                                    @foreach($input_calls as $cal)
                                        <tr>
                                            <td>{{date('H:i:s d-m-Y',strtotime($cal->calldate))}}</td>
                                            <td>{{$cal->did}}</td>
                                            <td>{{$cal->src}}</td>
                                            <td>{{($cal->duration-$cal->billsec)}}</td>
                                            <td>{{$cal->billsec}} </td>
                                            <td>{{$cal->disposition}}</td>
                                            <td><audio controls>
                                                    <source src="http://82.146.43.227/records/{{date('Y',strtotime($cal->calldate))}}/{{date('m',strtotime($cal->calldate))}}/{{date('d',strtotime($cal->calldate))}}/{{$cal->record_file}}.mp3" type="audio/mp3" >

                                                    http://82.146.43.227/records/{{date('Y',strtotime($cal->calldate))}}/{{date('m',strtotime($cal->calldate))}}/{{date('d',strtotime($cal->calldate))}}/{{$cal->record_file}}.mp3
                                                </audio></td>
                                            <td>




@if($cal->totext==0) <a href="https://cloud.neiros.ru/upaudio/{{$cal->id}}" target="_blank">Расшифровать</a> @else


                <a href="#" onclick="get_dialog({{$cal->id}})"  >Посмотреть</a>


                                                @endif
                                                </td>




                                        </tr>

                                    @endforeach
                                </table>
                            </div>
                            {{--routing--}}
                            <div class="row tab-pane " id="basic-tab3">
                                <h2 class="panel-title">Сценарии</h2>
                                <a class="btn btn-info" href="#" onclick="open_myModalBox_add_rout()" >Добавить
                                    сценарий</a>
                                <div class="col-md-12">
                                    <fieldset>

                                        <table class="table table-bordered">
                                            <tr>
                                                <td>Статус</td>
                                                <td>Название</td>
                                                <td>Тип подмены</td>
                                                <td>Номеров</td>
                                                <td>Точность</td>
                                                <td>Звонков</td>
                                                <td>Дата создания</td>
                                                <td>Звонок на</td>
                                                <td>Действия</td>
                                                <td>Действия</td>


                                            </tr>
                                            @foreach($routes as $rout)
                                                <tr id="idsr{{$rout->id}}">
                                                    <td>
                                                        <div class="checkbox checkbox-switchery ">
                                                            <label>
                                                                <input type="checkbox" class="switchery1"
                                                                       id="statusrout{{$rout->id}}"
                                                                       name="status"
                                                                       @if($rout->status==1) checked="checked"
                                                                       @endif  data-id="{{$rout->id}}">

                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>{{$rout->name}}</td>
                                                    <td>@if($rout->tip_calltrack==1)  Динамический @else
                                                            Статический @endif</td>
                                                    <td>
                                                        @if(count($rout->phones)>0)
                                                            <button type="button" class="btn btn-default btn-sm"
                                                                    data-popup="tooltip"
                                                                    title="@foreach($rout->phones as $pho)
                                                                    {{$pho->input}}<br>

                                                  @endforeach             " data-html="trur"
                                                                    data-trigger="click">{{count($rout->phones)}}</button>@else


                                                            0 @endif</td>
                                                    <td>@if($rout->tip_calltrack==1)
                                                            0% @else   @if(count($rout->phones)>0) 100% @else
                                                                0% @endif @endif</td>
                                                    <td>
                                                        @if(count($rout->phones)>0)


                                                            {{$rout->phones->sum('amout_call')}}




                                                        @else 0 @endif


                                                    </td>
                                                    <td>{{date('d-m-Y',strtotime($rout->created_at))}}</td>
                                                    <td>{{ $rout->number_to}}</td>
                                                    <td><a href="#"
                                                           onclick="edit_routing({{$rout->id}})"><i
                                                                    class="glyphicon  glyphicon-pencil"
                                                                    style="color: blue"></i> </a></td>
                                                    <td><a href="#"
                                                           onclick="delete_routing({{$rout->id}})"><i
                                                                    class="glyphicon  glyphicon-trash"
                                                                    style="color: red"></i> </a></td>


                                                </tr>
                                            @endforeach

                                        </table>
                                    </fieldset>
                                </div>
                                {{--Дополнительные поля--}}

                            </div>
                            <div class="row tab-pane " id="basic-tab5">
                                <h2 class="panel-title">Промокоды</h2>

                                <div class="col-md-6">
                                    <fieldset>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Статус промокодов:</label>
                                            <div class="col-lg-9">
                                                <div class="checkbox checkbox-switchery">
                                                    <label>
                                                        <input type="checkbox" class="switchery1"  id="status" name="status" @if($widget_prom->status==1) checked="checked" @endif  data-id="{{$widget_promokod->id}}">

                                                    </label>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Цвет текста:</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control jscolor" name="color" id="color"  value="{{$widget_promokod->color}}"  required>

                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Цвет фона:</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control jscolor" name="background" id="background"  value="{{$widget_promokod->background}}"  required>

                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Расположение по горизонтали:</label>
                                            <div class="col-md-9">
                                                <select id="position_x" name="position_x" class="form-control">
                                                    <option value="left" @if($widget_promokod->position_x=='left') selected @endif >Слева</option>
                                                    <option value="right" @if($widget_promokod->position_x=='right') selected @endif >Справа</option>

                                                </select>


                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Расположение по вертикали:</label>
                                            <div class="col-md-9">
                                                <select id="position_y" name="position_y" class="form-control">
                                                    <option value="top" @if($widget_promokod->position_y=='top') selected @endif >Вверху</option>
                                                    <option value="bottom" @if($widget_promokod->position_y=='bottom') selected @endif >Внизу</option>

                                                </select>


                                            </div>

                                        </div>










                                    </fieldset>
                                </div>
                                {{--Дополнительные поля--}}

                            </div>
                            {{--routing--}}
                        </div>

                    </div>
                </div>
        </form>


        @endsection
        @section('skriptdop')
        
        <div id="WidgetModal2" class="modal WidgetModalNew fade ClientInfoModal lids-neiros">
    <div class="modal-dialog" >
        <div class="modal-content"  style="height: 100vh">
            <!-- Заголовок модального окна -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >×</button>
            </div>
            <!-- Основное содержимое модального окна -->
            <div class="modal-body">
            <div class="name-block-fixed">
           <div class="col-xs-12" ><div class="h1-modal pos-left">Настройки виджета <span></span></div>
           
           <button type="button" class="btn btn-primary widget-status-btn"  data-id="">Подключить</button>
           </div>
          <?php /*?> <div class="col-sm-7 col-xs-12" ><div class="h1-modal pos-right">Активность</div></div><?php */?>
            </div>
            
            <div class="col-xs-12 block-descr">  
          <div class="col-sm-6 col-xs-12 text-center"><div class="img-block-left"><img  src=""></div></div>
          <div class="col-sm-6 col-xs-12">  
          	<div class="paragraph">Яндекс Метрика — бесплатный интернет-сервис компании Яндекс, предназначенный для оценки посещаемости веб-сайтов, и анализа поведения пользователей. На данный момент Яндекс.Метрика является третьей по размеру системой веб-аналитики в Европе.</div>
          
          
  

                               
                               
								<button type="button" class="btn btn-primary set_status widget_status_checkbox"  >Подключить</button>
                                
                             
                            </div>
                
                </div>
                
                
                <div class="col-xs-12 accordion-setings">
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

  
			<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading-1">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-1" aria-expanded="false" aria-controls="collapse-1">
            <div class="number-accardion">1</div>
            <div class="h-1">Основное</div>
            <div class="descr-text">основные настройки </div>
        </a>
    </div>
    <div id="collapse-1" class="panel-collapse collapse" role="tabpane1" aria-labelledby="heading-1" aria-expanded="false" style="height: 0px;">

		<div class="panel-body">
        asdasdas dadasd adas dasd asdasdasd ad 
        <div class="banel-body-footer">
  			<button type="button" class="btn btn-primary save-setings">Сохранить</button>	
        </div>    
    </div>
    
</div>
</div>
</div>
                </div>
            </div>	
            </div>


        <?php /*?><div class="modal-body infclinfo" >

            </div><?php */?>
        <!-- Футер модального окна -->

        </div>
    </div>
        
        
        
        
        
        
        
        
            <script>
                $('.edit_widget').click(function () {
                    widget_id = $('#widget_id').val();
                    widget_callback_id = $('#widget_callback_id').val();
                    if ($('#status').prop('checked')) {
                        status = 1;
                    } else {
                        status = 0;
                    }
                    datatosend = {
                        widget_id: widget_id,
                        widget_promokod_id: widget_callback_id,
                        status: status,
                        email: $('#email').val(),
                        tags: $('#tags').val(),


                        _token: $('[name=_token]').val(),


                    }


                    $.ajax({
                        type: "POST",
                        url: '/widget/safe',
                        data: datatosend,
                        success: function (html1) {

                            $.jGrowl('Изменения успешно сохранены', {
                                header: 'Успешно!',
                                theme: 'bg-success'
                            });

                        }
                    })


                    return false;
                });


                function delete_routing(ids) {
                    $.jGrowl('Изменения успешно сохранены', {
                        header: 'Успешно!',
                        theme: 'bg-success'
                    });
                    widget_id = $('#widget_id').val();

                    $('#idsr' + ids).hide();
                    datatosend = {

                        widget_id: widget_id,

                        ids: ids,
                        _token: $('[name=_token]').val(),
                    }
                    $.ajax({
                        type: "POST",
                        url: '/ajax/delete_routiing_calltrack',
                        data: datatosend,
                        success: function (html1) {


                        }
                    })
                }

                function delete_number(number, ids) {
                    $.jGrowl('Изменения успешно сохранены', {
                        header: 'Успешно!',
                        theme: 'bg-success'
                    });
                    widget_id = $('#widget_id').val();
                    widget_callback_id = $('#widget_callback_id').val();
                    $('#ids' + ids).hide();
                    datatosend = {

                        widget_id: widget_id,
                        widget_promokod_id: widget_callback_id,

                        number: number,
                        ids: ids,
                        _token: $('[name=_token]').val(),
                    }
                    $.ajax({
                        type: "POST",
                        url: '/widget/deletephone',
                        data: datatosend,
                        success: function (html1) {


                        }
                    })
                }

                
                function delete_from_routing() {
                    my_numberscheckbox = [];
                    $('.my_numberscheckbox:checked').each(function () {
                        my_numberscheckbox.push($(this).val());
                        $('#phoneroutname'+$(this).val()).html('');
                    });
                    $.jGrowl('Изменения успешно сохранены', {
                        header: 'Успешно!',
                        theme: 'bg-success'
                    });
                    widget_id = $('#widget_id').val();

                    ;
                    datatosend = {

                        widget_id: widget_id,

                        numbers: my_numberscheckbox,
                        _token: $('[name=_token]').val(),
                    }
                    $.ajax({
                        type: "POST",
                        url: '/ajax/delete_from_routing',
                        data: datatosend,
                        success: function (html1) {


                        }
                    })


                }

                function edit_routing(id) {
                    datatosend = {

                        widget_id:    $('#widget_id').val() ,

                        ids: id,
                        _token: $('[name=_token]').val(),
                    }
                    $.ajax({
                        type: "POST",
                        url: '/ajax/edit_routing_get',
                        data: datatosend,
                        success: function (html1) {

                            $('#myModalBox_add_rout').modal('show');
                            $('#ar_id').val(id);
res=JSON.parse(html1);

                            $('#utm_campaign').val(res['utm_campaign']);
                            $('#utm_content').val(res['utm_content']);
                            $('#utm_medium').val(res['utm_medium']);
                            $('#utm_source').val(res['utm_source']);
                            $('#utm_term').val(res['utm_term']);



                            $('#ar_name').val(res['name']);

                            var radios = $('.ar_reditrect');
                              radios.prop('checked', false);;

                                radios.filter('[value='+res['tip_redirect']+']').prop('checked', true);

                            $('#ar_phone_redirect' + res['tip_redirect']).val(res['number_to']);


                            var tip_calltrack = $('.ar_tip_calltrack');
                            tip_calltrack.prop('checked', false);;
                            tip_calltrack.filter('[value='+res['tip_calltrack']+']').prop('checked', true);

if(res['tip_calltrack']==2){
 $('.mymetki').show();
}


                            load_free_numbers();

                        }
                    })
                }
                /*INSERT INTO `widgets_phone_routing`(`id`, `widget_id`, `my_company_id`, `tip_redirect`, `number_to`, `tip_calltrack`, `created_at`, `updated_at`, `name`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9])*/

                function open_myModalBox_add_rout() {
                    $('#myModalBox_add_rout').modal('show');
                    $('#ar_id').val(0);

                    load_free_numbers();
                    $('#ar_id').val(0);


                    $('#ar_name').val('');

                    var radios = $('.ar_reditrect');
                    radios.prop('checked', false);;

                    radios.filter('[value=0]').prop('checked', true);

                    $('#ar_phone_redirect0').val('');
                    $('#ar_phone_redirect1').val('');
                    $('#ar_phone_redirect2').val('');


                    var tip_calltrack = $('.ar_tip_calltrack');
                    tip_calltrack.prop('checked', false);;
                    tip_calltrack.filter('[value=0]').prop('checked', true);
                    load_free_numbers();

                }

                function load_free_numbers() {
                    datatosend = {

                        widget_id:    $('#widget_id').val() ,


                        _token: $('[name=_token]').val(),
                    }
                    $.ajax({
                        type: "POST",
                        url: '/ajax/load_free_numbers',
                        data: datatosend,
                        success: function (html1) {

                            $('#fee_numbers_list').html(html1);

                        }
                    })
                }
                function get_dialog(id) {
                    datatosend = {

                        id:    id ,


                        _token: $('[name=_token]').val(),
                    }
                    $.ajax({
                        type: "POST",
                        url: '/ajax/get_dialog',
                        data: datatosend,
                        success: function (html1) {
alert(html1);
$('#openmodal').modal('show');
                            $('#get_dialog_html').html(html1);

                        }
                    })
                }

                var elems = document.querySelectorAll('.switchery1');

                for (var i = 0; i < elems.length; i++) {
                    var switchery = new Switchery(elems[i],{ size: 'small' });
                }
            </script>
    @include('widgets.modaladdphone')
    @include('modal.myModalBox_add_rout')

@endsection

