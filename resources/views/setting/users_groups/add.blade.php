@extends('app')
@section('title')
    Создание группы

@endsection
@section('content')

    <input name="_token" type="hidden" value="{{ csrf_token() }}" />



    <!-- Fieldset legend -->
    <div class="row">

        <!-- /fieldset legend -->


        <!-- 2 columns form -->
        <form class="form-horizontal" action="/setting/usersgroup" method="post">
            <input name="_token" type="hidden" value="{{ csrf_token() }}" />

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title">Создание группы</h5>

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











                            </fieldset>
                        </div>
{{--Дополнительные поля--}}

                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary  ">Создать<i class="icon-arrow-right14 position-right"></i></button>
                    </div>
                </div>
            </div>
        </form>

@endsection
