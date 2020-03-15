<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Чат</title>
    <link href="https://cloud.neiros.ru/cdn/v1/callback/css/timepicki.css" rel="stylesheet" type="text/css">
    <link href="https://cloud.neiros.ru/cdn/v1/callback/css/datepicker.min.css" rel="stylesheet" type="text/css">
    <link href="https://cloud.neiros.ru/cdn/v1/callback/css/select2.css" rel="stylesheet" type="text/css">
    <link href="https://cloud.neiros.ru/cdn/v1/callback/css/style.css" rel="stylesheet" type="text/css">
    <link href="https://cloud.neiros.ru/cdn/v1/callback/css/style_call.css" rel="stylesheet" type="text/css">
    <script src="https://cloud.neiros.ru/cdn/v1/callback/js/jquery-2.1.1.js"></script>
    <script src="https://cloud.neiros.ru/cdn/v1/callback/js/jquery.inputmask.js"></script>
    <script src="https://cloud.neiros.ru/cdn/v1/callback/js/jquery.ddslick.min.js"></script>
    <script src="https://cloud.neiros.ru/cdn/v1/callback/js/datepicker.min.js"></script>
    <script src="https://cloud.neiros.ru/cdn/v1/callback/js/timepicki.js"></script>
    <script src="https://cloud.neiros.ru/cdn/v1/callback/js/select2.js"></script>
</head>

<body>
<? 
$mobile = '';
$mobile_animation = '';
$desc_animation = 'neiros__slideLeft';

if(isset($_GET['mobile'])){
	
 if(isset($_GET['type'])){
	if($_GET['type'] == 'phone'){
	$mobile = 'mobile';
	$mobile_animation = 'neiros__slideUp';
	$desc_animation = '';
	}	
	
}	
}



function num2word($num, $words)
{
    $num = $num % 100;
    if ($num > 19) {
        $num = $num % 10;
    }
    switch ($num) {
        case 1: {
            return($words[0]);
        }
        case 2: case 3: case 4: {
        return($words[1]);
    }
        default: {
            return($words[2]);
        }
    }
}

?>



