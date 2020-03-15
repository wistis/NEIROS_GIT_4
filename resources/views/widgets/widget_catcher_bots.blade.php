@extends('app')
@section('title')
    Виджеты

@endsection
@section('newjs')
    <script type="text/javascript" src="/default/assets/js/plugins/forms/styling/switchery.min.js"></script>
    <script type="text/javascript" src="/default/assets/js/plugins/forms/styling/switch.min.js"></script>
    <script type="text/javascript" src="/js/jscolor.js"></script>

@endsection
@section('content')
    @include('modal.modal_add_bot_url')
    <div class="breadcrumb-line breadcrumb-line-component" style="margin-bottom: 10px"><a
                class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
        <ul class="breadcrumb">
            <li><a href="/"><i class="icon-home2 position-left"></i> Главная</a></li>
            <li><a href="/widget"> Виджеты</a></li>
            <li class="active">Редактирование</li>
        </ul>
        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>

    </div>


    <!-- Fieldset legend -->
    <div class="row">

        <!-- /fieldset legend -->


        <!-- 2 columns form -->
        <form class="form-horizontal" action="#" method="post">
            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title">Редактирование виджета "Popup"</h5>
                    <input name="widget_id" type="hidden" id="widget_id" value="{{$widget->id}}"/>
                    <input name="widget_callback_id" type="hidden" id="widget_callback_id" value="{{$widget_osn->id}}"/>
                </div>


                <div class="panel-body">

                    <div class="tabbable">
                        <ul class="nav nav-tabs">

                            <li class="active"><a href="#basic-tab3" data-toggle="tab">Стек для индекса</a></li>
                            <li ><a href="#basic-tab2" data-toggle="tab">URL</a></li>
                            <li ><a href="#basic-tab1" data-toggle="tab">Основное</a></li>

                        </ul>
                        <div class="tab-content">

                            <div class="row tab-pane" id="basic-tab1">
                                <div class="col-md-6">
                                    <fieldset>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Статус виджета:</label>
                                            <div class="col-lg-9">
                                                <div class="checkbox checkbox-switchery">
                                                    <label>
                                                        <input type="checkbox" class="switchery" id="status"
                                                               name="status" @if($widget->status==1) checked="checked"
                                                               @endif  data-id="{{$widget->id}}">

                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">token:</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="metrika_token"
                                                       id="metrika_token"
                                                       @if(strlen($widget_osn->metrika_token)<2)   value="{{$mtoken}}"
                                                       @else  value="{{$widget_osn->metrika_token}}" @endif
                                                       required>
                                                <a href="/set_token_bot/{{$widget_osn->id}}">Получить токен
                                                </a>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Код для вставки на сайт :</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control"
                                            value = '  <script type="text/javascript" src="https://cloud.neiros.ru/api/widget_site/get_bot/{{$widget_osn->id}}"></script>'

                                                        >

                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Класс или ID для замены :</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" id="id_replace"
                                                       value = "{{$widget_osn->id_replace}}"   >

                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Класс для списка :</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" id="class_ul"
                                                       value = "{{$widget_osn->class_ul}}"   >

                                            </div>

                                        </div>


                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Количество url для показа:</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="amount_url"
                                                       id="amount_url"
                                                       value="{{$widget_osn->amount_url}}"
                                                       required>

                                                </a>
                                            </div>

                                        </div>


                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Счетчики метрики:</label>
                                        <div class="col-lg-9">
                                            @foreach($widgets_catcher_bots_counter as $counter)

                                                <div><input type="radio" name="radiocounter"
                                                            @if($widget_osn->metrika_counter==$counter->counter) checked="checked"
                                                            @endif value="{{$counter->counter}}"> {{$counter->site}}
                                                    ({{$counter->counter}})
                                                </div>
                                            @endforeach

                                        </div>

                                    </div>


                                </div>
                                {{--Дополнительные поля--}}

                            </div>
                            {{--url--}}
                            <div class="row tab-pane   " id="basic-tab2">
                                <div class="col-md-12">
                                    <fieldset>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Добавить URL:</label>
                                            <div class="col-lg-9">
                                                <div class="checkbox checkbox-switchery">
                                                    <label>
                                                        <div class="btn-group">
                                                            <button type="button" data-toggle="dropdown"
                                                                    class="btn btn-default dropdown-toggle">Действия <span
                                                                        class="caret"></span></button>
                                                            <ul class="dropdown-menu">
                                                                <li><a href="#" onclick="open_addurl(1);return false;">Добавить
                                                                        списком</a></li>
                                                                <li><a href="#" onclick="open_addurl(2);return false;">Добавить
                                                                        из файла</a></li>
                                                                <li><a href="#" onclick="open_addurl(3);return false;">Загрузка индексирования из метрики </a></li>
                                                                <li><a href="#" onclick="open_addurl(4);return false;">Сформировать стек для показа </a></li>
                                                            </ul>
                                                        </div>

                                                    </label>
                                                </div>
                                            </div>
                                        </div>
<table class="table table-bordered">
    <tr>
        <td>ID</td>
        <td>URL</td>
        <td>Название</td>
        <td>Код ответа</td>
        <td>Индекс Y</td>
        <td>Индекс G</td>
    </tr>
    @foreach($urls as $url)
        <tr>
            <td>{{$url->id}}</td>
            <td>{{$url->url}}</td>
            <td>{{strip_tags($url->title)}}</td>
            <td>{{$url->kod_otveta}}</td>
            <td>@if($url->index_y==1) <span style="font-weight: bold;color: green">+</span> @endif</td>
            <td>@if($url->index_g==1) <span style="font-weight: bold;color: green">+</span> @endif</td>
            <td></td>
        </tr>
    @endforeach
