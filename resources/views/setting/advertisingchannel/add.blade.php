@extends('app')
@section('title')
    Рекламные каналы
@endsection
@section('content')
    <div class="row">
        <div class="page-title col-md-6" style="padding: 10px">
            <h1><a href="/setting/advertisingchannel"><i class="icon-arrow-left52 position-left"></i></a><span class="text-semibold">{{$title}} </span></h1>

        </div><div class="col-md-6"></div>



    </div>



    <!-- Fieldset legend -->
    <div class="row">

        <!-- /fieldset legend -->


        <!-- 2 columns form -->
        <form class="form-horizontal" action="/setting/advertisingchannel" method="post">
            <input name="_token" type="hidden" value="{{ csrf_token() }}" />

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h2 class="panel-title">Добавить поле</h2>


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
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">UTM:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="utm" id="utm"    >
                                        <input type="hidden" class="form-control" name="id" id="id"  value="0"   >
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