<div id="neiros__panel_widget" class="<? echo $mobile.$desc_animation?>" >


    <? if($mobile == 'mobile'){ ?>
    <div id="neiros__tab_callback" class="neiros__tab ">
        <div class="neiros__callback_container <?=$mobile_animation?>">
			<div class="neiros__callback_container_padding">
            <div class="neiros__callback_h1">Мы перезвоним Вам за {{$widget_chat->callback_timer}} {{num2word($widget_chat->callback_timer, array('секунду', 'секунды', 'секунд'))}}
                </div>

            <input type="text" id="neiros__callback_phone" placeholder="+7 (___) ___-__-__" class="neiros__callback_input neiros__RU" value="">
            <!--    	<select id="neiros__select_country">
            <option value="RU" data-imagesrc="images/country/russia.png" selected></option>
                    <option value="US" data-imagesrc="images/country/united-kingdom.png"></option>
                    </select>-->
            <div id="neiros__select_country"></div>

            <div id="neiros__btn_calcback">жду звонка</div>
            <div id="neiros__countdown">00:00:00</div>
            <div id="neiros__chose_time"><span>Выбрать удобное время</span></div>
            <div class="neiros__chose_closet">Отмена</div>
            <div class="neiros__copiright_new">Виджет заряжен Neiros</div>

            </div>
        </div>
        <div class="neiros__callback_container_another_time" style="display:none;">
        <div class="neiros__callback_container_padding classmms">
            <div class="neiros__callback_h1">Хотите, чтобы мы Вам перезвонили?
                Вы можете выбрать удобное время для
                связи с Вами! </div>

            <div class="neiros__callback_h1" style="display:none;">Сейчас сотрудники не в офисе. Но вы
                можете выбрать время и мы
                перезвоним Вам! </div>

            <input type="text" class="neiros__datepicker" placeholder="Дата" readonly id="neiros__callback_datepicker">
            <div class="neiros__word">в</div>
            <input type="text" class="neiros__timepicker" placeholder="Время"  id="neiros__callback_timepicker">

            <input type="text" id="neiros__callback_phone_another" placeholder="+7 (___) ___-__-__" class="neiros__callback_input neiros__RU" value="" style="margin-top:15px;">
            <div id="neiros__select_country_2"></div>
            <div id="neiros__btn_calcback_another">жду звонка</div>
            <div class="neiros__chose_closet">Отмена</div>
            <div class="neiros__copiright_new">Виджет заряжен Neiros</div>
            </div>
        </div>
        <div class="neiros__copyright">
            <div class="squaredTwo">
                <input type="checkbox" value="None" id="squaredTwo" name="check" checked />
                <label for="squaredTwo"></label>
            </div>
            <div>Согласен на обработку персональных данных</div>
        </div>

    </div>
    <? } else{ ?>
    
    
    <div id="neiros__tab_callback_desc" <?php /*?>class="no-copiright"<?php */?>>

        <div class="neiros__closet-icon-modal"><img  src="https://cloud.neiros.ru/cdn/v1/callback/images/icons/closet-icon-modal-callback.PNG" alt=""></div>

        <div id="neiros__tab_callback_desc_cont" class="" >

            <div id="neiros__callback_chose_time"><span>Выбрать удобное время</span></div>

            <div id="neiros__tab_callback_desc_text">
                Перезвоним бесплатно
                <div>за {{$widget_chat->callback_timer}} {{num2word($widget_chat->callback_timer, array('секунду', 'секунды', 'секунд'))}}!</div>

            </div>
            <div id="neiros__tab_callback_desc_time">
               
                <select id="neiros__tab_callback_day"  >
                    <option></option>
                   @for($i=0;$i<count($dayt);$i++)
                        <option value="{{$dayt[$i]['day']}}"  >{{$dayt[$i]['name']}}</option>

                   @endfor
                </select>
               
              <select id="neiros__tab_callback_time" name="timmm" disabled>
                    <option></option>

                </select>
            </div>
            <div id="neiros__countdown" style="display: none;padding-top: 20px;">{{date('00:i:s', $widget_chat->callback_timer )}}</div>
            <div id="neiros__countdown1" style="display: none;padding-top: 14px;"></div>
            <input type="text" id="neiros__callback_phone" placeholder="+7 (___) ___-__-__" class="neiros__callback_input neiros__RU" value="">
            <div id="neiros__select_country"></div>
            <div id="neiros__btn_calcback_desc" class="neiros__btn_calcback_call1"><span>жду звонка</span></div>

            <div class="neiros__copyright" style="display:none;">
                <div class="squaredTwo">
                    <input type="checkbox" value="None" id="squaredTwo" name="check" checked />
                    <label for="squaredTwo"></label>
                </div>
                <div>Согласен на обработку персональных данных</div>
            </div>
            <div class="neiros__copiright_new">Виджет заряжен Neiros</div>


        </div>

    </div>

    <? } ?>
</div>

<script>
var send=0;
    $('#neiros__tab_callback_day').change( function () {


        sel=$(this).val();
        @for($i=0;$i<count($dayt);$i++)

        if(sel=={{$dayt[$i]['day']}}) {

            $('#neiros__tab_callback_time').attr('disabled',false);

            $('#neiros__tab_callback_time').append('{!!  $dayt[$i]['html']!!}');
            $('#neiros__tab_callback_time').select2({
                placeholder: 'Время',
                minimumResultsForSearch: -1
            });
        }
        @endfor




    });

    $('#neiros__tab_callback_time').select2({
        placeholder: 'Время',
        minimumResultsForSearch: -1
    });
    $('#neiros__tab_callback_day').select2({
        placeholder: 'Дата',
        minimumResultsForSearch: -1
    });
/*	$('#neiros__tab_callback_time').select2({
        placeholder: 'Время',
        minimumResultsForSearch: -1
    });*/
$('#neiros__callback_phone').on('click', function(){
	
	$('#neiros__tab_callback_desc_cont .neiros__copyright').css('display','block');
	
	})

  @if($off==1)
  $('.neiros__callback_container').css('display','none');
$('.neiros__callback_container_another_time').css('display','block');

  $('#neiros__btn_calcback_desc').removeClass('neiros__btn_calcback_call1');
    $('#neiros__btn_calcback_desc').addClass('neiros__btn_calcback_call2');
    $('#neiros__tab_callback_desc_cont').addClass('neiros__btn_calcback_letter');
    $('#neiros__btn_calcback_desc span').html('ok');
    $('#neiros__tab_callback_desc_text').html('Уточните удобное<br>время звонка');
    $('#neiros__callback_chose_time').css('display','none'); 
  @endif

    $('#neiros__callback_chose_time').on('click',function(){
        $('#neiros__btn_calcback_desc').removeClass('neiros__btn_calcback_call1');
        $('#neiros__btn_calcback_desc').addClass('neiros__btn_calcback_call2');
        $('#neiros__tab_callback_desc_cont').addClass('neiros__btn_calcback_letter');
        $('#neiros__btn_calcback_desc span').html('ok');
        $('#neiros__tab_callback_desc_text').html('Уточните удобное<br>время звонка');
		$('#neiros__callback_chose_time').css('display','none');

    })
    $('#neiros__application_select').select2({
        placeholder: 'Выбрать тему обращения',
        minimumResultsForSearch: -1
    });
