@extends('app')
@section('title')
    Контакты

@endsection
@section('content')


    <div class="breadcrumb-line breadcrumb-line-component" style="margin-bottom: 10px"><a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>



    </div>

    <!-- Fieldset legend -->
    <div class="row">

        <!-- /fieldset legend -->
@if(session()->has('success'))
    <div class="alert alert-info">Контроллер создан</div>
@endif

        <!-- 2 columns form -->
        <form class="form-horizontal" action="/wistis/0" method="post">
            <input name="_token" type="hidden" value="{{ csrf_token() }}" />


            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title">Создание Контролера</h5>

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
                        <button type="submit" class="btn btn-primary edit_contact">Создать<i class="icon-arrow-right14 position-right"></i></button>
                    </div>
                </div>
            </div>
        </form>

@endsection
