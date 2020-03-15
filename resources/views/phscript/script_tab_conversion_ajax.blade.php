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

</div>   <script src="/vendor/jsplumb/tinymce/js/tinymce/tinymce.min.js"></script>
<script src="/vendor/jsplumb/tinymceinit.js"></script>
<script src="/vendor/jsplumb/jsplumb.js"></script>
<script src="/vendor/jsplumb/script_stat.js"></script>
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







        @endif
        @endif

        @endforeach



        // jsPlumb.setId(, "mmmk");

        console.log(mydb);

    });






</script>