$('body').on('click','.neiros__btn_calcback_call1,#neiros__btn_calcback',function (use) {


        check = 0;

        phone = $('#neiros__callback_phone').val()

        if(phone.indexOf("_") >= 0 || phone === ''){
            $('#neiros__callback_phone').addClass('errors');
            check = 1;
        }
        else{
            $('#neiros__callback_phone').removeClass('errors');
        }
        if ($('#squaredTwo').is(':checked')) {
            $('.neiros__copyright div').removeClass('errors-text');
        }
        else{
            $('.neiros__copyright div').addClass('errors-text');
            check = 1;}



        if(check === 0){

            $('#neiros__callback_phone').hide();
            $('#neiros__select_country').hide();
            $('#neiros__btn_calcback').hide();
            var fiveMinutes = 60 * 5,
                display = $('#neiros__countdown');
           @if($widget_chat->callback_timer=='')

           startTimer( 15, display);
@else

           startTimer( {{$widget_chat->callback_timer }}, display);
    @endif

            datatosend = {
                phone: $('#neiros__callback_phone').val(),
                widget: {{$widget_chat->id}},
                neiros_visit:'{{$user_hash}}',
                site:'{{$site}}',
                _token: $('[name=_token]').val(),
                promo:  params['promo'],
                tip:  1,



            }


if(send==0) {
 send=1;
    $.ajax({
        type: "POST",
        url: '/api/v1/sendcall',
        data: datatosend,
        success: function (html1) {


        }
    })
}

        }



});






















