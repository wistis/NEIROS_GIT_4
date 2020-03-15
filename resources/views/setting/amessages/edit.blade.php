@extends('app')
@section('title')
    Этапы сделок

@endsection
@section('content')

    <div class="row">
        <div class="page-title col-md-6" style="padding: 10px">
            <h1><a href="/setting/messages"><i class="icon-arrow-left52 position-left"></i></a><span class="text-semibold">Чтение сообщения  </span></h1>

        </div><div class="col-md-6"></div>



    </div>

    <!-- Fieldset legend -->
    <div class="row">

        <!-- /fieldset legend -->


        <!-- 2 columns form -->
        <form class="form-horizontal" action="#" method="post">
            <input name="_token" type="hidden" value="{{ csrf_token() }}" />

            <div class="panel panel-flat">

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <fieldset>
                                <div class="form-group">
                                   <h3>{{$mess->tema}}</h3>
                                </div>
                                <div class="form-group">
                                    {!! $mess->message !!}
                                </div>











                            </fieldset>
                        </div>
                        {{--Дополнительные поля--}}

                    </div>


                </div>
            </div>
        </form>

@endsection
