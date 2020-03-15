@extends('app')
@section('title')
    Клиенты
@endsection
@section('content')

    <div class="breadcrumb-line breadcrumb-line-component" style="margin-bottom: 10px"><a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
        <ul class="breadcrumb">
            <li><a href="/"><i class="icon-home2 position-left"></i> Главная</a></li>
            <li><a href="/projects"><i class="icon-home2 position-left"></i>Сделки</a></li>

            <li class="active">Добавление </li>
        </ul>
        <input name="_token" type="hidden" value="{{ csrf_token() }}" />

    </div>


        <!-- Fieldset legend -->
        <div class="row">

        <!-- /fieldset legend -->


        <!-- 2 columns form -->
        <form class="form-horizontal" action="#">
            <input name="_token" type="hidden" value="{{ csrf_token() }}" />
            <input name="niddentime_id" type="hidden" value="{{time()}}" />
            <input name="projectId" type="hidden"  id="projectId" value="0" />
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title">Добавление сделки</h5>
                    <div class="heading-elements">
                        <ul class="icons-list">
                            <li><a data-action="collapse"></a></li>
                            <li><a data-action="reload"></a></li>
                            <li><a data-action="close"></a></li>
                        </ul>
                    </div>
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
                                <legend class="text-semibold"><i class="icon-reading position-left"></i> Основная информация</legend>

                                @if($widget_promocod->status==1)<div class="form-group">
                                    <label class="col-lg-3 control-label">Промокод:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="promocod" id="promocod" placeholder="12345"  >
                                    </div>
                                </div>@else
                                    <input type="hidden" class="form-control" name="promocod" id="promocod" placeholder="12345"  >
                                    @endif
                                @if($widget_promocod_off->status==1)   <div class="form-group">
                                    <label class="col-lg-3 control-label">Offline Промокод:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="promocodoff" id="promocodoff" placeholder="12345"  >
                                    </div>
                                </div>@else
                                    <input type="hidden" class="form-control" name="promocodoff" id="promocodoff" placeholder="12345"  >
                                    @endif
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Название:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Проект 1" required>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Этап:</label>
                                    <div class="col-lg-9">
                                        <select data-placeholder="Выберите этап" class="form-control" name="stage" id="stage">

                                            @foreach($stages as $stage)

                                                <option value="{{$stage->id}}" @if($stage->id==1) selected @endif >{{$stage->name}}</option>

                                            @endforeach


                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Ответственный:</label>
                                    <div class="col-lg-9">
                                        <select data-placeholder="Выберите ответственного" class="form-control" name="user" id="user">

                                            @foreach($managers as $manager)

                                                <option value="{{$manager->id}}" @if($manager->id==$user->id) selected @endif >{{$manager->name}}</option>

                                            @endforeach


                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Сумма сделки:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="summ" id="summ" placeholder="10 100">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Теги:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="tags" id="tags" placeholder="Тег 1, Тег 2">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Комментарий:</label>
                                    <div class="col-lg-9">
<textarea name="comment" id="comment"  class="form-control">



</textarea>

                                    </div>
                                </div>


                                <div class="panel panel-flat panel-collapsed">
                                    <div class="panel-heading">
                                        <h6 class="panel-title">Доп поля сделок</h6>
                                        <div class="heading-elements">
                                            <ul class="icons-list">
                                                <li><a data-action="collapse"></a></li>

                                            </ul>
                                        </div>
                                    </div>

                                    <div class="panel-body">
                                        <div class="tabbable">
                                            {!! $project_field !!}


                                        </div>
                                    </div>
                                </div>

                            </fieldset>
                        </div>

                        <div class="col-md-6">
                            <fieldset>
                                <legend class="text-semibold"><i class="icon-user position-left"></i> Клиент</legend>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Клиент (ФИО) :</label>
                                    <div class="col-lg-9">


                                        <input type="text" class="form-control" name="fio" id="fio" placeholder="Иванов Иван Иванович">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">E-mail:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="email" id="email" placeholder="user@example.com">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Телефон:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="phone" id="phone" placeholder="+7(999) 99-99-999">

                                    </div>
                                </div>
                                <div class="panel panel-flat panel-collapsed">
                                    <div class="panel-heading">
                                        <h6 class="panel-title">Доп поля контактов</h6>
                                        <div class="heading-elements">
                                            <ul class="icons-list">
                                                <li><a data-action="collapse"></a></li>

                                            </ul>
                                        </div>
                                    </div>

                                    <div class="panel-body">
                                        <div class="tabbable">
                                            {!! $client_field !!}


                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Компания:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="company" id="company" placeholder="ООО Рога и копыта">

                                    </div>
                                </div>

                                <div class="panel panel-flat panel-collapsed">
                                    <div class="panel-heading">
                                        <h6 class="panel-title">Доп поля компаний</h6>
                                        <div class="heading-elements">
                                            <ul class="icons-list">
                                                <li><a data-action="collapse"></a></li>

                                            </ul>
                                        </div>
                                    </div>

                                    <div class="panel-body">
                                        <div class="tabbable">
                                            {!! $company_field !!}


                                        </div>
                                    </div>
                                </div>







                            </fieldset>
                        </div>
                    </div>

















{{--вкладка 2--}}


























                    </div>{{--конец табов--}}
                    <div class="text-right">


                        <button type="submit" class="btn btn-primary project_add">Создать<i class="icon-arrow-right14 position-right"></i></button>
                    </div>



                </div>
                </div>
            </div>
        </form>

@endsection
