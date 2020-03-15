@extends('app')
@section('title')
    Шаблоны писем

@endsection
@section('content')

    <div class="row">
        <div class="page-title col-md-6" style="padding: 10px">
            <h1><a href="/setting/admintm"><i class="icon-arrow-left52 position-left"></i></a><span class="text-semibold">   Шаблоны писем </span></h1>

        </div><div class="col-md-6"></div>



    </div>


    <!-- Fieldset legend -->
    <div class="row">

        <!-- /fieldset legend -->


        <!-- 2 columns form -->
        <form class="form-horizontal" action="/setting/admintm" method="post">
            <input name="_token" type="hidden" value="{{ csrf_token() }}" />

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h3 class="panel-title">Создание шаблона</h3>
                    <input name="projectId" type="hidden"  id="stageId" value="{{$id}}" />
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Название:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="name" id="name"   required value="{{$name}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">За сколько дней до окончания периода(числа через запятую):</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="period" id="period"   required value="{{$period}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Время рассылки:</label>
                                    <div class="col-lg-9">
                                       <select name="time">
                                           @for($i=0;$i<24;$i++)
                                               <option value="{{$i}}"@if($time==$i) selected @endif>{{$i}}</option>
                                           @endfor
                                       </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Шаблон:</label>
                                    <div class="col-lg-9">
                                        <div>Маски</div>
                                        <div>|period| - выводит в письме количество дней до окончания вместе со словом день</div>
                                        <div>|date| - выводит в письме Дату окончания тестового периода</div>
                                        <div>|user| - выводит в письме Имя пользователя</div>
                                        <textarea name="editor-full" id="editor-full" rows="4" cols="4">{!! $text !!}</textarea>

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
        @section('skriptdop')
            <script type="text/javascript" src="/default/ckeditor/ckeditor.js"></script>
            <script>
                CKEDITOR.replace( 'editor-full', {
                    height: '400px',

                });
            </script>
@endsection