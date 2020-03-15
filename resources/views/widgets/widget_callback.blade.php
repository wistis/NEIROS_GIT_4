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
                    <input name="widget_callback_id" type="hidden"  id="widget_callback_id" value="{{$widget_callback->id}}" />
                </div>


                <div class="panel-body">

                    <div class="tabbable">

                        <div class="tab-content">

                            <div class="row tab-pane active"   id="basic-tab1">
                                <h2 class="panel-title">Основное</h2>      <div class="col-md-6">
                                    <fieldset>
                                         

                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">E-mail для уведомлений:</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="email" id="email"  value="{{$widget->email}}"  required>

                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Теги:</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="tags" id="tags"  value="{{$tags}}" >

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
                    widget_callback_id = $('#widget_callback_id').val();
                    if($('#status').prop('checked')) {
                        status=1;
                    } else {
                        status=0;
                    }
                    datatosend = {
                        widget_id: widget_id,
                        widget_promokod_id: widget_callback_id,
                        status:status,
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

                var elems = document.querySelectorAll('.switchery');

                for (var i = 0; i < elems.length; i++) {
                    var switchery = new Switchery(elems[i],{ size: 'small' });
                }

            </script>
@endsection
