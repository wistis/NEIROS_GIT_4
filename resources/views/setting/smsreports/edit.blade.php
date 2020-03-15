@extends('app')
@section('title')
    Добавление смс отчета

@endsection
@section('content')
    <div class="row">
        <div class="page-title col-md-6" style="padding: 10px">
            <h1><a href="/setting/projectfield"><i class="icon-arrow-left52 position-left"></i></a><span class="text-semibold">Добавление смс отчета </span></h1>

        </div><div class="col-md-6"></div>



    </div>



    <!-- Fieldset legend -->
    <div class="row">

        <!-- /fieldset legend -->


        <!-- 2 columns form -->
        <form class="form-horizontal" action="/setting/smsreports/{{$sms->id}}" method="post">
            <input type="hidden" name="_method" value="PUT">    <input name="_token" type="hidden" value="{{ csrf_token() }}" />

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h2 class="panel-title">Редактировать смс отчет</h2>
                    <input name="id" type="hidden"  id="id" value="{{$sms->id}}" />

                </div>

                <div class="panel-body">
                    <div class="row">@if(session()->has('error'))
                            <div class="alert alert-danger">{{session()->get('error')}}</div>
                        @endif
                        <div class="col-md-6">
                            <fieldset>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Переодичность смс:</label>
                                    <div class="col-lg-9">
                                        <select data-placeholder="Выберите тип поля" class="form-control repeat_sms" name="repeat_sms" id="repeat_sms">

                                            @foreach($repeat_sms as $key=>$val)

                                                <option value="{{$key}}" @if($sms->repeat_sms==$key) selected @endif  >{{$val}}</option>

                                            @endforeach


                                        </select>
                                    </div>
                                </div>
                                <div class="form-group week" style="display: none">
                                    <label class="col-lg-3 control-label">День недели смс:</label>
                                    <div class="col-lg-9">
                                        <select data-placeholder="День недели смс" class="form-control" name="day_send"  >

                                            @foreach(\App\Models\Reports\SmsReport::DAY_SAND as $key=>$val)

                                                <option value="{{$key}}" @if($sms->day_send==$key) selected @endif  >{{$val}}</option>

                                            @endforeach


                                        </select>
                                    </div>
                                </div>
                                <div class="form-group  "  >
                                    <label class="col-lg-3 control-label">Время смс:</label>
                                    <div class="col-lg-9">
                                        <select data-placeholder="Время смс" class="form-control" name="time"  >



                                            <option value="06:00:00" @if($sms->time=='06:00:00') selected @endif  >06:00</option>
                                            <option value="07:00:00"  @if($sms->time=='07:00:00') selected @endif  >07:00</option>
                                            <option value="08:00:00" @if($sms->time=='08:00:00') selected @endif   >08:00</option>
                                            <option value="09:00:00"  @if($sms->time=='09:00:00') selected @endif  >09:00</option>
                                            <option value="10:00:00" @if($sms->time=='10:00:00') selected @endif   >10:00</option>
                                            <option value="11:00:00" @if($sms->time=='11:00:00') selected @endif   >11:00</option>
                                            <option value="12:00:00" @if($sms->time=='12:00:00') selected @endif   >12:00</option>
                                            <option value="13:00:00"  @if($sms->time=='13:00:00') selected @endif  >13:00</option>
                                            <option value="14:00:00" @if($sms->time=='14:00:00') selected @endif   >14:00</option>
                                            <option value="15:00:00" @if($sms->time=='15:00:00') selected @endif   >15:00</option>
                                            <option value="16:00:00"@if($sms->time=='16:00:00') selected @endif    >16:00</option>
                                            <option value="17:00:00"  @if($sms->time=='17:00:00') selected @endif  >17:00</option>
                                            <option value="18:00:00" @if($sms->time=='18:00:00') selected @endif   >18:00</option>
                                            <option value="19:00:00" @if($sms->time=='19:00:00') selected @endif   >19:00</option>
                                            <option value="20:00:00" @if($sms->time=='20:00:00') selected @endif   >20:00</option>
                                            <option value="21:00:00" @if($sms->time=='21:00:00') selected @endif    >21:00</option>
                                            <option value="22:00:00" @if($sms->time=='22:00:00') selected @endif   >22:00</option>
                                            <option value="23:00:00" @if($sms->time=='23:00:00') selected @endif   >23:00</option>
                                            <option value="00:00:00" @if($sms->time=='00:00:00') selected @endif   >00:00</option>




                                        </select>
                                    </div>
                                </div>

















                            </fieldset>
                        </div>
                        <div class="col-md-6">
                            <fieldset>







                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Поля:</label>
                                    <div class="col-lg-9">
                                        @foreach($fields as $key=>$val)
                                            <input type="checkbox" name="fields[]"   @if((is_array($sms->fields))&&(in_array($key,$sms->fields))) checked @endif value="{{$key}}">{{$val}}<br>

                                        @endforeach
                                    </div>
                                </div>




                                <div class="form-group  "  >
                                    <label class="col-lg-3 control-label">Сайт:</label>
                                    <div class="col-lg-9">
                                        <select data-placeholder="Выберите сайт" class="form-control " name="site_id"  >

                                            @foreach($sites as $site)

                                                <option value="{{$site->id}}" @if($sms->site_id==$site->id) selected @endif  >{{$site->name}}</option>

                                            @endforeach


                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tselected_fields"  >
                                    <label class="col-lg-3 control-label">Период отчета:</label>
                                    <div class="col-lg-9">
                                        <select data-placeholder="Выберите сайт" class="form-control" name="date_reports"  >

                                            @foreach(\App\Models\Reports\SmsReport::DATE_REPORTS as $key=>$val)

                                                <option value="{{$key}}"  @if($sms->date_reports==$key) selected @endif>{{$val}}</option>

                                            @endforeach


                                        </select>
                                    </div>
                                </div>

                                <div class="form-group tselected_fields"  >
                                    <label class="col-lg-3 control-label">Телефон для уведомления:</label>
                                    <div class="col-lg-9">
                                        <input type="text" value="{{$sms->phone}}" name="phone" class="form-control" required>

                                    </div>
                                </div>








                            </fieldset>
                        </div>
                        {{--Дополнительные поля--}}

                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary ">Сохранить<i class="icon-arrow-right14 position-right"></i></button>
                    </div>
                </div>
            </div>
        </form>
        <script>

            $(document).on('change','#repeat_sms',function () {

                if(($(this).val()=='dayweek')||($(this).val()=='week')){

                    $('.week').show();

                }else{
                    $('.week').hide();

                }




            })

        </script>
@endsection
