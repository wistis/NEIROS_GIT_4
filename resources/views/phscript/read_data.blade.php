@extends('phscript.app')
@section('title')
    {{$title}}
@endsection
@section('newjs')
    <script type="text/javascript" src="/default/assets/js/plugins/forms/styling/switchery.min.js"></script>
    <script type="text/javascript" src="/default/assets/js/plugins/forms/styling/switch.min.js"></script>
    <script type="text/javascript" src="/js/jscolor.js"></script>

@endsection
@section('content')
    @include('phscript.modal_open_info')
<style>


    .well {

        min-height: 20px;
        padding: 19px;
        margin-bottom: 20px;
        background-color: #f5f5f5;
        border: 1px solid #e3e3e3;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05);

    }
</style>

    <div class="panel panel-white">
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
            <div class="col-md-1"><a href="#"  class="btn btn-success">XLS</a> </div>
        </div>


    </div>
    <div class="page-title1 row" style="padding: 10px">
        <h1><div class="col-md-3"><span class="text-semibold">{{$title}}</span></div>


        </h1>
    </div>

    <div class=" " style=" "><a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>

    </div>

    <div class="panel panel-flat">
        <div class="panel-heading">


        </div>


        <div class="panel-body">

            <div class="tabbable">

                <div class="tab-content">
                <table class="table table-bordered">
<tr>
    <td>Дата</td>
    <td>Оператор</td>
    <td>Время</td>
    <td>%</td>
@foreach($project_fields as $project_field)
        <td>{{$project_field->name}}</td>
    @endforeach
    <td>Инфо</td>
</tr>
<tbody id="loaddata">
@foreach($logs as $log)
    <tr>
    <td>{{date('H:i:s d-m-Y',strtotime($log->created_at))}}</td>
    <td>Оператор</td>
    <td>{{$log->timer}} сек</td>
    <td>{{$log->progress}}%</td>
        @foreach($project_fields as $project_field)

            <td>
                @if(isset($otvfld[$log->id][$project_field->id]))
                {{$otvfld[$log->id][$project_field->id]}}
                @endif

            </td>
        @endforeach
    <td><i class="fa fa-info btn btn-info" onclick="open_info({{$log->id}})"></i> </td></tr>
@endforeach
</tbody>




                </table>
                </div>
            </div>
        </div>

        @endsection

        @section('skriptdop')
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
                     url: '/stat/phscript/ajax/dataload',
                     data:data,
                     success: function (html1) {
                         $('#loaddata').html(html1);

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
                         $('.open_info').html(html1);

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
