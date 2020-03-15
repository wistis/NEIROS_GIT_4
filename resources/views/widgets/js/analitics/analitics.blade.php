<script type="text/javascript" src="/default/assets/js/plugins/ui/moment/moment.min.js"></script>
<script type="text/javascript" src="//cdn.bootcss.com/echarts/4.0.4/echarts.min.js"></script>
<script src="/js/main.js"></script>

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
            url: '/stat/start_date',
            data: datatosend,
            success: function (html1) {


            //    start_load_data();
            }
        })


    }

    function select_type(type) {
        var fruit = [];

        if ($('#checkbox1').is(':checked')){
            fruit.push(1);
        }
        if ($('#checkbox2').is(':checked')){
            fruit.push(2);
        }
        manageradiorel = $('input[name="checkbox3"]:checked').val();
        datatosend = {
            type:type,
            _token: $('[name=_token]').val(),
            fruit:fruit,
            myradio:  manageradiorel ,
        }
        res=0;
        znak=$('#'+type).html();

        $('.xgk').html('+');
        $('.xxxl').html('');

        if(znak=="+"){
            res=1;
            $('#'+type).html('-');
            $('.'+type+'_sub').html('<tr><td style="font-weight: bold">Загрузка данных ... .</td></tr>');
            $("#zss").val(type);
        }else{res=0;
            $('#'+type).html('+');
            $('.'+type+'_sub').html('');   $("#zss").val('')
        }
        if(res==1){
            $.ajax({
                type: "POST",
                url: '/stat/two_load_data',
                data: datatosend,
                success: function (html1) {

                    res=JSON.parse(html1);
                    $('.'+type+'_sub').html(res['text']);
                    $('#mchart').html(res['chart']);


                    /* $.jGrowl('Данные успешно загружены', {
                         header: 'Успешно!',
                         theme: 'bg-success',
                         life: 300,
                         stiky:true
                     });*/

                }
            });}

    }
    function select_type2(type) {
        var fruit = [];

        if ($('#checkbox1').is(':checked')){
            fruit.push(1);
        }
        if ($('#checkbox2').is(':checked')){
            fruit.push(2);
        }

        datatosend = {
            type:type,
            _token: $('[name=_token]').val(),
            fruit:fruit

        }
        res=0;
        znak=$('#'+type).html();

        $('.xgk2').html('+');
        $('.xxxl2').html('');

        if(znak=="+"){
            res=1;
            $('#'+type).html('-');
            $('.'+type+'_sub2').html('<tr><td style="font-weight: bold">Загрузка данных ... .</td></tr>');
            /*  $("#zss").val(type);*/
        }else{res=0;
            $('#'+type).html('+');
            $('.'+type+'_sub2').html('');   $("#zss").val('')
        }
        if(res==1){
            $.ajax({
                type: "POST",
                url: '/stat/tree_load_data',
                data: datatosend,
                success: function (html1) {

                    res=JSON.parse(html1);
                    $('.'+type+'_sub2').html(res['text']);
                    $('#mchart').html(res['chart']);


                    /*$.jGrowl('Данные успешно загружены', {
                        header: 'Успешно!',
                        theme: 'bg-success',
                        life: 300,
                        stiky:true
                    });*/

                }
            });}

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
            format: 'MM/DD/YYYY',
            locate: 'ru_RU',


        },
        function(start, end) {
            $('.daterange-ranges span').html(start.format('D-MM-Y') + ' - ' + end.format('D-MM-Y'));
            setdate(start.format('Y-MM-D'),end.format('Y-MM-D'));
        }
    );

    $('.daterange-ranges span').html('<?=date("d-m-Y",strtotime($stat_start_date))?> - <?=date("d-m-Y",strtotime($stat_end_date))?>' );

</script>



<script type="text/javascript" src="/default/assets/js/plugins/visualization/echarts/echarts.js"></script>
<script type="text/javascript">
 // start_load_data();
    function start_load_data() {


        var fruit = [];

        if ($('#checkbox1').is(':checked')){
            fruit.push(1);
        }
        if ($('#checkbox2').is(':checked')){
            fruit.push(2);
        }


        manageradiorel = $('input[name="checkbox3"]:checked').val();



        $('#my_table').html('<tr><td style="font-weight: bold">Загрузка данных ... .</td></tr>');
        datatosend = {
            myradio:manageradiorel,
            _token: $('[name=_token]').val(),
            fruit:fruit

        }
        $.ajax({
            type: "POST",
            url: '/stat/start_load_data',
            data: datatosend,
            success: function (html1) {
                res=JSON.parse(html1);
                $('#my_table').html(res['text']);
                $('#mchart').html(res['chart']);
                tr=$('#zss').val();
                if(tr.length>0){


                    $('.'+tr+'_sub').html('<tr><td style="font-weight: bold">Загрузка данных ... .</td></tr>');
                    $("#zss").val(tr);
                    select_type(tr);
                }

                /*   $.jGrowl('Данные успешно загружены', {
                       header: 'Успешно!',
                       theme: 'bg-success',
                       life: 300,
                       stiky:true
                   });*/

            }
        })


    }

 // use configuration item and data specified to show chart

</script>