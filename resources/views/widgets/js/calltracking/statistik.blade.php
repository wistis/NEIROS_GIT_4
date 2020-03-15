<script type="text/javascript" src="//cdn.bootcss.com/echarts/4.0.4/echarts.min.js"></script><script type="text/javascript" src="/default/assets/js/plugins/ui/moment/moment.min.js"></script><script type="text/javascript" src="/default/assets/js/plugins/pickers/daterangepicker.js"></script>

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
            url: '/stat/start_date',
            data: datatosend,
            success: function (html1) {


                start_load_data();
            }
        })


    }


    $('.daterange-ranges').daterangepicker(
        {
            startDate: moment().subtract(29, 'days'),
            endDate: moment(),
            minDate: '01/01/2018',
            /* maxDate: '12/31/2016',*/
            dateLimit: {days: 60},
            ranges: {
                'Сегодня': [moment(), moment()],
                'Вчера': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'за 7 дней': [moment().subtract(6, 'days'), moment()],
                'За 30 дней': [moment().subtract(29, 'days'), moment()],
                'Этот месяц': [moment().startOf('month'), moment().endOf('month')],
                'Прошлый месяц': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'За все время': [moment().subtract(2, 'month').startOf('month'), moment().subtract(0, 'month').endOf('month')],
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

    $('.daterange-ranges span').html('<?=date("d-m-Y", strtotime($stat_start_date))?> - <?=date("d-m-Y", strtotime($stat_end_date))?>');

</script>
{{--<div id="main" style="height:400px"></div>--}}


{{--
<script type="text/javascript" src="/default/assets/js/plugins/visualization/echarts/echarts.js"></script>--}}
<script type="text/javascript">

    start_load_data();

    function start_load_data() {


        var fruit = [];

        if ($('#checkbox1').is(':checked')) {
            fruit.push(1);
        }
        if ($('#checkbox2').is(':checked')) {
            fruit.push(2);
        }

        datatosend = {

            _token: $('[name=_token]').val(),
            fruit: fruit

        }
        $.ajax({
            type: "POST",
            url: '/stat/other_ajax',
            data: datatosend,
            success: function (html1) {
                res = JSON.parse(html1);
                $('#mchart_week0').html(res['chart']);
                $('#mchart_week1').html(res['chart_week']);
                $('#mchart_week2').html(res['chart_all']);
                $('#mchart_week3').html(res['chart_region']);


            }, error: function () {
                $('#mchart_week0').html('');
                $('#mchart_week1').html('');
                $('#mchart_week2').html('');
                $('#mchart_week3').html('');
                mynotif('Ошибка','Что-то пошло не та','error')
            }
        })


    }

</script>


