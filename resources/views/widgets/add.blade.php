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
    <div class="breadcrumb-line breadcrumb-line-component" style="margin-bottom: 10px"><a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
        <ul class="breadcrumb">
            <li><a href="/"><i class="icon-home2 position-left"></i> Главная</a></li>
            <li><a href="/widget">Виджеты</a>  </li>
            <li class="active">Добавление </li>
        </ul>
        <input name="_token" type="hidden" value="{{ csrf_token() }}" />

    </div>



    <!-- Fieldset legend -->
    <div class="row">

        <!-- /fieldset legend -->


        <!-- 2 columns form -->
        <form class="form-horizontal" action="#" method="post" id="myform">
            <input name="_token" type="hidden" value="{{ csrf_token() }}" />

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title">Создание Виджета</h5>
                    <input name="projectId" type="hidden"  id="stageId" value="0" />
                </div>

                <div class="panel-body">

                    <div class="tabbable">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#basic-tab1" data-toggle="tab">Основное</a></li>


                        </ul>
                        <div class="tab-content">



                    <div class="row tab-pane active"   id="basic-tab1">
                        <div class="col-md-6">
                            <fieldset>
                            <div class="form-group">
                                    <label class="col-lg-3 control-label">Название:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="name" id="name"   required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Тип виджета:</label>
                                    <div class="col-lg-9">
                                        <select class="form-control" id="tip"  name="tip" onchange="tipvibor()">
                                            <option value="0">Промокод</option>
                                            <option value="1">Колбэк</option>
                                            <option value="2">Колтрекинг</option>

                                        </select>


                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Протокол сайта:</label>
                                    <div class="col-lg-9">
                                        <select class="form-control" id="protokol"  name="protokol">
                                            <option value="http">http</option>
                                            <option value="https">https</option>


                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Сайт:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="site" id="site"   required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">E-mail:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="email" id="email"   required>
                                    </div>
                                </div>
                                <div class="form-group coltrack">
                                    <label class="col-lg-3 control-label">Куда отправлять звонок:</label>
                                    <div class="col-lg-9">
                                        <select data-placeholder="" class="form-control" name="outputcall" id="outputcall">
                                            <option value="0"   >На сотовый</option>
                                            <option value="1"   >На sip</option>
                                        </select>   </div>
                                </div>
                                <div class="form-group  coltrack">
                                    <label class="col-lg-3 control-label">Телефон:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="phone" id="phone"   required>
                                    </div>
                                </div>
                                <div class="form-group coltrack">
                                    <label class="col-lg-3 control-label">Регион номеров:</label>
                                    <div class="col-lg-9">
                                <select data-placeholder="" class="form-control" name="city" id="city">
                                    <option value="0"   >Москва</option>
                                    <option value="1"   >Санкт-Петербург</option>
                                    <option value="2"   >Краснодар</option>
 </select>   </div>
                                </div>
                                <div class="form-group coltrack">
                                    <label class="col-lg-3 control-label">Количество номеров:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="amount_phone" id="amount_phone"   required>
                                    </div>
                                </div>


                                <div class="form-group coltrack">
                                    <label class="col-lg-3 control-label">Название CSS-класса или ID:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="element" id="element"  >
                                    </div>
                                </div>






                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Этап поумолчанию:</label>
                                    <div class="col-lg-9">
                                        <select data-placeholder="Выберите этап" class="form-control" name="stage_id" id="stage_id">
                                            <option value="0"   >Неразобранное</option>
                                            @foreach($stages as $stage)

                                                <option value="{{$stage->id}}" @if($stage->id==1) selected @endif >{{$stage->name}}</option>

                                            @endforeach


                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Теги:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="tags" id="tags"   required>
                                    </div>
                                </div>


                            </fieldset>
                        </div>
{{--Дополнительные поля--}}

                    </div>






                        </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-primary edit_widget">Создать<i class="icon-arrow-right14 position-right"></i></button>
                    </div>
                </div>
            </div>
        </form>

        <script>
function tipvibor() {
    tip=$('#tip').val();
    if(tip==2){
        $('.coltrack').show();
    }else{
        $('.coltrack').hide();
    }
}

</script>
@endsection
