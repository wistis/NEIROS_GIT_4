


    @inject('ProjectController','\App\Http\Controllers\ProjectController')
    <input name="_token" type="hidden" value="{{ csrf_token() }}" />

    <!-- Basic sorting -->
      

    <div class="row row-sortable">

        <table class="table tasks-list table-lg">
            <thead>
            <tr>
                <th>#</th>
                <th>Имя</th>
                <th>От </th>
                <th>Куда</th>
                <th>Тема</th>
                <th>Сделка</th>
                <th>Дата</th>
                <th>Канал</th>
             </tr>
            </thead>
            <tbody>
            @foreach($projects as $project)
               <tr   id="del{{$project->id}}">
                    <td><a href="#" onclick="open_email({{$project->id}});return false;"> 101{{$user->my_company_id}}{{$project->id}}</a> </td>
                    <td> {{$project->from_name}}</td>
                    <td>{{$project->from}}  </td>
                    <td>{{$project->to}} </td>
                    <td>{{$project->subject}} </td>
                    <td><a href="/projects/edit/{{$project->project_id}}" target="_blank"> 101{{$user->my_company_id}}{{$project->project_id}}</a></td>
                    <td>{{date('H:i d.m.Y',strtotime($project->created_at))}}</td>
                    <td>@if(isset($canalstat[$project->canal])){{$canalstat[$project->canal]}}@endif</td>
                   </tr>
            @endforeach
            </tbody>
        </table>




        {!! $projects->links() !!}
    </div>
    <!-- /basic sorting -->





   


@section('skript_callstat')
    <script>
        function setdate(start,end) {
            start_date = start;
            end_date =end;


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

                    $.jGrowl('Изменения успешно сохранены', {
                        header: 'Успешно!',
                        theme: 'bg-success'
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
                dateLimit: { days: 60 },
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
            function(start, end) {
                $('.daterange-ranges span').html(start.format('D-MM-Y') + ' - ' + end.format('D-MM-Y'));
                setdate(start.format('Y-MM-D'),end.format('Y-MM-D'));
            }
        );

        $('.daterange-ranges span').html('<?=date("d-m-Y",strtotime($start_date))?> - <?=date("d-m-Y",strtotime($end_date))?>' );


        function open_email(id) {
            datatosend = {
                id:id,

                _token: $('[name=_token]').val(),


            }


            $.ajax({
                type: "POST",
                url: '/projects/get_email_modal',
                data: datatosend,
                success: function (html1) {
                    res=JSON.parse(html1);
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
