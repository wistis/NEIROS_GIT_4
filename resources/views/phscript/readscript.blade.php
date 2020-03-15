@extends('phscript.app')
@section('title')
    Сделки - редактирование
@endsection
@section('content')
    <link rel="stylesheet" href="/vendor/jsplumb/style.css">
    <style>
        .progressBar {

            width: 100%;
            height: 70px;

            background: #F8F8F8;
            border-top: 1px solid #ccc;
            position: absolute;
            left: 0;
            bottom: 0;
            z-index: 1000;

        }

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

        .stepitem .counter {

            position: absolute;
            top: 4px;
            left: -25px;
            font-size: 14px;
            color: gray;

        }

        .stepitem {

            position: relative;
            margin: 20px;

        }
    </style>

    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-flat">


                <div class="panel-body">
                    <div class="tabbable">

                        <div class="tab-content row">
                            <div id="item0" class="stepitem">
                                <div class="counter">1 &gt;</div>
                                <div class="col-md-12">

                                    <h3 style="color: red"> {{$script[0]['0']->title}}</h3>
                                    {!! $script[0]['0']->text !!}
                                </div>
                                @foreach($script['opened'] as $buts)
                                    <button class="set_state btn btn-default state-button-default"
                                            data-id="{{$buts->sc_id}}" data-state="{{$buts->id}}"
                                            data-step="0">{{$buts->text_label}}</button>
                                @endforeach

                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>


        <div class="col-md-3"></div>
        <!-- /fieldset legend -->


        <!-- 2 columns form -->


    </div>
    <style>.progressBar .progressIndicator {

            position: absolute;
            top: 10px;
            left: 20px;

        }

        .progressBar .progressLineBack {

            width: 200px;
            height: 5px;
            border-radius: 3px;
            background: #BBB;

        }

        .progressBar .progressLineFill {

            width: 0px;
            height: 5px;
            border-radius: 3px;
            background: #696;

        }</style>

    <div class="progressBar">
        <div class="progressIndicator">
            <div>
                <span class="progressPercent">0</span>% готово
            </div>
            <div class="progressLineBack">
                <div class="progressLineFill" style="width: 0%;"></div>
            </div>
        </div>


        <button class="talk_is_over btn btn-primary">Разговор окончен</button>
    </div>

