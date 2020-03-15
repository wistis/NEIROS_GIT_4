@extends('app')
@section('title')

{{$title}}
@endsection
@section('newjs')
    <script type="text/javascript" src="/default/assets/js/plugins/forms/styling/switchery.min.js"></script>
    <script type="text/javascript" src="/default/assets/js/plugins/forms/styling/switch.min.js"></script>
    <script type="text/javascript" src="/js/jscolor.js"></script>

@endsection
@section('content')

    <div class="row"> <div class="page-title col-md-2" style="padding: 10px">
            <h1><span class="text-semibold">{{$title}}</span>  </h1>

        </div>



    </div>
    <div class=" row"  >
        <ul class="nav nav-tabs"style="margin-bottom: 0px">
            <li class="active"><a href="#basic-tab1" data-toggle="tab">API Ya.Metrika</a></li>
            <li  ><a href="#basic-tab2" data-toggle="tab">API Ya.Direct</a></li>


        </ul>

    </div>



    <!-- Fieldset legend -->
    <div class="row">

        <!-- /fieldset legend -->


        <!-- 2 columns form -->
        <form class="form-horizontal" action="#" method="post">
            <input name="_token" type="hidden" value="{{ csrf_token() }}" />

            <div class="panel panel-flat">
                <div class="panel-heading">

                    <input name="widget_id" type="hidden"  id="widget_id" value="{{$widget->id}}" />

                </div>


                <div class="panel-body">

                    <div class="tabbable">

                        <div class="tab-content">

                            <div class="row tab-pane active"   id="basic-tab1">
                                <h2 class="panel-title">API Ya.Metrika</h2>
                                {!! $metrika !!}

                                {{--Дополнительные поля--}}

                            </div>
                            <div class="row tab-pane  "   id="basic-tab2">
                                <h2 class="panel-title">API Ya.DIRECT</h2>
                                    {!! $direct !!}

                                {{--Дополнительные поля--}}

                            </div>




                        </div>

                    </div>
                </div>
        </form>





        @endsection
        @section('skriptdop')

@endsection
