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


    <div class="row"> <div class="page-title col-md-2" style="padding: 10px">
            <h1><span class="text-semibold">@yield('title')</span>  </h1>

        </div>
        <div class="col-md-1"><input type="checkbox"  id="status" class="switchery"
                                     name="status" @if($widget->status==1) checked="checked"
                                     @endif  data-id="{{$widget->id}}">
        </div>


    </div>
    <div class=" row"  >
        <ul class="nav nav-tabs"style="margin-bottom: 0px">
            <li class="active"><a href="#basic-tab0" data-toggle="tab">Статистика</a></li>
            <li  ><a href="#basic-tab1" data-toggle="tab">Настройки</a></li>



        </ul>

    </div>

    <!-- Fieldset legend -->
    <div class="row">

        <!-- /fieldset legend -->


        <!-- 2 columns form -->
        <form class="form-horizontal" action="#" method="post">
            <input name="_token" type="hidden" value="{{ csrf_token() }}" />

            <div class="panel panel-flat">
                <div class="panel-heading">

                    <input name="widget_id" type="hidden"  id="widget_id" value="{{$widget->id}}" />
                    <input name="widget_promokod_id" type="hidden"  id="widget_promokod_id" value="{{$widget_vk->id}}" />
                </div>


                <div class="panel-body">

                    <div class="tabbable">

                        <div class="tab-content">
                            <div class="row tab-pane active"   id="basic-tab0">
                                <h2 class="panel-title">Статистика</h2>
                                <div class="col-md-12">
{!! $statistik !!}
                                </div>
                                {{--Дополнительные поля--}}

                            </div>
                            <div class="row tab-pane  "   id="basic-tab1">
                                <h2 class="panel-title">Настройки</h2> <div class="col-md-6">
                                    <fieldset>




                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">E-mail:</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="email" id="email"  value="{{$widget_vk->email}}"  required>

                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Заменять ссылкой(mailto:):</label>
                                            <div class="col-lg-9">
                                                <div class="checkbox checkbox-switchery">
                                                    <label>
                                                        <input type="checkbox" class="switchery"  id="url" name="url" @if($widget_vk->url==1) checked="checked" @endif  data-id="{{$widget->id}}">

                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Class или ID:</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="element" id="element"  value="{{$widget_vk->element}}"  required>

                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Сервер:</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="server" id="server"  value="{{$widget_vk->server}}"  required>

                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Логин:</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="login" id="login"  value="{{$widget_vk->login}}"  required>

                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Пароль:</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="password" id="password"  value="{{$widget_vk->password}}"  required>

                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label" id="connect_email"></label>
                                            <div class="col-md-9">
                                                <button onclick="test_email();return false" class="btn btn-info">Проверить соединение</button>

                                            </div>

                                        </div>










                                    </fieldset>
                                </div>
                                {{--Дополнительные поля--}}
                                <div class="text-right">
                                    <button type="button" class="btn btn-primary edit_widget">Сохранить<i class="icon-arrow-right14 position-right"></i></button>
                                </div>
                            </div>





                        </div>

                    </div>
                </div>
        </form>





        @endsection
        @section('skriptdop')
            <script>

                function test_email(){
                    datatosend = {

                        email: $('#email').val(),
                        server1: $('#server').val(),
                        login: $('#login').val(),
                        password: $('#password').val(),

                        _token: $('[name=_token]').val(),



                    }



                    $.ajax({
                        type: "POST",
                        url: '/widget/imap_test',
                        data: datatosend,
                        success: function (html1) {
                            if(html1==1){
                                $.jGrowl('Соединение установлено', {
                                    header: 'Успешно!',
                                    theme: 'bg-success'
                                });

                            }else{
                                $.jGrowl('Чтото пошло не так', {
                                    header: 'Ошибка!',
                                    theme: 'bg-danger'
                                });
                            }


                        }
                    })


                    return false;



                }

                $('.edit_widget').click(function () {
                    widget_id = $('#widget_id').val();
                    widget_promokod_id = $('#widget_promokod_id').val();
                    if($('#status').prop('checked')) {
                        status=1;
                    } else {
                        status=0;
                    }
                    if($('#url').prop('checked')) {
                        url=1;
                    } else {
                        url=0;
                    }
                    datatosend = {
                        widget_id: widget_id,
                        widget_promokod_id: widget_promokod_id,
                        status:status,
                        email: $('#email').val(),
                        server1: $('#server').val(),
                        login: $('#login').val(),
                        password: $('#password').val(),
                        element: $('#element').val(),
                        url: url,



                        _token: $('[name=_token]').val(),



                    }



                    $.ajax({
                        type: "POST",
                        url: '/widget/safe',
                        data: datatosend,
                        success: function (html1) {
                            if(html1==1){
                                $.jGrowl('Изменения успешно сохранены', {
                                    header: 'Успешно!',
                                    theme: 'bg-success'
                                });

                            }else{
                                $.jGrowl('Чтото пошло не так', {
                                    header: 'Ошибка!',
                                    theme: 'bg-danger'
                                });
                            }


                        }
                    })


                    return false;
                });
                var elems = document.querySelectorAll('.switchery');

                for (var i = 0; i < elems.length; i++) {
                    var switchery = new Switchery(elems[i],{ size: 'small' });
                }


            </script>
@endsection
