@extends('app')
@section('title')
    Тех поддержка

@endsection
@section('content')
    <div class="content" style="margin-top: 50px !important;">
        <div class="panel panel-default">
            <div class="panel-body">
                <ul class="nav nav-pills">
                    <li role="presentation" class="active">
                        <a href="https://cloud.neiros.ru/tickets">Открытые Тикеты
                            <span class="badge">{{count($tickets)}}
                                             </span>
                        </a>
                    </li>
                    <li role="presentation" class="">
                        <a href="{{route('wtickets.complete')}}">Завершенные Тикеты
                            <span class="badge">
                        {{count($tickets_compled)}}                    </span>
                        </a>
                    </li>


                </ul>
            </div>
        </div>

        <div class="well bs-component">
            <form method="POST" action="{{route('wtickets.create')}}" accept-charset="UTF-8" class="form-horizontal">
                @csrf
                <legend>Создание Тикета</legend>
                <div class="form-group">
                    <label for="subject" class="col-lg-2 control-label">Тема: </label>
                    <div class="col-lg-10">
                        <input class="form-control" required="required" name="subject" type="text" id="subject">
                        <span class="help-block">Краткое описание</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="content" class="col-lg-2 control-label">Описания: </label>
                    <div class="col-lg-10">
                        <textarea class="form-control summernote-editor" rows="5" required="required" name="content" cols="50" id="content"  ></textarea>
                        <span class="help-block">Описание</span>
                    </div>
                </div>
                <div class="form-inline row">
                    <div class="form-group col-lg-4" style="display: none">
                        <label for="priority" class="col-lg-6 control-label">Приоритет: </label>
                        <div class="col-lg-6">
                            <select class="form-control" required="required" name="priority_id"><option value="1">Важно</option></select>
                        </div>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="category" class="col-lg-6 control-label">Категория: </label>
                        <div class="col-lg-6">
                            <select class="form-control" required="required" name="category_id">
                            @foreach($categories as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                             @endforeach
                            </select>
                        </div>
                    </div>
                    <input name="agent_id" type="hidden" value="auto">
                </div>
                <br>
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        <a href="{{route('wtickets.list')}}" class="btn btn-default">Назад</a>
                        <input class="btn btn-primary" type="submit" value="Отправить">
                    </div>
                </div>
            </form>
        </div>


@endsection
