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
    @include('modal.add_operator')
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
        <form class="form-horizontal" action="#" method="post" id="myform">
            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title">Редактирование виджета "Чат"</h5>
                    <input name="widget_id" type="hidden" id="widget_id" value="{{$widget->id}}"/>
                    <input name="id" type="hidden" id="id" value="{{$widget_vk->id}}"/>
                </div>


                <div class="panel-body">

                    <div class="tabbable">
                        <ul class="nav nav-tabs">

                            <li class="active"><a href="#basic-tab0" data-toggle="tab">Основное</a></li>
                            <li><a href="#basic-tab1" data-mytab="active_chat" data-toggle="tab"
                                   @if($widget_vk->active_chat==0) style="display:none;" @endif >Чат</a></li>
                            <li><a href="#basic-tab2" data-mytab="active_callback" data-toggle="tab"
                                   @if($widget_vk->active_callback==0) style="display:none;" @endif >Обратный звонок</a>
                            </li>
                            <li><a href="#basic-tab3" data-mytab="active_formback" data-toggle="tab"
                                   @if($widget_vk->active_callback==0) style="display:none;" @endif >Написать нам</a>
                            </li>
                            <li><a href="#basic-tab4" data-mytab="active_map" data-toggle="tab"
                                   @if($widget_vk->active_map==0) style="display:none;" @endif >Карты</a>
                            </li>
                            <li><a href="#basic-tab5" data-mytab="active_social" data-toggle="tab"
                                   @if($widget_vk->active_social==0) style="display:none;" @endif >Соц сети</a>
                            </li>

                        </ul>
                        <script>
                            function show_tab(id) {

                                if ($('#' + id).prop('checked')) {
                                    valu = 1;
                                    $('[data-mytab=' + id + ']').show();
                                } else {
                                    valu = 0;
                                    $('[data-mytab=' + id + ']').hide();
                                }


                            }
                        </script>
                        <div class="tab-content">
                            {{--ALTER TABLE `widgets_chat` ADD `active_chat` INT NULL DEFAULT '0' AFTER `job`, ADD `active_callback` INT NULL DEFAULT '0' AFTER `active_chat`, ADD `active_formback` INT NULL DEFAULT '0' AFTER `active_callback`, ADD `active_map` INT NULL DEFAULT '0' AFTER `active_formback`, ADD `active_social` INT NULL DEFAULT '0' AFTER `active_map`;--}}
                            <div class="row tab-pane active mb-20" id="basic-tab0">
                                @include('widgets.wchat.osn')
                            </div>

                            <div class="row tab-pane  mb-20" id="basic-tab1">
                                @include('widgets.wchat.active_chat')
                            </div>

                            <div class="row tab-pane   mb-20" id="basic-tab2">
                                @include('widgets.wchat.active_callback')
                            </div>
                            <div class="row tab-pane   mb-20" id="basic-tab3">
                                @include('widgets.wchat.active_formback')
                            </div>
                            <div class="row tab-pane   mb-20" id="basic-tab4">
                                @include('widgets.wchat.active_map')
                            </div>
                            <div class="row tab-pane   mb-20" id="basic-tab5">
                                @include('widgets.wchat.active_social')
                            </div>


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
                var switches = Array.prototype.slice.call(document.querySelectorAll('.switchery'));
                switches.forEach(function(html) {
                    var switchery = new Switchery(html, {color: '#4CAF50'});
                });

                function select_tip_redirect(id) {
                    $('#block_0').hide();
                    $('#block_1').hide();
                    $('#block_2').hide();
                    $('#block_' + id).show();


                }

                function edit_operator(id) {
                    datatosend = {
                        id: id
                    }
                    $.ajax({
                        type: "POST",
                        url: '/ajax/get_operator',
                        data: datatosend,
                        success: function (html1) {
                            res = JSON.parse(html1);
                            $('#url_modal').val(res['url']);
                            $('#operator_name_modal').val(res['operator_name']);
                            $('#job_modal').val(res['job']);
                            $('#id_modal').val(res['id']);
                            $('#first_message_modal').val(res['first_message']);
                            $('#logo_modal').val(res['logo']);
                            $('#timer_modal').val(res['timer']);
                            $('.ajax-reply_modal').html('<img src="/user_upload/{{Auth::user()->my_company_id}}/' + res['logo'] + '" style="height: 100px">');
                            $('#add_operator_modal').modal('show');


                        }
                    })
                }

                $('.edit_widget').click(function () {


valur=$('#myform').serialize();


                    $.ajax({
                        type: "POST",
                        url: '/ajax/wchat_save',
                        data: valur,
                        success: function (html1) {

                            $.jGrowl('Изменения успешно сохранены', {
                                header: 'Успешно!',
                                theme: 'bg-success'
                            });

                        }
                    })


                    return false;
                });
                var files; // переменная. будет содержать данные файлов

                // заполняем переменную данными, при изменении значения поля file
                $('input[type=file]').on('change', function () {
                    files = this.files;
                });
                $('.upload_files').on('click', function (event) {

                    event.stopPropagation(); // остановка всех текущих JS событий
                    event.preventDefault();  // остановка дефолтного события для текущего элемента - клик для <a> тега

                    // ничего не делаем если files пустой
                    if (typeof files == 'undefined') return;

                    // создадим объект данных формы
                    var data = new FormData();

                    // заполняем объект данных файлами в подходящем для отправки формате
                    $.each(files, function (key, value) {

                        data.append(key, value);
                    });

                    // добавим переменную для идентификации запроса
                    data.append('my_file_upload', 1);

                    // AJAX запрос
                    $.ajax({
                        url: '/ajax/uploadfilechatavatar',
                        type: 'POST', // важно!
                        data: data,
                        cache: false,
                        dataType: 'json',
                        // отключаем обработку передаваемых данных, пусть передаются как есть
                        processData: false,
                        // отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
                        contentType: false,
                        // функция успешного ответа сервера
                        success: function (result) {


                            // ОК - файлы загружены
                            if (result['status'] == 1) {
                                $('.ajax-reply').html('<img src="/user_upload/{{Auth::user()->my_company_id}}/' + result['path_file'] + '" style="height: 100px">');
                                $('#logo').val(result['path_file']);
                            }
                            // ошибка
                            else {
                                $('.ajax-reply').html(result['path_file']);
                            }
                        },
                        // функция ошибки ответа сервера
                        error: function (jqXHR, status, errorThrown) {
                            console.log('ОШИБКА AJAX запроса: ' + status, jqXHR);
                        }

                    });

                });

                function operator_modal() {
                    $('#add_operator_modal').modal('show');
                    return false;
                }
            </script>
@endsection
