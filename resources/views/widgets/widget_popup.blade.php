@extends('app')
@section('title')
    Виджеты

@endsection
@section('newjs')
    <script type="text/javascript" src="/default/assets/js/plugins/forms/styling/switchery.min.js"></script>
    <script type="text/javascript" src="/default/assets/js/plugins/forms/styling/switch.min.js"></script>
    <script type="text/javascript" src="/js/jscolor.js"></script>

    <link rel="stylesheet" type="text/css" href="/vendor/formeo/demo/assets/css/new.css">
@endsection
@section('content')
    @include('modal.formview')
    @include('modal.settingpopupform')
    @inject('FormBuildnerController','App\Http\Controllers\FormBuildnerController')
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
                            <li class="active"><a href="#basic-tab1" data-toggle="tab">Основное</a></li>
                            <li><a href="#basic-tab2" data-toggle="tab">Попапы</a></li>


                        </ul>
                        <div class="tab-content">

                            <div class="row tab-pane active" id="basic-tab1">
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
                                            <label class="col-lg-3 control-label">Создавать сделку автоматом:</label>
                                            <div class="col-lg-9">
                                                <div class="checkbox checkbox-switchery">
                                                    <label>
                                                        <input type="checkbox" class="switchery" id="create_project"
                                                               name="create_project"
                                                               @if($widget_osn->create_project==1) checked="checked"
                                                               @endif  data-id="{{$widget->id}}">

                                                    </label>
                                                </div>
                                            </div>
                                        </div>


                                    </fieldset>
                                </div>
                                {{--Дополнительные поля--}}

                            </div>
                            <div class="row tab-pane " id="basic-tab2">
                                <div class="col-md-12">
                                    <fieldset>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Добавить:</label>
                                            <a href="/widget/create_new_form/{{$widget_osn->id}}"
                                               class="btn btn-success">Добавить</a>
                                        </div>
                                        <table class="table table-bordered">
                                            <tr>

                                            <td>№</td>
                                            <td>Название</td>
                                            <td>Показы</td>
                                            <td>Заявки</td>
                                            <td>Отказы</td>
                                            <td>Ред.</td>


                                            <th>Настройки</th>
                                            <th>Предосмотр</th>
                                            <th>Удалить</th>
                                            <th>A/B</th>


                                            </tr>

                                            @foreach($widgets_popup_templates as $popup_template)



                                                <tr id="formtrid{{$popup_template->id}}">
                                                    <td>{{$popup_template->id}}</td>
                                                    <td>{{$popup_template->name}}</td>
                                                    <td>{{$popup_template->fshow}}</td>
                                                    <td>{{$popup_template->forder}}</td>
                                                    <td>{{$popup_template->fcloze}}</td>

                                                    <td>
                                                        <a href="/widget/create_new_form/{{$widget_osn->id}}/{{$popup_template->id}}"><i
                                                                    class="icon-pencil"></i></a></td>
                                                    <td><a href="#"
                                                           onclick="settingpopupform({{$popup_template->id}});return false;"><i
                                                                    class="icon-cog3"></i></a></td>
                                                    <td><a href="#"
                                                           onclick="show_view({{$popup_template->id}});return false;"><i
                                                                    class="icon-eye"></i></a></td>
                                                    <td><a href="#"
                                                           onclick="deleteform({{$popup_template->id}});return false;"><i
                                                                    class="icon-trash"></i></a></td>
                                                    <td id="ab{{$popup_template->id}}" >
                                                        @if($popup_template->is_ab==0)

                                                        @if($popup_template->parent_id==0)<a href="#"
                                                           onclick="createab({{$popup_template->id}});return false;"><i
                                                                    class="icon-play"></i></a>
                                                            @endif
                                                            @endif



                                                    </td>


                                                </tr>

                                                @foreach($FormBuildnerController->get_parent_form($popup_template->id) as $parent_form)
                                                    <tr id="formtrid{{$parent_form->id}}">
                                                        <td></td>
                                                        <td>{{$parent_form->name}}</td>
                                                        <td>{{$parent_form->fshow}}</td>
                                                        <td>{{$parent_form->forder}}</td>
                                                        <td>{{$parent_form->fcloze}}</td>

                                                        <td>
                                                            <a href="/widget/create_new_form/{{$widget_osn->id}}/{{$parent_form->id}}"><i
                                                                        class="icon-pencil"></i></a></td>
                                                        <td><a href="#"
                                                               onclick="settingpopupform({{$parent_form->id}});return false;"><i
                                                                        class="icon-cog3"></i></a></td>
                                                        <td><a href="#"
                                                               onclick="show_view({{$parent_form->id}});return false;"><i
                                                                        class="icon-eye"></i></a></td>
                                                        <td><a href="#"
                                                               onclick="deleteform({{$parent_form->id}});return false;"><i
                                                                        class="icon-trash"></i></a></td>
                                                        <td id="ab{{$parent_form->id}}" >

                                                            {{$parent_form->parent_id}}


                                                        </td>


                                                    </tr>

                                      @endforeach

                                            @endforeach
                                        </table>


                                    </fieldset>
                                </div>

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
                $('.edit_widget').click(function () {
                    widget_id = $('#widget_id').val();
                    widget_callback_id = $('#widget_callback_id').val();
                    if ($('#status').prop('checked')) {
                        status = 1;
                    } else {
                        status = 0;
                    }
                    if ($('#create_project').prop('checked')) {
                        create_project = 1;
                    } else {
                        create_project = 0;
                    }


                    datatosend = {
                        widget_id: widget_id,
                        widget_callback_id: widget_callback_id,
                        status: status,
                        create_project: create_project,
                        email: $('#email').val(),
                        phone: $('#phone').val(),
                        logo: $('#logo').val(),
                        first_message: $('#first_message').val(),
                        operator_name: $('#operator_name').val(),
                        timer: $('#timer').val(),


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

                function show_view(id) {

                    $.ajax({
                        type: "POST",
                        url: '/widget/doform/view',
                        data: "id=" + id,
                        success: function (html1) {
                            $('#formviewhtml').html(html1);
                            $('#formview').modal('show');

                        }
                    })
                }

                function settingpopupform(id) {
                    $.ajax({
                        type: "POST",
                        url: '/widget/doform/settingpopupform',
                        data: "id=" + id,
                        success: function (html1) {
                            $('#settingpopupformhtml').html(html1);
                            $('#settingpopupform').modal('show');

                        }
                    })
                }
                function createab(id) {
                    $.ajax({
                        type: "POST",
                        url: '/widget/doform/createab',
                        data: "id=" + id,
                        success: function (html1) {
                            window.location.href='/widget/create_new_form/{{$widget_osn->id}}/'+html1;

                        }
                    })
                }

                function settingpopupformsafe() {
                    myform = $('#settingpopupformhtml').serialize();
                    $.ajax({
                        type: "POST",
                        url: '/widget/doform/settingpopupformsafe',
                        data: myform,
                        success: function (html1) {
                            // $('#settingpopupformhtml').html(html1);
                            $('#settingpopupform').modal('hide');
                            $('#settingpopupform').modal('hide');

                        }
                    })

                }


                function deleteform(id) {
                    $.ajax({
                        type: "POST",
                        url: '/widget/doform/deleteform',
                        data: "id=" + id,
                        success: function (html1) {
                            $('#formtrid' + id).remove();


                        }
                    })
                }
            </script>
@endsection