/*Письмо*/
    $('body').on('click','.neiros__btn_calcback_call2, #neiros__btn_calcback_another',function (use) {


        check = 0;

if($(this).attr('id')=='neiros__btn_calcback_another'){

    phone = $('#neiros__callback_phone_another').val();
    day_z=$('#neiros__callback_datepicker').val();
    time_z= $('#neiros__callback_timepicker').val();

		if( day_z === ''){
            $('#neiros__callback_datepicker').addClass('errors');
            check = 2;
        }
        else{
            $('#neiros__callback_datepicker').removeClass('errors');
        }
		
		if( time_z === ''){
            $('#neiros__callback_timepicker').addClass('errors');
            check = 2;
        }
        else{
            $('#neiros__callback_timepicker').removeClass('errors');
        }
	
}else{

    phone = $('#neiros__callback_phone').val();
    day_z=$('#neiros__tab_callback_day').val();
    time_z= $('#neiros__tab_callback_time').val();
	
	
	if( day_z === ''){
            $('#neiros__tab_callback_day').addClass('errors');
            check = 2;
        }
        else{
            $('#neiros__tab_callback_day').removeClass('errors');
        }
		
		if( time_z === ''){
            $('#neiros__tab_callback_time').addClass('errors');
            check = 2;
        }
        else{
            $('#neiros__tab_callback_time').removeClass('errors');
        }
	
}

        if(phone.indexOf("_") >= 0 || phone === ''){
            $('#neiros__callback_phone').addClass('errors');
            check = 2;
        }
        else{
            $('#neiros__callback_phone').removeClass('errors');
        }

		
		
        if ($('#squaredTwo').is(':checked')) {
            $('.neiros__copyright div').removeClass('errors-text');
        }
        else{
            $('.neiros__copyright div').addClass('errors-text');
            check = 3;}



        if(check === 0){

            $('#neiros__callback_phone').hide();
            $('#neiros__select_country').hide();
            $('#neiros__btn_calcback').hide();
		/*	$('#neiros__tab_callback_desc_time').css('display','none');
            $('#neiros__tab_callback_desc_text').html('Мы перезвоним в указанное время');*/
			
$('#neiros__tab_callback_desc_time').css('display','none');
    $('.classmms').html(`<div class="neiros__callback_h1">Мы перезвоним в указанное время </div>` );

            datatosend = {
                phone: phone,
                widget: {{$widget_chat->id}},
                neiros_visit:'{{$user_hash}}',
                site:'{{$site}}',
                _token: $('[name=_token]').val(),
                promo:  params['promo'],
                tip:  1,
                day:  day_z,
                time: time_z,



            }


            if(send==0) {
                send = 1;
                $.ajax({
                    type: "POST",
                    url: '/api/v1/widget/form/call',
                    data: datatosend,
                    success: function (html1) {


                    }
                })
            }

        }



    });
    function startTimer(duration, display) {
        display.show()
        var timer = duration, minutes, seconds;
        setInterval(function () {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.text("00:"+minutes + ":" + seconds);

            if (--timer < 0) {
                display.text("00:00:00");return ;
                timer = 0;

            }
        }, 1000);
        return ;
    }






	$('#neiros__callback_datepicker').on('click',function(){
		
		
		
		})

    $('.neiros__datepicker').datepicker();



    $('.neiros__timepicker').timepicki({
        show_meridian:false,
        min_hour_value:0,
        max_hour_value:23,
        overflow_minutes:true,
        disable_keyboard_mobile: true});

    var ddData = [
        {
            text: "",
            value: 'RU',
            selected: true,
            description: "",
            imageSrc: "https://cloud.neiros.ru/cdn/v1/callback/images/country/russia.png"
        },
        {
            text: '',
            selected: false,
            value: 'US',
            description: "",
            imageSrc: "https://cloud.neiros.ru/cdn/v1/callback/images/country/united-kingdom.png"
        }
    ];
    var ddData2 = [
        {
            text: "Завтра",
            value: 'Завтра',
            selected: true,
            description: ""
        },
        {
            text: 'Сегодня',
            selected: false,
            value: 'Сегодня',
            description: ""
        }
    ];

    var ddData3 = [
        {
            text: "09:00",
            value: '09:00',
            selected: true,
            description: ""
        },
        {
            text: '10:00',
            selected: false,
            value: '10:00',
            description: ""
        }
    ];

   /* $('#neiros__tab_callback_day').ddslick({
        data:ddData2,
        width:80,
        selectText: "",
        imagePosition:"left",
        onSelected: function(selectedData){
            selected = selectedData.selectedData.value;
            if(selected === 'US'){

            }
            if(selected === 'RU'){

            }
        }
    });*/
  /*  $('#neiros__tab_callback_time').ddslick({
        data:ddData3,
        width:65,
        selectText: "",
        imagePosition:"left",
        onSelected: function(selectedData){
            selected = selectedData.selectedData.value;
            if(selected === 'US'){

            }
            if(selected === 'RU'){

            }
        }
    });*/


    $('#neiros__chose_time').on('click', function(){
        $('.neiros__callback_container').css('display','none');
        $('.neiros__callback_container_another_time').css('display','block');
    })


    $('#neiros__select_country').ddslick({
        data:ddData,
        width:50,
        selectText: "",
        imagePosition:"left",
        onSelected: function(selectedData){
            selected = selectedData.selectedData.value;
            if(selected === 'US'){
                $('#neiros__callback_phone').removeClass('neiros__RU');
                $('#neiros__callback_phone').addClass('neiros__US');
                $('#neiros__callback_phone').attr('placeholder','+3 (___) ___-__-__');
                $(".neiros__US").inputmask('remove');
                $(".neiros__US").inputmask("+3 (999) 999-99-99", {"placeholder": "+3 (___) ___-__-__"});
            }
            if(selected === 'RU'){
                $('#neiros__callback_phone').removeClass('neiros__US');
                $('#neiros__callback_phone').addClass('neiros__RU');
                $('#neiros__callback_phone').attr('placeholder','+7 (___) ___-__-__');
                $(".neiros__RU").inputmask('remove');
                $(".neiros__RU").inputmask("+7 (999) 999-99-99", {"placeholder": "+7 (___) ___-__-__"});
            }
        }
    });
    $('#neiros__select_country_2').ddslick({
        data:ddData,
        width:50,
        selectText: "",
        imagePosition:"left",
        onSelected: function(selectedData){
            selected = selectedData.selectedData.value;
            if(selected === 'US'){
                $('#neiros__callback_phone_another').removeClass('neiros__RU');
                $('#neiros__callback_phone_another').addClass('neiros__US');
                $('#neiros__callback_phone_another').attr('placeholder','+3 (___) ___-__-__');
                $(".neiros__US").inputmask('remove');
                $(".neiros__US").inputmask("+3 (999) 999-99-99", {"placeholder": "+3 (___) ___-__-__"});
            }
            if(selected === 'RU'){
                $('#neiros__callback_phone_another').removeClass('neiros__US');
                $('#neiros__callback_phone_another').addClass('neiros__RU');
                $('#neiros__callback_phone_another').attr('placeholder','+7 (___) ___-__-__');
                $(".neiros__RU").inputmask('remove');
                $(".neiros__RU").inputmask("+7 (999) 999-99-99", {"placeholder": "+7 (___) ___-__-__"});
            }
        }
    });
    $('#neiros__select_country_3').ddslick({
        data:ddData,
        width:50,
        selectText: "",
        imagePosition:"left",
        onSelected: function(selectedData){
            selected = selectedData.selectedData.value;
            if(selected === 'US'){
                $('#neiros__application_phone').removeClass('neiros__RU');
                $('#neiros__application_phone').addClass('neiros__US');
                $('#neiros__application_phone').attr('placeholder','+3 (___) ___-__-__');
                $(".neiros__US").inputmask('remove');
                $(".neiros__US").inputmask("+3 (999) 999-99-99", {"placeholder": "+3 (___) ___-__-__"});
            }
            if(selected === 'RU'){
                $('#neiros__application_phone').removeClass('neiros__US');
                $('#neiros__application_phone').addClass('neiros__RU');
                $('#neiros__application_phone').attr('placeholder','+7 (___) ___-__-__');
                $(".neiros__RU").inputmask('remove');
                $(".neiros__RU").inputmask("+7 (999) 999-99-99", {"placeholder": "+7 (___) ___-__-__"});
            }
        }
    });

    $('#neiros__select_country').ddslick();
   /* $( window ).resize(function() {
        list = document.querySelector("#neiros__talk_chat_box .neiros__talk_chat");
        list.scrollTop = list.scrollHeight;

    })
*/


    /*$('#neiros__select_country').on('click', function () {
        var ddData = $('#neiros__select_country').data('ddslick');
        console.log(ddData.selectedData.value);
    });	*/


    var matches;
    (function(doc) {
        matches =
            doc.matchesSelector ||
            doc.webkitMatchesSelector ||
            doc.mozMatchesSelector ||
            doc.oMatchesSelector ||
            doc.msMatchesSelector;
    })(document.documentElement);

    /*выбор услуги*/





    mass = [];


    /*Открыть чат*/
    mass.forEach.call(
        document.querySelectorAll('.neiros__start_btn'), function(el) { el.addEventListener('click', function() {
            div = document.querySelector(".neiros__start_btn");
            classes = div.classList;
            classes.add("neiros__start_btn_show");
            list = document.querySelector(".neiros__start_btn img");
            list.style.display = 'none';

            return false;

        }, false);
        }
    )

    /*Закрыть приветствующее окно*/
    mass.forEach.call( document.querySelectorAll('.neiros__closet__hello_window'), function(el) { el.addEventListener('click', function() {
        list = document.querySelector("#neiros__chat_hello_window");
        list.style.display = 'none';
        return false;

    }, false);
    })





    /*Считывание введенного текста пользователем*/



    document.addEventListener('click', function(e) {
        if ( matches.call( e.target, '.neiros__start_btn_show') ) {
            div = document.querySelector(".neiros__start_btn");
            classes = div.classList;
            classes.remove("neiros__start_btn_show");
            list = document.querySelector(".neiros__start_btn img");
            list.style.display = 'block';
            list = document.querySelector("#neiros__panel_widget");
            list.style.display = 'none';
            return false;
        }
    }, false);

    /*Определение версии*/

    var params = window
        .location
        .search
        .replace('?','')
        .split('&')
        .reduce(
            function(p,e){
                var a = e.split('=');
                p[ decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
                return p;
            },
            {


            }
        );

    if(params['type']){
        type = params['type'];

        if(type === 'phone'){
            $('.neiros__all-servises li').removeClass('neiros__active_servis');
            $('.neiros__servis-phone').addClass('neiros__active_servis');
            $('.neiros__tab').removeClass('active');
            $('#neiros__tab_callback').addClass('active');
			$('#neiros__callback_phone').focus();
			
        }

    }



    if(params['mobile']){

    }
	
/*function sayHi() {
	

}

setTimeout(sayHi, 1000);	*/
    $(window).resize(function () {
 $('#neiros__callback_phone').focus()
    })

</script>

</body>
</html>