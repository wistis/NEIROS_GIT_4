@extends('phscript.app')
@section('title')
    Сделки - редактирование
@endsection
@section('content')
    @include('phscript.modal_field')
    <link rel="stylesheet" href="/vendor/jsplumb/style.css">
    <style>
        .condition-positive {
            border-top-width: 3px !important;
            padding-top: 2px;
            border-top-color: #00BA5B !important;
        }

        .condition-negative {
            border-top-width: 3px !important;
            padding-top: 2px;
            border-top-color: red !important;
        }

        .link .panel {
            border-top-width: 4px;
        }

        .link_positive {
            border-top-color: #00BA5B !important;
        }

        .link_normal {
            border-top-color: #ddd !important;
        }

        .link_negative {
            border-top-color: red !important;
        }
        ::before, ::after {

            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;

        }
        элемент {

        }
        .w .js_field, .w .js_static_field {

            display: inline-block;
            border: 1px solid #ddd;
            border-radius: 2px;
            background-color: #EEEEEE;
            padding: 1px 3px;
            color: #2080bb;

        }
        .w .add_step {

            position: absolute;
            left: 15px;
            bottom: 5px;
            width: 16px;
            height: 16px;
            background: #00BA5B url('/glyphicons-halflings.png') no-repeat -407px -95px;
            cursor: pointer;
            border-radius: 4px;
        }

        .red {
            color: red;
        }

        .bgred {
            background: red;

            border-radius: 10px;

            color: white;

            font-size: 12px;

            padding: 3px;
        }

        .green {
            color: green;
        }

        .blue {
            color: blue;
        }

        .pointer {
            cursor: pointer;
        }

        .truedel {
            display: none;
        }

        .aLabel {
            font-size: 16px;

            font-family: Arial;

            position: absolute;

            border: 1px solid black;

            border-radius: 6px;

            background: white;

            opacity: 0.8;

            cursor: move;

            z-index: 81;
        }

        .is_goal {
            background: #FFC;
        }
    </style>


    <div class="breadcrumb-line breadcrumb-line-component" style="margin-bottom: 10px"><a
                class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
        <ul class="breadcrumb">
            <li><a href="/"><i class="icon-home2 position-left"></i> Главная</a></li>
            <li><a href="/projects"><i class="icon-home2 position-left"></i>Сделки</a></li>

            <li class="active">Редактироване</li>
        </ul>
        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>

    </div>

    <!-- Fieldset legend -->
    <div class="row">

        <!-- /fieldset legend -->


        <!-- 2 columns form -->
        <form class="form-horizontal" action="#">
            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>

            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title">Сводка по конверсиям</h5>

                </div>

                <div class="panel-body row">

                    <div class="col-md-9">
                        <div class="panel-heading row ">



                            <div class="col-md-6" style="text-align: right">  <button type="button" class="btn btn-link daterange-ranges heading-btn text-semibold">
                                    <i class="icon-calendar3 position-left"></i> <span>{{$stat_start_date}}-{{$stat_end_date}}</span> <b class="caret"></b>
                                </button>
                                <input type="hidden" id="start_date" value="{{$stat_start_date}}">
                                <input type="hidden" id="end_date" value="{{$stat_end_date}}">

                            </div>
                            <div class="col-md-3"><select id="operators">
                                    <option value="0">Все операторы</option>
                                    @foreach($operators as $operator)
                                        <option value="{{$operator->id}}">{{$operator->name}}</option>
                                    @endforeach
                                </select></div>
                            <div class="col-md-2"><button type="button" class="btn btn-info" onclick="get_datas()">Фильтр</button> </div>

                        </div>

                        <div class="tabbable" style="height: 800px;width: 100%; ;overflow-x: scroll;overflow-y: scroll;">




                        <!-- demo -->
                        <div class="jtk-demo-canvas canvas-wide statemachine-demo jtk-surface jtk-surface-nopan js_desk" style="width: 10000px; height: 10000px;overflow-x: scroll;overflow-x: scroll;position: relative">

                            @foreach($Phscript_datas as $Phscript_data)
                                @if($Phscript_data->tipblock==0)
                                    <div class="w" id="{{$Phscript_data->sc_id}}"
                                         style="left: {{$Phscript_data->x}}px;top: {{$Phscript_data->y}}px">
                                        <div class="row w_text_block">{!! $Phscript_data->text !!}</div>
