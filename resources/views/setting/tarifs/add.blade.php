@extends('app')
@section('title')
    Рекламные каналы
@endsection
@section('content')
    <div class="row">
        <div class="page-title col-md-6" style="padding: 10px">
            <h1><a href="/setting/tarifs"><i class="icon-arrow-left52 position-left"></i></a><span class="text-semibold">{{$title}} </span></h1>

        </div><div class="col-md-6"></div>



    </div>



    <!-- Fieldset legend -->
    <div class="row">

        <!-- /fieldset legend -->


        <!-- 2 columns form -->
        <form class="form-horizontal" action="/setting/tarifs" method="post">
            <input name="_token" type="hidden" value="{{ csrf_token() }}" />

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h2 class="panel-title">Добавить тариф</h2>


                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Название:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="name" id="name"   required>
                                    </div>
                                </div>
                                {{--`id`, `name`, `month`, `year`, `moduls`, `phone`, `minuta`, `created_at`, `updated_at`--}}
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Цена в месяц:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="month" id="month"    >
                                        <input type="hidden" class="form-control" name="id" id="id"  value="0"   >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Цена в год:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="year" id="year"    >

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Цена за номер:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="phone" id="phone"    >

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Цена за минуту:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="minuta" id="minuta"    >

                                    </div>
                                </div>



                            </fieldset>
                        </div>
{{--Дополнительные поля--}}

                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Создать<i class="icon-arrow-right14 position-right"></i></button>
                    </div>
                </div>
            </div>
        </form>

@endsection