</table>
<div class="row">{{$urls->links()}}</div>
                                    </fieldset>
                                </div>

                                {{--Дополнительные поля--}}

                            </div>
                            {{--url--}}
{{--stek--}}
                            <div class="row tab-pane  active" id="basic-tab3">
                                <div class="col-md-12">
                                    <fieldset>
@inject('Stek','\App\Http\Controllers\WidgetsCatcherBotsController')
                                        <table class="table table-bordered">
                                            <tr>
                                                <td>Робот</td>
                                                <td>В стеке</td>
                                                <td>В стеке показ</td>
                                                <td>В стеке на проверку</td>
                                                <td>Убрано из стека</td>
                                                <td>Показано ссылок сегодня</td>
                                                <td>Возвращено в стек</td>
                                                <td>Проиндексировано</td>
                                            </tr>
                                            @for($ig=0;$ig<2 ;$ig++)
                                                <tr>
                                                    <td>{{$Stek->getstek($ig,$widget_osn->id)['name']}}</td>
                                                    <td>{{$Stek->getstek($ig,$widget_osn->id)['amount']}}</td>
                                                    <td>{{$Stek->getstek($ig,$widget_osn->id)['stek_show']}}</td>
                                                    <td>{{$Stek->getstek($ig,$widget_osn->id)['stek_come']}}</td>
                                                    <td>{{$Stek->getstek($ig,$widget_osn->id)['stek_del']}}</td>
                                                    <td>{{$Stek->getstek($ig,$widget_osn->id)['time_y_show']}}</td>
                                                    <td></td>
                                                    <td>{{$Stek->getstek($ig,$widget_osn->id)['index_y']}}</td>


                                                    <td></td>
                                                </tr>
                                            @endfor
                                        </table>

                                    </fieldset>
                                </div>

                                {{--Дополнительные поля--}}

                            </div>

                            {{--stek--}}

                        </div>
                        <div class="text-right">
                            <button type="button" class="btn btn-primary edit_widget">Сохранить<i
                                        class="icon-arrow-right14 position-right"></i></button>
                        </div>
                    </div>
                </div>
        </form>


        @endsection
        @section('skriptdop')
            <script>
                $('.edit_widget').click(function () {
                    widget_id = $('#widget_id').val();
                    widget_callback_id = $('#widget_callback_id').val();
                    if ($('#status').prop('checked')) {
                        status = 1;
                    } else {
                        status = 0;
                    }


                    var radiocounter = $('input[name="radiocounter"]:checked').val();
                    datatosend = {
                        widget_id: widget_id,
                        widget_promokod_id: widget_callback_id,
                        status: status,
                        metrika_token: $('#metrika_token').val(),
                        radiocounter: radiocounter,
                        amount_url: $('#amount_url').val(),
                        id_replace: $('#id_replace').val(),
                        class_ul: $('#class_ul').val(),


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

                function open_addurl(tip) {
                    if (tip == 1) {
                        $('#modal_add_bot_url_1').modal('show');
                    }

                    if (tip == 3) {

                    widget_id = $('#widget_id').val();
                        widget_callback_id = $('#widget_callback_id').val();

                            datatosend = {
                                tips: tip,
                                textix: $('#modal_add_bot_url_1_text').val(),
                                _token: $('[name=_token]').val(),
                                widget_promokod_id: widget_callback_id,
                                widget_id: widget_id,
                            }

                        $.jGrowl('Данные успешно добаылены в очередь для добавления', {
                            header: 'Успешно!',
                            theme: 'bg-success'
                        });

                            $('#modal_add_bot_url_1').modal('hide');
                            $.ajax({
                                type: "POST",
                                url: '/WidgetsCatcherBotsController/getmetrika',
                                data: datatosend,
                                success: function (html1) {
window.location.reload();
                                }
                            })











                    }
                    if (tip == 4) {

                        widget_id = $('#widget_id').val();
                        widget_callback_id = $('#widget_callback_id').val();

                        datatosend = {
                            tips: tip,
                            textix: $('#modal_add_bot_url_1_text').val(),
                            _token: $('[name=_token]').val(),
                            widget_promokod_id: widget_callback_id,
                            widget_id: widget_id,
                        }

                        $.jGrowl('Данные успешно добаылены в очередь для добавления', {
                            header: 'Успешно!',
                            theme: 'bg-success'
                        });

                        $('#modal_add_bot_url_1').modal('hide');
                        $.ajax({
                            type: "POST",
                            url: '/WidgetsCatcherBotsController/createstek',
                            data: datatosend,
                            success: function (html1) {
                                window.location.reload();
                            }
                        })











                    }
                }

                function add_url(tip) {
                    widget_id = $('#widget_id').val();
                    widget_callback_id = $('#widget_callback_id').val();
                    if (tip == 1) {alert($('#modal_add_bot_url_1_text').val());
                        datatosend = {
                            tips: tip,
                            textix: $('#modal_add_bot_url_1_text').val(),
                            _token: $('[name=_token]').val(),
                            widget_promokod_id: widget_callback_id,
                            widget_id: widget_id,
                        }

                        $('#modal_add_bot_url_1').modal('hide');
                        $.ajax({
                            type: "POST",
                            url: '/WidgetsCatcherBotsController/addurl',
                            data: datatosend,
                            success: function (html1) {

                                $.jGrowl('Данные успешно добаылены в очередь для добавления', {
                                    header: 'Успешно!',
                                    theme: 'bg-success'
                                });

                            }
                        })


                    }


                }


            </script>
@endsection
