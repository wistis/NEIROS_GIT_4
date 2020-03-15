@extends('app')
@section('title')
    Добавить платежный профиль

@endsection
@section('content')
    <style>
        .coltrack{
            display: none;
        }

    </style>
    <div class="breadcrumb-line breadcrumb-line-component" style="margin-bottom: 10px"><a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
        <ul class="breadcrumb">
            <li><a href="/"><i class="icon-home2 position-left"></i> Главная</a></li>
            <li><a href="/setting/sites">Компании</a>  </li>

        </ul>


    </div>



    <!-- Fieldset legend -->
    <div class="row">

        <!-- /fieldset legend -->


        <!-- 2 columns form -->
        <form class="form-horizontal" action="/setting/paycompanys" method="POST" id="myform">
            <input name="_token" type="hidden" value="{{ csrf_token() }}" />

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title">Редактировать компанию</h5>
                    <input name="id" type="hidden"  id="id" value="{{$id}}" />
                </div>

                <div class="panel-body">

                    <div class="tabbable">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#basic-tab1" data-toggle="tab">Основное</a></li>


                        </ul>
                        <div class="tab-content">



                            <div class="row tab-pane active"   id="basic-tab1">
                                <div class="col-md-12">
                                    <fieldset>


                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Короткое название:</label>
                                            <div class="col-lg-9">
                                                <input type="text" class="form-control" name="short_name" value="{{$short_name}}"  required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Полное название:</label>
                                            <div class="col-lg-9">
                                                <input type="text" class="form-control" name="full_name" value="{{$full_name}}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">ИНН:</label>
                                            <div class="col-lg-9">
                                                <input type="text" class="form-control" name="inn" value="{{$inn}}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">КПП:</label>
                                            <div class="col-lg-9">
                                                <input type="text" class="form-control" name="kpp" value="{{$kpp}}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">ОГРН:</label>
                                            <div class="col-lg-9">
                                                <input type="text" class="form-control" name="ogrn" value="{{$ogrn}}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Телефон:</label>
                                            <div class="col-lg-9">
                                                <input type="text" class="form-control" name="phone" value="{{$phone}}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">E-mail:</label>
                                            <div class="col-lg-9">
                                                <input type="text" class="form-control" name="email" value="{{$email}}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Контактное лицо:</label>
                                            <div class="col-lg-9">
                                                <input type="text" class="form-control" name="fio" value="{{$fio}}"  >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Юридический адрес:</label>
                                            <div class="col-lg-9">
                                                <input type="text" class="form-control" name="ur_adres" value="{{$ur_adres}}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Почтовый адрес:</label>
                                            <div class="col-lg-9">
                                                <input type="text" class="form-control" name="post_adres" value="{{$post_adres}}" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">БИК Банка:</label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" name="bik" id="bik" value="{{$bik}}" required>
                                            </div>
                                            <div class="col-lg-3">
                                                <button class="btn btn-info" onclick="provbik();return false" type="button">Проверить</button>
                                            </div>
                                        </div>
                                        <div class="form-group frombic">

                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Рассчетный счет:</label>
                                            <div class="col-lg-9">
                                                <input type="text" class="form-control" name="rs" value="{{$rs}}" required>
                                            </div>
                                        </div>
                                        <input type="hidden" class="form-control" name="bank_info" id="bank_info" value="{{json_encode($bank_info)}}">














                                    </fieldset>
                                </div>
                                {{--Дополнительные поля--}}

                            </div>






                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Сохранить<i class="icon-arrow-right14 position-right"></i></button>
                        </div>
                    </div>
                </div>
        </form>

        <script>
            function  provbik(){
                bic=$('#bik').val();
                $.get( "https://bik-info.ru/api.html?type=json&bik="+bic, function( data ) {
                    res=data;


                    $( ".frombic" ).html(`
                  Кор.с: `+res['ks']+`<br>
                  Название: `+res['name']+` `  );

                });

            }
        </script>
@endsection
