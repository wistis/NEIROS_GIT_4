
        <div class="panel-heading">
            <h6 class="panel-title">Аренда номеров</h6>
            <div class="row">
                <input type="hidden" id="hidden_start" value="{{$stat_start_date}}">
                <input type="hidden" id="hidden_end" value="{{$stat_end_date}}">
                <div class="col-md-2">Сумма <span id="mysumm">{{$total_summ}}</span> р</div>
                <div class="col-md-4">Период <span><button type="button"
                                                           class="btn btn-link daterange-ranges heading-btn text-semibold">
                        <i class="icon-calendar3 position-left"></i> <span>{{$stat_start_date}}
                                -{{$stat_end_date}}</span> <b class="caret"></b>
                    </button></span></div>
                @if($user->super_admin==1)
                    <div class="col-md-3">
                        <select id="clients">
                            <option value="0">Все клиенты</option>
                            @foreach($clients as $client)
                                <option value="{{$client->my_company_id}}">{{$client->name}}</option>
                            @endforeach
                        </select>

                    </div>@else
                    <input type="hidden" id="clients" value="{{$user->my_company_id}}">


                @endif
                <div class="col-md-3">
                    <button type="button" onclick="generate_p()">Сформировать</button>
                </div>
            </div>
        </div>

        <table class="table tasks-list table-lg">
            <thead>
            <tr>

                <th>Номер</th>
                <th>Дата покупки</th>
                <th>Дата удаления</th>
                <th>Цена в день (р.)</th>
                <th>Цена в в месяц</th>
                <th>Оплачено за месяц</th>
            </tr>
            </thead>
            <tbody id="mytable">
            @if(isset($phones))
            @foreach($phones as $key=>$val)
                <tr>
                    <td>{{$phones[$key]['phone']}}</td>
                    <td>{{date('d-m-Y',strtotime($phones[$key]['created_at']))}}</td>
                    <td>@if($phones[$key]['was_deleted']==1){{date('d-m-Y',strtotime($phones[$key]['updated_at']))}}@endif</td>
                    <td>{{$day}}</td>
                    <td>{{$tarif->phone}}</td>
                    <td>{{$phones[$key]['summ_day']}}</td>


                </tr>
            @endforeach
@endif

            </tbody>
        </table>

    <!-- /task manager table -->

    <!-- /footer -->




    <script type="text/javascript" src="/default/assets/js/plugins/ui/moment/moment.min.js"></script>
    <script type="text/javascript" src="//cdn.bootcss.com/echarts/4.0.4/echarts.min.js"></script>





    <script type="text/javascript" src="/default/assets/js/plugins/pickers/daterangepicker.js"></script>
    <script>    // Daterange picker
        // ------------------------------

        function generate_p() {
            clients = $('#clients').val();
            hidden_start = $('#hidden_start').val();
            hidden_end = $('#hidden_end').val();
            datatosend = {
                clients: clients,
                _token: $('[name=_token]').val(),
                hidden_start: hidden_start,
                hidden_end: hidden_end,

            }
            $.ajax({
                type: "POST",
                url: '/ajax/billingphones',
                data: datatosend,
                success: function (html1) {
                    res = JSON.parse(html1);
                     $('#mytable').html(res['mytable']);
                     $('#mysumm').html(res['mysumm']);

                }
            })

        }

        $('.daterange-ranges').daterangepicker(
            {

                startDate: moment().subtract(29, 'days'),
                endDate: moment(),
                minDate: '01/01/2018',
                /* maxDate: '12/31/2016',*/
               
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
            function (start, end) {
                $('.daterange-ranges span').html(start.format('D-MM-Y') + ' - ' + end.format('D-MM-Y'));
                //  setdate(start.format('Y-MM-D'),end.format('Y-MM-D'));
                $('#hidden_end').val(end.format('DD-MM-Y'));
                $('#hidden_start').val(start.format('DD-MM-Y'));


            }
        );


    </script>







