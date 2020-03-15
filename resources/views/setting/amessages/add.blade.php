@extends('app')
@section('title')
    Этапы сделок

@endsection
@section('content')

    <div class="row">
        <div class="page-title col-md-6" style="padding: 10px">
            <h1><a href="/setting/stages"><i class="icon-arrow-left52 position-left"></i></a><span class="text-semibold">Создание рассылки  </span></h1>

        </div><div class="col-md-6"></div>



    </div>


    <!-- Fieldset legend -->
    <div class="row">

        <!-- /fieldset legend -->


        <!-- 2 columns form -->
        <form class="form-horizontal" action="/setting/messages" method="post">
            <input name="_token" type="hidden" value="{{ csrf_token() }}" />

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h3 class="panel-title">Создание рассылки</h3>
                    <input name="projectId" type="hidden"  id="stageId" value="0" />
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <fieldset>
                                 <div class="form-group">
                                    <label class="col-lg-3 control-label">Тема:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="tema" id="tema"   required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Сообщение:</label>
                                    <div class="col-lg-9">
                                        <textarea class="form-control" name="message" id="message"></textarea>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Пользователи:</label>
                                    <div class="col-lg-9">
                                        <div class="col-md-6"><input type="checkbox" name="users[]" value="0">Всем пользователям</div>
                                       @foreach($users as $user)
                                            <div class="col-md-6">  <input type="checkbox" name="users[]" value="{{$user->id}}">{{$user->name}}</div>

                                       @endforeach

                                    </div>
                                </div>





                            </fieldset>
                        </div>
{{--Дополнительные поля--}}

                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary ">Создать<i class="icon-arrow-right14 position-right"></i></button>
                    </div>
                </div>
            </div>
        </form>

@endsection
