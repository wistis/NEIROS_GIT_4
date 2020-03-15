@extends('app')
@section('title')
    Контакты

@endsection
@section('content')



    <!-- Fieldset legend -->
    <div class="row">

        <!-- /fieldset legend -->


        <!-- 2 columns form -->
        <form class="form-horizontal" action="#" method="post">
            <input name="_token" type="hidden" value="{{ csrf_token() }}" />
            <input name="projectId" type="hidden"  id="contactId" value="0" />
            <input name="company_id" type="hidden"  id="company_id" value="0" />
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title">Создание контакта</h5>

                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">ФИО:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="fio" id="fio"   required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">E-mail:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="email" id="email"   required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Телефон:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="phone" id="phone"   required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Компания:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="company" id="company"   required>
                                    </div>
                                </div>

                                <div class="row">{!!  $client_field !!}</div>





                            </fieldset>
                        </div>
                        {{--Дополнительные поля--}}
                        <div class="col-md-6">
                            <fieldset>


                            </fieldset>
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="button" class="btn btn-primary edit_contact">Создать<i class="icon-arrow-right14 position-right"></i></button>
                    </div>
                </div>
            </div>
        </form>

@endsection