@endsection
@section('skriptdop')

    <script>
      var  time=0;
      var error_otvetik=1;
         setInterval(function() {
            time=time+1;
        }, 1000);
        var mdb;
        var progress;
        var dlog = {};
        var nootvet={}


        from_start = 0;
        get_data({{$ii}});

        function count(obj) {

            var count = 0;

            for (var prs in obj) {

                if (obj.hasOwnProperty(prs)) count++;

            }

            return count;

        }

        function get_data(id) {

            $.ajax({
                type: "POST",
                url: '/stat/phscript_get_data/' + id,
                data: '',
                success: function (html1) {

                    mdb = html1;
                    ;
                }
            })

        }


        $(document).on('click', '.set_state', function (e) {
            id = $(this).attr('data-id');
            step = parseInt($(this).attr('data-step'));
            new_step = step + 1;
$('.talk_is_over').show();

            dlog[step] = {};
            dlog[step]['id'] = id;
            dlog[step]['value'] = id;


            amount_step = count(dlog)
            for (z = new_step; z <= amount_step; z++) {
                $('[data-item-step=' + z + ']').remove();


            }


            datasar = mdb['parent'][id];


            ids = 0;


            var fromStart = new_step;
            var total = fromStart + mdb['dis'][id]['amount'];
            progress = total > 0 ? Math.round(fromStart / total * 1000) / 10 : 0;
            $('.progressPercent').html(progress);
            $('.progressLineFill').css('width', progress + '%');

            if ($('div').is("#item" + mdb['osn'][id]['id'])) {

            }
            else {
                $('.tab-content').append(`<div class="row stepitem" data-item-step="` + new_step + `" id="item` + mdb['osn'][id]['parent_id'] + `"></div>`);
            }


            var buttonhtml = '';
            if (datasar) {
                datasar.forEach(function (item) {
                    buttonhtml = buttonhtml + ` <button class="set_state btn btn-default state-button-default" data-id="` + item['sc_id'] + `" data-state="s` + mdb['osn'][id]['id'] + `" data-step="` + new_step + `">` + item['text_label'] + `</button>`

                });

                buttonhtml = buttonhtml + ` <button class="set_state_false btn btn-default state-button-default" style="border: 1px dashed" data-id="" data-state="` + mdb['osn'][id]['sc_id'] + `" data-step="` + new_step + `" data-blid="`+mdb['osn'][id]['parent_id']+`">Нет нужного ответа</button>`;

                title = mdb['osn'][id]['title'];
                if (title === null) {
                    title = '';
                }
                textik = mdb['osn'][id]['text'];
                if (textik === null) {
                    textik = '';
                }

                $("#item" + mdb['osn'][id]['parent_id']).html(`
<div class="counter">` + (new_step + 1) + ` &gt;</div><div class="col-md-12"> <h3 style="color: red"> ` + title + `</h3>
                             ` + textik + ` </div>
 ` + buttonhtml);
            } else {
                $('.talk_is_over').hide();
                buttonhtml=`<div class="row mt-15 endtalkdiv"><button class="talk_is_over_good btn btn-primary" data-step="`+new_step+`"
 data-hash="`+mdb['osn'][id]['sc_id']+`"
>Разговор окончен</button></div>`;
                title = mdb['osn'][id]['title'];
                if (title === null) {
                    title = '';
                }
                textik = mdb['osn'][id]['text'];
                if (textik === null) {
                    textik = '';
                }


                $("#item" + mdb['osn'][id]['parent_id']).html(`
<div class="counter">` + (new_step + 1) + ` &gt;</div><div class="col-md-12"> <h3 style="color: red"> ` + title + `</h3>
                             ` + textik + ` </div>
 ` + buttonhtml);
            }


            ph_field = mdb['ph_field'];


            for (var key in ph_field) {


                $('[name="' + key + '"').val(ph_field[key]);

                if (ph_field[key] == 1) {
                    $('[name="' + key + '"').attr('checked', true);

                } else {
                    $('[name="' + key + '"').attr('checked', false);
                }


            }


            return false;
        });


        function crates_script() {
            $('#openmodal').modal('hide');
            $.ajax({
                type: "POST",
                url: '/stat/phscript_safe_create',
                data: "name=" + $('#name_project').val(),
                success: function (html1) {

                    window.location.href = '/stat/phscript/' + html1
                }
            })

        }

        function crates_script_modal() {
            $('#openmodal').modal('show');
        }


        $(document).on('keyup', '.js_script_field', function (e) {

            element = $(this);
            value = element.val();
            data_id = element.attr('name');
            $('[name="' + data_id + '"').val(value);
            mdb['ph_field'][data_id] = value;


        });
        $(document).on('change', '.js_script_field_data', function (e) {

            element = $(this);
            value = element.val();
            data_id = element.attr('name');
            $('[name="' + data_id + '"').val(value);
            mdb['ph_field'][data_id] = value;


        });
        $(document).on('change', '.js_script_field_checkbox', function (e) {
            element = $(this);
            data_id = element.attr('name');
            if ($(this).is(":checked")) {

                mdb['ph_field'][data_id] = 1;
                $('[name="' + data_id + '"').attr('checked', true);
            } else {
                mdb['ph_field'][data_id] = 0;

                $('[name="' + data_id + '"').attr('checked', false);


            }

        });

        $(document).on('click','.set_state_false',function (e) {
           /*data-state="s` + mdb['osn'][id]['id'] + `" data-step="` + new_step + `" data-blid="`+mdb['osn'][id]['parent_id']+`"*/



         block=$(this).data('blid');
         state=$(this).data('state');
            nootvet['nootvet']={};
            nootvet['nootvet'][state]="";
            $("#item" +block).append('<div class="row mt-15"> <textarea  class="error_otvet" data-state="'+state+'" placeholder="Введите что сказал клиент"></textarea></div>');
            $(this).hide();

            error_otvetik=2;

        });
      $(document).on('keyup','.error_otvet',function (e) {

          state=$(this).data('state');

          nootvet['nootvet'][state]=$(this).val();
console.log(nootvet)




      });



      $(document).on('click', '.talk_is_over',function () {
          console.log(nootvet);
          data={
              log:dlog,
              field:ph_field,
              project_id:{{$ii}},
              result:error_otvetik,
              time:time,
              nootvet:nootvet,
              step:step,
              progress:progress,





          }

          $.ajax({
              type: "POST",
              url: '/stat/phscript/ajax/save_log',
              data: data,
              success: function (html1) {
                  return html1;
                  alert('ok');
                  ;

              }
          })





      })
$(document).on('click', '.talk_is_over_good',function () {

data={
    log:dlog,
    field:ph_field,
    project_id:{{$ii}},
    result:0,
    time:time,
    nootvet:nootvet,
    step:step,
    progress:progress,




}

    $.ajax({
        type: "POST",
        url: '/stat/phscript/ajax/save_log',
        data: data,
        success: function (html1) {
            return html1;
alert('ok');
             ;

        }
    })





})
        // начать повторы с интервалом 2 сек




    </script>

@endsection