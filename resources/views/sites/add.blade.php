@extends('app')
@section('title')
    Виджеты

@endsection
@section('content')
    <style>
        .coltrack{
            display: none;
        }

    </style>




    <!-- Fieldset legend -->
    <div class="row">



        <div class="panel panel-white">

@if(auth()->user()->sms_code>0)

                @if(session()->has('message'))

                    <div style="color: red;text-align: center">Неверный код подтверждения</div>
                @endif

                <form class="stepy-basic" action="/setting/sites/create" method="post">
                    <fieldset title="1" style="margin-bottom: 50px">
                        <legend class="text-semibold">Подтвердите номер телефона</legend>

                        <div class="row">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}" />


                            <div class="col-md-12 mt-15">


                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Код из sms:</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="sms_code" id="name"   required>
                                    </div>
                                </div>
                            </div>






                        </div>



                        <center> <button type="submit" class="btn btn-primary  " style="margin-top: 15px">Подтвердить <i class="icon-check position-right"></i></button></center>

                    </fieldset>








                </form>


@else
            <form class="stepy-basic" action="/">
                <fieldset title="1">
                    <legend class="text-semibold">Данные проекта</legend>

                    <div class="row">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                        <input name="site_id" type="hidden"  id="site_id" value="0" />

<div class="col-md-12 mt-15">


    <div class="form-group">
        <label class="col-lg-3 control-label">Название проекта:</label>
        <div class="col-lg-6">
            <input type="text" class="form-control" name="name" id="name"   required>
        </div>
    </div>
    </div>


    <div class="col-md-12 mt-15">                         <div class="form-group">
                                <label class="col-lg-3 control-label">Протокол сайта:</label>
                                <div class="col-lg-6">
                                    <select class="form-control" id="protokol"  name="protokol">
                                        <option value="http">http</option>
                                        <option value="https">https</option>


                                    </select>
                                </div>
                            </div>
                            </div>

        <div class="col-md-12 mt-15">              <div class="form-group">
                                <label class="col-lg-3 control-label">Сайт:</label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" name="url" id="url"   required>
                                </div>
                            </div>
                            </div>

                    </div>





                </fieldset>

                <fieldset title="2" class="secondd">
                    <legend class="text-semibold">Ваш код</legend>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
<textarea class="form-control" style="height: 400px" name="hash" id="hash"></textarea>

                            </div>
                        </div>


                    </div>


                </fieldset>





                <button type="submit" class="btn btn-primary stepy-finish">Сохранить <i class="icon-check position-right"></i></button>
            </form>

    @endif
        </div>


















@endsection
        @section('skriptdop')
            <script type="text/javascript" src="/default/assets/js/plugins/forms/wizards/stepy.min.js"></script>
            <script type="text/javascript" src="/default/assets/js/pages/wizard_stepy.js"></script>
        <script>
            $(document).on('click','.button-next',function (e) {
              name=$('#name').val();
              protokol=$('#protokol').val();
              url=$('#url').val();
                site_id=$('#site_id').val();
             err=0;
             mess='';
             if(name==''){
                 err=1;
                 mess='Заполните название проекта';
              }
                if(url==''){
                    err=1;
                    mess='Заполните адрес сайта';
                }

                if(err==1){
                //    $('.stepy-basic').stepy('destroy');

                    mynotif('Ошибка',mess,'error')
                    //$('.stepy-basic').stepy('step',1);

                }

                if (err==0){

                    datatosend = {
                        name: name,
                        protokol: protokol,
                        url: url,
                        site_id: site_id,
                        _token: $('[name=_token]').val(),


                    }


                    $.ajax({
                        type: "POST",
                        url: '/createsite',
                        data: datatosend,
                        success: function (html1) {
res=JSON.parse(html1);
                            $('#site_id').val(res['id']);
                            $('#hash').val(res['hash']);


                        }
                    })

                }
return false;
            } );

        </script>




        @endsection
