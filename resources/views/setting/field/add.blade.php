@extends('app')
@section('title')
    Дополнительные поля

@endsection
@section('content')
    <div class="row">
        <div class="page-title col-md-6" style="padding: 10px">
            <h1><a href="/setting/projectfield"><i class="icon-arrow-left52 position-left"></i></a><span class="text-semibold">{{$title}} </span></h1>

        </div><div class="col-md-6"></div>



    </div>



    <!-- Fieldset legend -->
    <div class="row">

        <!-- /fieldset legend -->


        <!-- 2 columns form -->
        <form class="form-horizontal" action="#" method="post">
            <input name="_token" type="hidden" value="{{ csrf_token() }}" />

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h2 class="panel-title">Добавить поле</h2>
                    <input name="projectId" type="hidden"  id="stageId" value="0" />
                    <input name="tipfields" type="hidden"  id="tipfields" value="{{$tipfields}}" />
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Название поля:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="name" id="name"   required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Тип поля:</label>
                                    <div class="col-lg-9">
                                        <select data-placeholder="Выберите тип поля" class="form-control" name="tip_fields" id="tip_fields">

                                            @foreach($tip_fields as $tip_field)

                                                <option value="{{$tip_field->id}}"   >{{$tip_field->name}}</option>

                                            @endforeach


                                        </select>
                                    </div>
                                </div>



                                <div class="form-group tselected_fields" style="display: none">
                                    <label class="col-lg-3 control-label">Введите значения:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control tokenfield" id="vields_values" value="">
                                    </div>
                                </div>










                            </fieldset>
                        </div>
{{--Дополнительные поля--}}

                    </div>

                    <div class="text-right">
                        <button type="button" class="btn btn-primary edit_field">Создать<i class="icon-arrow-right14 position-right"></i></button>
                    </div>
                </div>
            </div>
        </form>

@endsection
