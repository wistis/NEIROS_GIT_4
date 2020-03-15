@extends('app')
@section('title')
    Клиенты
@endsection
@section('content')
    @inject('ProjectController','\App\Http\Controllers\ProjectController')
    <script type="text/javascript" src="/default/assets/js/plugins/ui/moment/moment.min.js"></script> <div class="row">
     <script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
<script src="/global_assets/js/demo_pages/datatables_basic.js"></script>

    

    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>

    <!-- Basic sorting -->

    <div class="panel panel-flat" style="background:none; box-shadow: none;">


    <div class="panel-body">

 
                <div class="row" id="basic-tab0" style="background:#FFFFFF;     margin-top: 20px;">
    <div class="col-md-12">
        <button type="button" class="btn btn-link daterange-ranges heading-btn text-semibold">
            <i class="icon-calendar3 position-left"></i> <span>{{$start_date}}-{{$end_date}}</span> <b class="caret"></b>
        </button>
    </div>
                    <div class="col-md-12">
@include('projects.sdelki')
                    </div>
                </div>
                <div style="margin-top:20px;">
   {!! $projects->links() !!}
   </div>

    </div>
    </div>


    <!-- /basic sorting -->





    @include('modal.modalemail')




@endsection
@section('skriptdop')
    <script>
        function setdate(start, end) {
            start_date = start;
            end_date = end;


            datatosend = {
                start_date: start_date,
                end_date: end_date,


                _token: $('[name=_token]').val(),


            }


            $.ajax({
                type: "POST",
                url: '/projects/start_date',
                data: datatosend,
                success: function (html1) {

                  
                    new PNotify({
                        title: 'Успешно ',
                        text: 'Изменения успешно сохранены',
                        icon: 'icon-success'
                    });
                    window.location.reload();
                }
            })


        }


    </script>
    <script type="text/javascript" src="/default/assets/js/plugins/pickers/daterangepicker.js"></script>
    <script>    // Daterange picker
        // ------------------------------

        $('.daterange-ranges').daterangepicker(
            {
                startDate: moment().subtract(29, 'days'),
                endDate: moment(),
                minDate: '01/01/2018',
                /* maxDate: '12/31/2016',*/
                dateLimit: {days: 60},
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                opens: 'left',
                applyClass: 'btn-small bg-slate-600 btn-block',
                cancelClass: 'btn-small btn-default btn-block',
                format: 'MM/DD/YYYY'
            },
            function (start, end) {
                $('.daterange-ranges span').html(start.format('D-MM-Y') + ' - ' + end.format('D-MM-Y'));
                setdate(start.format('Y-MM-D'), end.format('Y-MM-D'));
            }
        );

        $('.daterange-ranges span').html('<?=date("d-m-Y", strtotime($start_date))?> - <?=date("d-m-Y", strtotime($end_date))?>');


        function open_email(id) {
            datatosend = {
                id: id,

                _token: $('[name=_token]').val(),


            }


            $.ajax({
                type: "POST",
                url: '/projects/get_email_modal',
                data: datatosend,
                success: function (html1) {
                    res = JSON.parse(html1);
                    $('#e_subject').html(res['subject']);
                    $('#e_from').html(res['from']);
                    $('#e_to').html(res['to']);
                    $('#e_message').html(res['message']);

                    $('#myModalEmail').modal('show');

                }
            })
        }
    </script>
@endsection
