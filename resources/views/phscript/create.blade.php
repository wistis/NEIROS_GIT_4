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
                    <h5 class="panel-title">Редактирование сделки</h5>
                    <div class="heading-elements">
                        <ul class="icons-list">
                            <li><a data-action="collapse"></a></li>
                            <li><a data-action="reload"></a></li>
                            <li><a data-action="close"></a></li>
                        </ul>
                    </div>
                </div>

                <div class="panel-body">
                    {{--<script>
                        // timeline - блок с горизонтальным скроллом
                        timeline=$('.w')
                        timeline.onmousedown = () => {
                            let pageX = 0;

                            document.onmousemove = e => {
                                if (pageX !== 0) {
                                    timeline.scrollLeft = timeline.scrollLeft + (pageX - e.pageX);
                                }
                                pageX = e.pageX;
                            };

                            // заканчиваем выполнение событий
                            timeline.onmouseup = () => {
                                document.onmousemove = null;
                                timeline.onmouseup = null;
                            };

                            // отменяем браузерный drag
                            timeline.ondragstart = () => {
                                return false;
                            };
                        };
                    </script>--}}
                    <div class="tabbable" style="height: 800px;width: 1200px ;overflow-x: scroll;overflow-y: scroll;">




                                <!-- demo -->
                                <div class="jtk-demo-canvas canvas-wide statemachine-demo jtk-surface jtk-surface-nopan js_desk" style="width: 10000px; height: 10000px;overflow-x: scroll;overflow-x: scroll;position: relative">

                                    @foreach($Phscript_datas as $Phscript_data)
                                        @if($Phscript_data->tipblock==0)
                                            <div class="w" id="{{$Phscript_data->sc_id}}"
                                                 style="left: {{$Phscript_data->x}}px;top: {{$Phscript_data->y}}px">
                                                <div class="row w_text_block">{!! $Phscript_data->text !!}</div>
                                                <div class="row">
                                                    <div class="add_step_plus col-md-1 green  "><i
                                                                class="fa fa-plus pointer"></i></div>
                                                    <div class="deleteblock col-md-4 red  " action="delete"><i class="fa fa-trash pointer"></i><label class="truedel bgred">Удалить</label></div>
                                                    <div class="ep col-md-4 blue " action="begin"
                                                         style="text-align: right"><i
                                                                class="fa fa-arrow-right pointer"></i></div>
                                                </div>
                                            </div>
                                        @endif

                                    @endforeach

                                </div>







                    </div>


                </div>
            </div>
    </div>
    </form>

@endsection
@section('skriptdop')


    <script src="/vendor/jsplumb/tinymce/js/tinymce/tinymce.min.js"></script>
    <script src="/vendor/jsplumb/tinymceinit.js"></script>
    <script src="/vendor/jsplumb/jsplumb.js"></script>
    <script src="/vendor/jsplumb/script.js"></script>




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
            mydb[ansver_id]['tip'] ='{{$data_tables[$key]['tip_label']}}';
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

        function get_ajax_fields() {


            $('#modal_field').modal('show');
            project_id=$('#project_id').val();


            $.ajax({
                type: "POST",
                url: '/stat/phscript/ajax/get_fields',
                data: '&project_id='+project_id,
                success: function (html1) {

                    $('.allfields').html(html1);

                }
            })



        }
        $(document).on('click','.add_field',function (e) {


            $('#modal_field').modal('hide');
            project_id=$('#project_id').val();

            field_name=$('#field_name').val();
            field_tip=$('#field_tip').val();
            err=0;
            if(field_name==''){
                err=1;
                mess='Заполните название';
            }
            if(field_tip==''){
                err=1;
                mess='Выберите тип поля';
            }

            if(err==1) {
                //    $('.stepy-basic').stepy('destroy');

                mynotif('Ошибка', mess, 'error'); return;
            }
            dataform={
                field_name:field_name,
                field_tip:field_tip,
                project_id:project_id,
            }
            $.ajax({
                type: "POST",
                url: '/stat/phscript/ajax/create_field',
                data:dataform ,
                success: function (html1) {
           //         tinymce.activeEditor.setContent(html1);
                    tinymce.activeEditor.execCommand('mceInsertContent', false, html1);
                    $('.allfields').append(html1);
                    mynotif('Успешнно', 'Поле добавленио в проект', 'info'); return;
                }
            })

        })
        ;
        $(document).on('click','.select_field',function (e) {

            data_id=$(this).data('id');
            data_name=$(this).data('name');
            data_tip=$(this).data('tip');
            field=`<hs class="js_field js_non_editable" data-id="`+data_id+`"  data-tip="`+data_tip+`" data-mce-selected="1" contenteditable="false" style="display: inline-block; border: 1px solid #ddd;

border-radius: 2px;

background-color: #EEEEEE;

padding: 1px 3px;

color: #2080bb;">`+data_name+`</hs>`;
            tinymce.activeEditor.execCommand('mceInsertContent', false, field);

        });

    
    </script>

@endsection