<div class="row" style="font-weight: bold">
    <span style="color:blue"> {{$data_tables[$Phscript_data->sc_id]['end__not']}}%</span>/<span style="color:red"> {{$data_tables[$Phscript_data->sc_id]['end__not_end']}}%</span> /<span  > {{$data_tables[$Phscript_data->sc_id]['end__not_end_all']}}%</span>

</div>
                                    </div>
                                                @endif

                            @endforeach

                        </div>




                    </div>
                        <script src="/vendor/jsplumb/tinymce/js/tinymce/tinymce.min.js"></script>
                        <script src="/vendor/jsplumb/tinymceinit.js"></script>
                        <script src="/vendor/jsplumb/jsplumb.js"></script>
                        <script src="/vendor/jsplumb/script_stat.js"></script>
                    </div>

                    <div class="col-md-3" style="vertical-align: top"><div class="js_stats_box">
                            <div>
                                <h3>Информация в целом:</h3>
                                <div>Начато звонков: <span class="stat_runs_count">
						<span class="count">{{$amount_call}}</span> звонков (<span class="percent">100</span>%)</span></div>
                                <div class="stat_unexpected_answer_color">Нет нужного ответа: <span class="stat_runs_with_unexpected_answer_count">
						<span class="count">{{$not_otvet}}</span> звонков (<span class="percent">{{$not_otvet_percent}}</span>%)</span></div>
                                <div class="stat_ended_by_client_color">Разговор прерван: <span class="stat_runs_forcefully_interrupted_count">
						<span class="count">{{$call_end}}</span> звонков (<span class="percent">{{$call_end_percent}}</span>%)</span></div>
                                <div class="stat_goal_achieved_color">Успешно завершено: <span class="stat_runs_achieved_goal_count">
						<span class="count">{{$norm_call}}</span> звонков (<span class="percent">{{$norm_call_percent}}</span>%)</span></div>
                            </div>
                            <div style="margin-top: 20px;">
                                Слева вы можете найти информацию о том сколько звонков прервалось на каждом шаге из-за
                                <span class="stat_unexpected_answer_color">отсутствия нужного ответа</span>
                                и по <span class="stat_ended_by_client_color">инициативе клиента</span>
                                , а также процентное отношение проходов по шагу относительно всех проходов по скрипту
                            </div>
                        </div></div>


                </div>
            </div>
    </div>
    </form>

