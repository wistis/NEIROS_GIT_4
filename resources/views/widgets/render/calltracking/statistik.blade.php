<div class="row tab-pane active" id="basic-tab6">

    <div class="col-md-12">
        <div class="breadcrumb-line breadcrumb-line-component" style="margin-bottom: 10px"><a
                    class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>

            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
            <input name="zss" id="zss" type="hidden" value=""/>
        </div>
        <div class="panel panel-white">
            <div class="panel-heading">
                <h6 class="panel-title">Статистика Колбека</h6>
                <div class="heading-elements">
                    <div class="row" style="margin: 15px;float: left">

                        <div class="checkbox-inline checkbox-switchery checkbox-right switchery-xs col-md-2"
                             style="width:200px">
                            <label>
                                <input type="checkbox" class="switchery" checked id="checkbox1"
                                       onclick="start_load_data()">Колбэк

                            </label>
                        </div>
                        {{----}}
                        <div class="checkbox-inline checkbox-switchery checkbox-right switchery-xs col-md-2"
                             style="width:200px">
                            <label>
                                <input type="checkbox" class="switchery" checked id="checkbox2"
                                       onclick="start_load_data()">Коллтрекинг

                            </label>
                        </div>
                    </div>
                    <button type="button" class="btn btn-link daterange-ranges heading-btn text-semibold">
                        <i class="icon-calendar3 position-left"></i> <span>{{$stat_start_date}}
                            -{{$stat_end_date}}</span> <b class="caret"></b>
                    </button>

                </div>
            </div>
            @inject('stat','\App\Http\Controllers\CallStaticController')

        </div>
        <div class="row">
            <div class="col-md-6">
                <div id="mchart_week0">{{--{!! $chart !!}--}}</div>
            </div>
            <div class="col-md-6">
                <div id="mchart_week1">Загрузка данных... .</div>
            </div>
            <div class="col-md-6">
                <div id="mchart_week2">Загрузка данных... .</div>
            </div>
            <div class="col-md-6">
                <div id="mchart_week3">Загрузка данных... .</div>
            </div>


        </div>
    </div>
    {{--Дополнительные поля--}}

</div>