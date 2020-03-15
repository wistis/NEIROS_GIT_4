@extends('app')
@section('title')
    Компании

@endsection
@section('content')


    <div class="breadcrumb-line breadcrumb-line-component" style="margin-bottom: 10px"><a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
        <ul class="breadcrumb">
            <li><a href="/"><i class="icon-home2 position-left"></i> Главная</a></li>
            <li><a href="/company"> Компании</a>  </li>
            <li class="active">Редактирование </li>
        </ul>
        <input name="_token" type="hidden" value="{{ csrf_token() }}" />

    </div>


    <!-- Fieldset legend -->
    <div class="row">

        <!-- /fieldset legend -->


        <!-- 2 columns form -->
        <form class="form-horizontal" action="#" method="post">
            <input name="_token" type="hidden" value="{{ csrf_token() }}" />

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title">Редактирование компании</h5>
                    <input name="projectId" type="hidden"  id="stageId" value="{{$id}}" />
                </div>


                <div class="panel-body">

                    <div class="tabbable">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#basic-tab1" data-toggle="tab">Основное</a></li>
                            <li><a href="#basic-tab2" data-toggle="tab">Контакты</a></li>

                        </ul>
                        <div class="tab-content">

                    <div class="row tab-pane active"   id="basic-tab1">
                        <div class="col-md-6">
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Название:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="name" id="name"  value="{{$name}}"  required>
                                    </div>
                                </div>




{!! $client_field !!}






                            </fieldset>
                        </div>
                        {{--Дополнительные поля--}}

                    </div>
                            <div class="row tab-pane "   id="basic-tab2">
                                <table class="table tasks-list table-lg">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ФИО</th>
                                        <th>Телефон</th>
                                        <th>E-mail</th>

                                        <th><i class="glyphicon glyphicon-pencil"></i></th>
                                        <th><i class="glyphicon  glyphicon-trash" style="color: red"></i></th>


                                    </tr>
                                    </thead>
                                    <tbody class="xcxcxx">
                                    @foreach($clients as $client) <tr   id="del{{$client->id}}">
                                        <td>{{$client->id}}</td>
                                        <td>{{$client->fio}}</td>
                                        <td>{{$client->phone}}</td>
                                        <td>{{$client->email}}</td>


                                        <td>
                                            <a href="/contacts/edit/{{$client->id}}"target="_blank" ><i class="glyphicon glyphicon-pencil"></i></a></td>

                                        <td><a href="#" data-id="{{$client->id}}" data-url="/contacts/del/{{$client->id}}"  class="deletefrom" ><i class="glyphicon  glyphicon-trash" style="color: red"></i></a>
                                        </td>






                                    </tr>
                                    @endforeach

  </tbody>
                                </table>
                                <button type="button" class="btn btn-primary add_ajax_task_modal">Добавить контакт<i class="icon-arrow-right14 position-right"></i></button>

                                @include('modal.add_ajax_client_modal_form')

                            </div>




</div>
                    <div class="text-right">
                        <button type="button" class="btn btn-primary edit_company">Сохранить<i class="icon-arrow-right14 position-right"></i></button>
                    </div>
                </div>
            </div>
        </form>

@endsection