@endsection
@section('skriptdop')







    <script>
        var mydb = {};
        data_array = {}

        instance.batch(function () {
            for (var i = 0; i < windows.length; i++) {
                initNode(windows[i], true);
            }
            // and finally, make a few connections

            @foreach($data_tables as $key=>$val)
                mydb['{{$data_tables[$key]['id']}}'] = {}
            mydb['{{$data_tables[$key]['id']}}']['text'] = `{!! $data_tables[$key]['text'] !!}`;
            mydb['{{$data_tables[$key]['id']}}']['is_goal'] = '{{$data_tables[$key]['is_goal']}}';
            mydb['{{$data_tables[$key]['id']}}']['title'] ='{{$data_tables[$key]['title']}}';;
            mydb['{{$data_tables[$key]['id']}}']['parent_id'] ='{{$data_tables[$key]['parent_id']}}';;
            mydb['{{$data_tables[$key]['id']}}']['tipblock'] ='{{$data_tables[$key]['tipblock']}}';;;
            mydb['{{$data_tables[$key]['id']}}']['xy']={};
            mydb['{{$data_tables[$key]['id']}}']['xy']['left'] ='{{$data_tables[$key]['x']}}';
            mydb['{{$data_tables[$key]['id']}}']['xy']['top'] ='{{$data_tables[$key]['y']}}'
            mydb['{{$data_tables[$key]['id']}}']['ansver_ids'] =[];
            @if(strlen($data_tables[$key]['parent_id'])>2)
                    @if(isset($data_tables[$data_tables[$key]['parent_id']]))
                    {{--"opened" => array:10 [
                        "id" => "opened"
                        "parent_id" => "0"
                        "tip" => "0"
                        "text_label" => null
                        "tip_label" => null
                        "x" => "0"
                        "y" => "0"
                        "text" => "Текст оператора"
                        "title" => "Текст оператора"
                        "is_goal" => "0"
                      ]--}}




                rtu = instance.connect({
                source: "{{$data_tables[$key]['parent_id']}}",
                target: "{{$data_tables[$key]['id']}}",
                type: "basic",

            });
            label = rtu.getOverlay("label");
            $('#' + label._jsPlumb.div.id).html('{{$data_tables[$key]['text_label']}}')


            ansver_id = label._jsPlumb.div.id
            mydb[ansver_id] = {}
            mydb[ansver_id]['text'] = '{{$data_tables[$key]['text_label']}}';
            mydb[ansver_id]['cid'] = ansver_id;
            mydb[ansver_id]['tip'] ={{$data_tables[$key]['tip_label']}};
            mydb[ansver_id]['id'] = rtu.id;
            mydb[ansver_id]['tipblock'] =1;
            mydb[ansver_id]['xy'] =$('#'+ansver_id).position();


            mydb[ansver_id]['parent'] = '{{$data_tables[$key]['parent_id']}}';
            mydb[ansver_id]['parent2'] = '{{$data_tables[$key]['id']}}';
            //     mydb['{{$data_tables[$key]['parent_id']}}']['ansver_ids'] =ansver_id;
            rk = mydb['{{$data_tables[$key]['parent_id']}}']['ansver_ids'];
            rk[rk.length] = ansver_id;
            mydb['{{$data_tables[$key]['parent_id']}}']['ansver_ids'] = rk;
            if( mydb[ansver_id]['tip'] ==1){
                $('#'+ansver_id).addClass('condition-negative');
                $('.linkclass'+ansver_id).addClass('link_negative');
            }
            if( mydb[ansver_id]['tip'] ==2){
                $('#'+ansver_id).addClass('condition-positive');
                $('.linkclass'+ansver_id).addClass('link_positive');
            }
            console.log(mydb);






            @endif
            @endif

            @endforeach



            // jsPlumb.setId(, "mmmk");

            console.log(mydb);

        });






    </script>
    <script type="text/javascript" src="/default/assets/js/plugins/ui/moment/moment.min.js"></script>
    <script type="text/javascript" src="/default/assets/js/plugins/pickers/daterangepicker.js"></script>          <script>

        function get_datas() {

            data={
                start_date:$('#start_date').val(),
                end_date:$('#end_date').val(),

                operators:$('#operators').val(),
                project_id:$('#project_id').val(),

            }

            $.ajax({
                type: "POST",
                url: '/stat/phscript/script_tab_conversion/'+$('#project_id').val(),
                data:data,
                success: function (html1) {
                    $('.tabbable').html(html1);

                    ;

                }
            })

        }


        function open_info(id) {$('.open_info').html('');

            $('#open_info').modal('show');
            $.ajax({
                type: "POST",
                url: '/stat/phscript/ajax/open_info',
                data: {id:id},
                success: function (html1) {
                    $('.tabbable').html(html1);

                    ;

                }
            })



        }
        $('.daterange-ranges').daterangepicker(
            {

                startDate: moment().subtract(29, 'days'),
                endDate: moment(),
                minDate: '01/01/2018',
                /* maxDate: '12/31/2016',*/
                dateLimit: { days: 60 },
                ranges: {
                    'Сегодня': [moment(), moment()],
                    'Вчера': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'за 7 дней': [moment().subtract(6, 'days'), moment()],
                    'За 30 дней': [moment().subtract(29, 'days'), moment()],
                    'Этот месяц': [moment().startOf('month'), moment().endOf('month')],
                    'Прошлый месяц': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'За все время': [moment().subtract(2, 'month').startOf('month'), moment().subtract(0, 'month').endOf('month')],
                },
                opens: 'right',
                applyClass: 'btn-small bg-slate-600 btn-block',
                cancelClass: 'btn-small btn-default btn-block',
                format: 'MM/DD/YYYY',
                locate: 'ru_RU',


            },
            function(start, end) {
                $('.daterange-ranges span').html(start.format('D-MM-Y') + ' - ' + end.format('D-MM-Y'));
                $('#start_date').val(start.format('Y-MM-D'));
                $('#end_date').val(end.format('Y-MM-D'));

                //
                //
                //
                //
                // =//  setdate(start.format('Y-MM-D'),end.format('Y-MM-D'));
            }
        );

        $('.daterange-ranges span').html('<?=date("d-m-Y",strtotime($stat_start_date))?> - <?=date("d-m-Y",strtotime($stat_end_date))?>' );



    </script>

@endsection