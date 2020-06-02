<script type="text/javascript" src="//cdn.bootcss.com/echarts/4.0.4/echarts.min.js"></script><script type="text/javascript" src="/default/assets/js/plugins/ui/moment/moment.min.js"></script>        <script src="/js/daterangepicker3.js"></script>
  	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />   

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



	
	
   $('.daterange-ranges').daterangepicker({
				 "autoApply": false,
				  "linkedCalendars": true,
				     "alwaysShowCalendars": true,
					   "showDropdowns": true,
					   opens: 'left',

	"startDate": "<?=date("d-m-Y", strtotime($stat_start_date))?>",
	"endDate": "<?=date("d-m-Y", strtotime($stat_end_date))?>",
/*	"maxDate": "21-12-2019",
	"minDate": "01-01-2019",*/

 "locale": {
        "format": "DD-MM-YYYY",
        "separator": " - ",
        "applyLabel": "Применить",
        "cancelLabel": "Отмена",
        "fromLabel": "От",
        "toLabel": "До",
        "customRangeLabel": "Заданый",
        "daysOfWeek": [
            'Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'
        ],
        "monthNames": [
            'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',
            'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'
        ],
		 "firstDay": 1
    }
	

	
}
,
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


