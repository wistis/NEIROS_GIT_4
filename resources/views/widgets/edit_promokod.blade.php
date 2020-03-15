@extends('app')
@section('title')
    {{$title}}

@endsection
@section('newjs')
    <script type="text/javascript" src="/default/assets/js/plugins/forms/styling/switchery.min.js"></script>
    <script type="text/javascript" src="/default/assets/js/plugins/forms/styling/switch.min.js"></script>
    <script type="text/javascript" src="/js/jscolor.js"></script>

@endsection
@section('content')
    <div class="page-title" style="padding: 10px">
        <h1><span class="text-semibold">@yield('title')</span>

            <input type="checkbox" class="switchery" id="status"
                   name="status" @if($widget->status==1) checked="checked"
                   @endif  data-id="{{$widget->id}}">

        </h1>
    </div>
    <div class="row" style="margin-bottom: 10px"><a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
        <ul class="nav nav-tabs"style="margin-bottom: 0px">
            <li class="active"><a href="#basic-tab1" data-toggle="tab">Основное</a></li>

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
                    <input name="widget_promokod_id" type="hidden"  id="widget_promokod_id" value="{{$widget_promokod->id}}" />
                </div>


                <div class="panel-body">

                    <div class="tabbable">

                        <div class="tab-content">

                            <div class="row tab-pane active"   id="basic-tab1">
                                <h2 class="panel-title">Основное</h2>
                                <div class="col-md-6">
                                    <fieldset>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Статус виджета:</label>
                                            <div class="col-lg-9">
                                                <div class="checkbox checkbox-switchery">
                                                    <label>
                                                        <input type="checkbox" class="switchery"  id="status" name="status" @if($widget->status==1) checked="checked" @endif  data-id="{{$widget->id}}">

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





                        </div>
                        <div class="text-right">
                            <button type="button" class="btn btn-primary edit_widget">Сохранить<i class="icon-arrow-right14 position-right"></i></button>
                        </div>
                    </div>
                </div>
        </form>





@endsection
@section('skriptdop')
            <script>
                $('.edit_widget').click(function () {
                    widget_id = $('#widget_id').val();
                    widget_promokod_id = $('#widget_promokod_id').val();
                    if($('#status').prop('checked')) {
                        status=1;
                    } else {
                        status=0;
                    }
                    datatosend = {
                        widget_id: widget_id,
                        widget_promokod_id: widget_promokod_id,
                        status:status,
                        color: $('#color').val(),
                        background: $('#background').val(),
                        position_y: $('#position_y').val(),
                        position_x: $('#position_x').val(),

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



            </script>
@endsection
