<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Чат</title>
    <link href="/cdn/v1/catch_lead/css/timepicki.css" rel="stylesheet" type="text/css">
    <link href="/cdn/v1/catch_lead/css/datepicker.min.css" rel="stylesheet" type="text/css">
    <link href="/cdn/v1/catch_lead/css/select2.css" rel="stylesheet" type="text/css">
    <link href="/cdn/v1/catch_lead/css/jquery.raty.css" rel="stylesheet" type="text/css">
    <link href="/cdn/v1/catch_lead/css/style_lead_catcher.css" rel="stylesheet" type="text/css">
    <script src="/cdn/v1/catch_lead/js/jquery-2.1.1.js"></script>
    <script src="/cdn/v1/catch_lead/js/jquery.inputmask.js"></script>
    <script src="/cdn/v1/catch_lead/js/jquery.ddslick.min.js"></script>
    <script src="/cdn/v1/catch_lead/js/datepicker.min.js"></script>
    <script src="/cdn/v1/catch_lead/js/timepicki.js"></script>
    <script src="/cdn/v1/catch_lead/js/select2.js"></script>
    <script src="/cdn/v1/catch_lead/js/jquery.raty.js"></script>
</head>

<body>
<? if($_GET['time']){
    $time = $_GET['time'];

}
$neiros_href_click = '';
if($_GET['neiros_href_click']){
$neiros_href_click = 	$_GET['neiros_href_click'];
	
	}
/*секунду', 'секунды', 'секунд'*/
function num2word($num, $words)
{
    $num = $num % 100;
    if ($num > 19) {
        $num = $num % 10;
    }
    switch ($num) {
        case 1: {
            return($words[1]);
        }
        case 2: case 3: case 4: {
        return($words[2]);
    }
        default: {
            return($words[2]);
        }
    }
}

?>
<div id="neiros_pop-ups">
    <div class="neiros__closet-icon-modal"><img  src="/cdn/v1/catch_lead/images/icons/closet-icon-modal.PNG" alt=""></div>
    <div id="neiros_pop-ups-container" style="display:block">
        <?php /*?><div class="neiros_all_block" id="neiros__pop_ups_position_1" >
            <div class="neiros__pop_ups_text">
                <? if($time > 3600){?>Вы были на сайте <? echo date("H часов i минут s секуд", mktime(0, 0, $time)); ?>.<br><? } ?>
{{$ab['position_1_text']}}
            </div>
            <div class="neiros__pop_ups_btn_container">
                <div class="neiros__pop_ups_btn yes" style="background:{{$ab['position_1_yes_bcolor']}} ;color:{{$ab['position_1_yes_tcolor']}} ">{{$ab['position_1_yes_text']}}</div>
                <div class="neiros__pop_ups_btn no"  style="background:{{$ab['position_1_not_bcolor']}} ;color:{{$ab['position_1_not_rcolor']}} ">{{$ab['position_1_not_text']}}</div>
            </div>

        </div><?php */?>


        <div class="neiros_all_block" id="neiros__pop_ups_position_2" >
            <div class="neiros__pop_ups_text">
                Закажите обратный звонок
                <div>Вы можете выбрать удобное время для связи с нами!</div>
            </div>
            <div class="neiros__pop_ups_callback_container">
                <div class="neiros__pop_ups_data_block">
                    <div class="neiros__pop_ups_data_block_day">
                        <select id="neiros__tab_callback_day"  >
                            <option></option>
                            @for($i=0;$i<count($dayt);$i++)
                                <option value="{{$dayt[$i]['day']}}"  >{{$dayt[$i]['name']}}</option>

                            @endfor
                        </select>




                    </div>
                    <div class="neiros__pop_ups_data_block_time">
                        <select id="neiros__tab_callback_time" name="timmm" disabled >
                            <option></option>

                        </select>
                    </div>

                </div>
                <div class="neiros__pop_ups_phone_block">
                    <input type="text" id="" placeholder="+7 (___) ___-__-__" class="neiros__callback_input neuron__RU" value="">
                    <div id="neiros__select_country2" class="neiros__select_country"></div>
                    <div class="neiros__btn_pop_ups_phone_desc">Жду звонка!</div>
                </div>
            </div>
            <div class="neiros__copyright">
                <div class="squaredTwo">
                    <input type="checkbox" value="None" id="squaredTwo" name="check" checked="">
                    <label for="squaredTwo"></label>
                </div>
                <div>Согласен на обработку персональных данных</div>
            </div>
        </div>


        <div class="neiros_all_block" id="neiros__pop_ups_position_3" style="display:none">
            <div class="neiros__pop_ups_text">
                Хотите мы Вам бесплатно перезвоним?

                <div>Укажите свой телефон и наш оператор перезвонит Вам в течение <b>{{$widget_chat->callback_timer}} {{num2word($widget_chat->callback_timer, array('секунду', 'секунды', 'секунд'))}}!</b></div>
            </div>
            <div class="neiros__pop_ups_callback_container">

                <div class="neiros__pop_ups_phone_block">
                    <input type="text" id="" placeholder="+7 (___) ___-__-__" class="neiros__callback_input neuron__RU" value="">
                    <div id="neiros__select_country1" class="neiros__select_country"></div>
                    <div class="neiros__btn_pop_ups_phone_desc">Жду звонка!</div>
                </div>
            </div>
             <div class="neiros__pop_ups_callback_chose_time"><span>Выбрать удобное время</span></div>

            <div class="neiros__copyright">
                <div class="squaredTwo">
                    <input type="checkbox" value="None" id="squaredTwo2" name="check" checked="">
                    <label for="squaredTwo2"></label>
                </div>
                <div>Согласен на обработку персональных данных</div>
            </div>
        </div>


        <div class="neiros_all_block" id="neiros__pop_ups_position_4" style="display:none">

            <div class="neiros__pop_ups_text_operator_cont">
                <div class="neiros__pop_ups_operator"><img src="/cdn/v1/catch_lead/images/operator2.JPG" alt=""></div>
                <div class="neiros__pop_ups_text">

                    Могу ли я Вам помочь?
                    <div> Наш лучший оператор свяжется с Вами в течение <b>{{$widget_chat->callback_timer}} {{num2word($widget_chat->callback_timer, array('секунду', 'секунды', 'секунд'))}}!</b><br>
                        Это бесплатно!
                    </div>
                </div>
            </div>

            <div class="neiros__pop_ups_callback_container">

                <div class="neiros__pop_ups_phone_block">
                    <input type="text" id="" placeholder="+7 (___) ___-__-__" class="neiros__callback_input neuron__RU" value="">
                    <div id="neiros__select_country3" class="neiros__select_country"></div>
                    <div class="neiros__btn_pop_ups_phone_desc">Жду звонка!</div>
                </div>
            </div>
            <div class="neiros__pop_ups_callback_chose_time"><span>Выбрать удобное время</span></div>

            <div class="neiros__copyright">
                <div class="squaredTwo">
                    <input type="checkbox" value="None" id="squaredTwo3" name="check" checked="">
                    <label for="squaredTwo3"></label>
                </div>
                <div>Согласен на обработку персональных данных</div>
            </div>
        </div>

        <div class="neiros_all_block" id="neiros__pop_ups_position_5" style="display:none">
            <div class="neiros__pop_ups_text">
                Закажите обратный звонок
                <div>Вы можете выбрать удобное время для связи с нами!</div>
            </div>
            <div class="neiros__pop_ups_callback_container">
                <div class="neiros__pop_ups_data_block">
                    <div class="neiros__pop_ups_data_block_day">
                        <select id="neiros__tab_callback_day"  >
                            <option></option>
                            <option>Сегодня</option>
                            <option>Завтра</option>
                        </select>
                    </div>
                    <div class="neiros__pop_ups_data_block_time">
                        <select id="neiros__tab_callback_time"  >
                            <option></option>
                            <option>09:00</option>
                            <option>10:00</option>
                        </select>
                    </div>
                </div>
                <div class="neiros__pop_ups_callback_name">
                    <input type="text" id="" placeholder="Ваше имя" class="neiros__callback_input" value="">
                </div>
                <div class="neiros__pop_ups_phone_block">
                    <input type="text" id="" placeholder="+7 (___) ___-__-__" class="neiros__callback_input neuron__RU" value="">
                    <div id="neiros__select_country4" class="neiros__select_country"></div>
                    <div class="neiros__btn_pop_ups_phone_desc">Жду звонка!</div>
                </div>
            </div>

            <div class="neiros__copyright">
                <div class="squaredTwo">
                    <input type="checkbox" value="None" id="squaredTwo4" name="check" checked="">
                    <label for="squaredTwo4"></label>
                </div>
                <div>Согласен на обработку персональных данных</div>
            </div>
        </div>

        <div class="neiros_all_block" id="neiros__pop_ups_position_6" style="display:none">
            <div class="neiros__pop_ups_text">
                Хотите мы Вам бесплатно перезвоним?
                <div>Укажите свой телефон и наш оператор перезвонит Вам в течение {{$widget_chat->callback_timer}} {{num2word($widget_chat->callback_timer, array('секунду', 'секунды', 'секунд'))}}!</div>
            </div>
            <div class="neiros__pop_ups_callback_container">
                <div class="neiros__pop_ups_callback_name">
                    <input type="text" id="" placeholder="Ваше имя" class="neiros__callback_input" value="">
                </div>
                <div class="neiros__pop_ups_phone_block">
                    <input type="text" id="" placeholder="+7 (___) ___-__-__" class="neiros__callback_input neuron__RU" value="">
                    <div id="neiros__select_country5" class="neiros__select_country"></div>
                    <div class="neiros__btn_pop_ups_phone_desc">Жду звонка!</div>
                </div>
            </div>

            <div class="neiros__pop_ups_callback_chose_time"><span>Выбрать удобное время</span></div>
            <div class="neiros__copyright">
                <div class="squaredTwo">
                    <input type="checkbox" value="None" id="squaredTwo5" name="check" checked="">
                    <label for="squaredTwo5"></label>
                </div>
                <div>Согласен на обработку персональных данных</div>
            </div>
        </div>


        <div class="neiros_all_block" id="neiros__pop_ups_position_7" style="display:none">

            <div class="neiros__pop_ups_text_operator_cont">
                <div class="neiros__pop_ups_operator"><img src="/cdn/v1/catch_lead/images/operator2.JPG" alt=""></div>
                <div class="neiros__pop_ups_text">

                    Могу ли я Вам помочь?
                    <div> Наш лучший оператор свяжется с Вами в течение <b>{{$widget_chat->callback_timer}} {{num2word($widget_chat->callback_timer, array('секунду', 'секунды', 'секунд'))}}!</b><br>
                        Это бесплатно!
                    </div>
                </div>
            </div>

            <div class="neiros__pop_ups_callback_container">
                <div class="neiros__pop_ups_callback_name">
                    <input type="text" id="" placeholder="Ваше имя" class="neiros__callback_input" value="">
                </div>
                <div class="neiros__pop_ups_phone_block">
                    <input type="text" id="new_phone" placeholder="+7 (___) ___-__-__" class="neiros__callback_input neuron__RU" value="">
                    <div id="neiros__select_country6" class="neiros__select_country"></div>
                    <div class="neiros__btn_pop_ups_phone_desc">Жду звонка!</div>
                </div>
            </div>
            <div class="neiros__pop_ups_callback_chose_time"><span>Выбрать удобное время</span></div>

            <div class="neiros__copyright">
                <div class="squaredTwo">
                    <input type="checkbox" value="None" id="squaredTwo6" name="check" checked="">
                    <label for="squaredTwo6"></label>
                </div>
                <div>Согласен на обработку персональных данных</div>
            </div>
        </div>


        <div class="neiros_all_block" id="neiros__pop_ups_position_8" style="display:none" >
            <div class="neiros__pop_ups_text">
                Ваше сообщение принято.<br>
                Специалист свяжется с вами в ближайшее время
            </div>
        </div>

        <div class="neiros_all_block" id="neiros__pop_ups_position_9" style="display:none" >
            <div class="neiros__pop_ups_text">
                Спасибо за ваше обращение!<br>
              {{--  Оцените качество работы специалиста--}}
            </div>
            {{--<div class="rating"></div>--}}
        </div>


        <div class="neiros_all_block" id="neiros__pop_ups_position_10" style="display:none">
            <div class="neiros__pop_ups_cooldown">
                <img src="/cdn/v1/catch_lead/images/icons/clock.png"> <span>00:00:{{$widget_chat->callback_timer}}</span>
            </div>
        </div>


        <div class="neiros_all_block" id="neiros__pop_ups_position_11" style="display:none" >
            <div class="neiros__pop_ups_text">
               Мы перезвоним в указанное Вами время {{--Подпишись и будь с нами всегда <img src="/cdn/v1/catch_lead/images/icons/smile.PNG">--}}
            </div>
           {{-- <div class="neiros__pop_ups_social">
                <a class="social_facebook" href=""></a>
                <a class="social_telegram" href=""></a>
                <a class="social_vk" href=""></a>
                <a class="social_viber" href=""></a>
            </div>--}}
        </div>


        <div class="neiros_all_block" id="neiros__pop_ups_position_12" style="display:none" >
            <div class="neiros__pop_ups_text">
                Мы успели Вам перезвонить?
            </div>
            <div class="neiros__pop_ups_block">
                <div class="neiros__pop_ups_left">
                    <span>Да успели!</span>
                </div>
                <div class="neiros__pop_ups_right">
                    <span>Нет, пожаловаться</span>
                    <div>будет оправлено sms<br>
                        уведомление руковадителю
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

</div>

<script>
var send=0;
data_step={
    step_0:0,
    step_1:0,
    step_end:0,
    lead:0,
    ab:{{$ab['id']}},
    step:0,
    neiros_visit:'{{$neiros_visit}}',
    neiros_url_vst:'{{$neiros_url_vst}}',
    project_id:0,
}




function sendcall(phone){

    datatosend = {
        phone:phone,
        widget: {{$widget_chat->id}},
        neiros_visit:'{{$neiros_visit}}',
        neiros_url_vst:'{{$neiros_url_vst}}',
        site:'{{$site}}',
        _token: $('[name=_token]').val(),
        promo:  '',
        tip:  19,
ab:{{$ab['id']}}


    }


    if(send==0) {
        send = 1;
        $.ajax({
            type: "POST",
            url: '/api/v1/sendcall',
            data: datatosend,
            success: function (html1) {

                data_step.project_id = html1;
                data_step.lead = 1;
                sendstep();

            }
        })
    }

}
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



    //////



    $('#neiros__pop_ups_position_3 .neiros__pop_ups_callback_chose_time span').on('click', function(){
        $('.neiros_all_block').css('display', 'none');
        $('#neiros__pop_ups_position_2').css('display', 'block');
        $("#neiros__pop_ups_position_2 .neiros__callback_input").focus();


    })

    $('.neiros__pop_ups_right').on('click', function(){

            data_step.step_1=2;
            data_step.step=2;
            sendstep();

        $('#neiros__pop_ups_position_12').remove();
		$('.neiros_all_block').css('display', 'none');
        $('#neiros__pop_ups_position_8').css('display','block');
    })
    $('.neiros__pop_ups_left').on('click', function(){
        data_step.step_1=1;
        data_step.step=2;
        sendstep();
        $('#neiros__pop_ups_position_12').remove();
		$('.neiros_all_block').css('display', 'none');
        $('#neiros__pop_ups_position_9').css('display','block');
    })
    $('.neiros__pop_ups_btn.yes, .neiros__pop_ups_btn.no').on('click',function(){

        var className = $(this).attr('class');

        if(className=='neiros__pop_ups_btn no'){
            data_step.step_0=2;
        }else{
            data_step.step_0=1;
        }
        data_step.step=1;
        sendstep();
        $('.neiros_all_block').css('display', 'none');
        $('#neiros__pop_ups_position_3').css('display','block');
        $("#neiros__pop_ups_position_3 .neiros__callback_input").focus();
        @if($off==1)
       $('.neiros_all_block').css('display', 'none');
        $('#neiros__pop_ups_position_2').css('display', 'block');
        $("#neiros__pop_ups_position_2 .neiros__callback_input").focus();

        @endif

    })

    function startTimer(duration, display) {
        var timer = duration, minutes, seconds;
        setInterval(function () {
            minutes = parseInt(timer / 60, 10)
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;
            if (timer == 00){
                display.text("00:00:00");
                $('#neiros__pop_ups_position_10').css('display','none');
                $('#neiros__pop_ups_position_12').css('display','block');
                return false
            }
            else{
                display.text("00:" + minutes + ":" + seconds);}

            if (--timer < 0) {
                timer = duration;
            }
        }, 1000);
    }



    $('#neiros__pop_ups_position_3 .neiros__btn_pop_ups_phone_desc').on('click', function(){
		phone = $('#neiros__pop_ups_position_3 .neiros__callback_input').val(); 

        if($('#neiros__pop_ups_position_3 .neiros__callback_input').val() == '' || phone.indexOf("_") > -1){
			$('#neiros__pop_ups_position_3 .neiros__callback_input').addClass('neiros__error');
            return false;     
		 }
		 
		 
		$('#neiros__pop_ups_position_3 .neiros__callback_input').removeClass('neiros__error'); 
		
				  if ($('#squaredTwo2').is(':checked')) {
			  $('.neiros__copyright div').removeClass('errors-text');
			  }
		 	  else{
				 $('.neiros__copyright div').addClass('errors-text');
				 return false;
				 }	 
		 
        var fiveMinutes = {{$widget_chat->callback_timer}} ,
            display = $('#neiros__pop_ups_position_10 .neiros__pop_ups_cooldown span');
        startTimer(fiveMinutes, display);
       $('.neiros_all_block').css('display', 'none');
        $('#neiros__pop_ups_position_10').css('display','block');
        sendcall(  $('#neiros__pop_ups_position_3 .neiros__callback_input').val());

    })

    $('#neiros__pop_ups_position_2 .neiros__btn_pop_ups_phone_desc').on('click', function(){
				
		phone = $('#neiros__pop_ups_position_2 .neiros__callback_input').val(); 
        if($('#neiros__pop_ups_position_2 .neiros__callback_input').val() == '' || phone.indexOf("_") > -1){
			$('#neiros__pop_ups_position_2 .neiros__callback_input').addClass('neiros__error');
            return false;     
		 }
		 
		 
		$('#neiros__pop_ups_position_2 .neiros__callback_input').removeClass('neiros__error'); 
		
				if ($('#squaredTwo').is(':checked')) {
			  $('.neiros__copyright div').removeClass('errors-text');
			  }
		 	  else{
				 $('.neiros__copyright div').addClass('errors-text');
				 return false;
				 }	 
		 		
				
		if($('#neiros__pop_ups_position_2 #neiros__tab_callback_day option:selected').val() === '' || $('#neiros__pop_ups_position_2 #neiros__tab_callback_time option:selected').val() === '')	{
			$('#neiros__pop_ups_position_2 .neiros__pop_ups_data_block').addClass('neiros__error');
			return false;
			}
		else {
			$('#neiros__pop_ups_position_2 .neiros__pop_ups_data_block').removeClass('neiros__error');
			}


      $('.neiros_all_block').css('display', 'none');
        $('#neiros__pop_ups_position_11').css('display','block');

sendcall_tomorrov($('#neiros__pop_ups_position_2 .neiros__callback_input').val())
    })
function sendcall_tomorrov( phone){




        day_z=$('#neiros__tab_callback_day').val();
        time_z= $('#neiros__tab_callback_time').val();
        datatosend = {
            phone: phone,
            widget: {{$widget_chat->id}},
            neiros_visit:'{{$neiros_visit}}',
            neiros_url_vst:'{{$neiros_url_vst}}',
            site:'{{$site}}',
            _token: $('[name=_token]').val(),

            tip:  19,
            day:  day_z,
            time: time_z,
            ab:{{$ab['id']}}
            }



    if(send==0) {
        send = 1;
        $.ajax({
            type: "POST",
            url: '/api/v1/widget/form/call',
            data: datatosend,
            success: function (html1) {
                data_step.project_id = html1;
                data_step.lead = 1;
                sendstep();


            }
        })

    }



}
    $(document).on('click','.rating img', function(){
        $('.neiros_all_block').css('display', 'none');
        $('#neiros__pop_ups_position_11').css('display', 'block');

    })
    $('.rating').raty({

        starOff:   '/cdn/v1/catch_lead/images/icons/star-no-select.PNG',
        starOn:    '/cdn/v1/catch_lead/images/icons/star-select.PNG'
    });
    $('#neiros__tab_callback_day').select2({
        placeholder: 'Дата',
        minimumResultsForSearch: -1
    });
    $('#neiros__tab_callback_time').select2({
        placeholder: 'Время',
        minimumResultsForSearch: -1
    });
    var ddData = [
        {
            text: "",
            value: 'RU',
            selected: true,
            description: "",
            imageSrc: "/cdn/v1/catch_lead/images/country/russia.png"
        },
        {
            text: '',
            selected: false,
            value: 'US',
            description: "",
            imageSrc: "/cdn/v1/catch_lead/images/country/united-kingdom.png"
        }
    ];
    $('.neiros__select_country').ddslick({
        data:ddData,
        width:50,
        selectText: "",
        imagePosition:"left",
        onSelected: function(selectedData){
            selected = selectedData.selectedData.value;
            if(selected === 'US'){
                $('.neiros__callback_input').removeClass('neiros__RU');
                $('.neiros__callback_input').addClass('neiros__US');
                $('.neiros__callback_input').attr('placeholder','+3 (___) ___-__-__');
                $(".neiros__US").inputmask('remove');
                $(".neiros__US").inputmask("+3 (999) 999-99-99", {"placeholder": "+3 (___) ___-__-__"});
            }
            if(selected === 'RU'){
                $('.neiros__callback_input').removeClass('neiros__US');
                $('.neiros__callback_input').addClass('neiros__RU');
                $('.neiros__callback_input').attr('placeholder','+7 (___) ___-__-__');
                $(".neiros__RU").inputmask('remove');
                $(".neiros__RU").inputmask("+7 (999) 999-99-99", {"placeholder": "+7 (___) ___-__-__"});
            }
        }
    });


    $('#neiros__select_country').ddslick();

    function sendstep() {
        $.ajax({
            type: "POST",
            url: '/api/v1/catch_lead/send_step',
            data: data_step,
            success: function (html1) {



            }
        })

    }
if($('#neiros__pop_ups_position_3').is(":visible")){
	$("#neiros__pop_ups_position_3 .neiros__callback_input").focus();
			$('.neiros__pop_ups_btn .yes').focus();
		$('.neiros__pop_ups_btn_container').focus();
		
	
	}
	
    $(window).resize(function () {
       $("#neiros__pop_ups_position_3 .neiros__callback_input").focus();
		$('.neiros__pop_ups_btn .yes').focus();
		$('.neiros__pop_ups_btn_container').focus();
		

    })
$('.neiros_all_block').css('display', 'none');	

<?php /*?>if( '<?=$neiros_href_click?>' == 1){
	$('#neiros__pop_ups_position_1').css('display','none');
	$('#neiros__pop_ups_position_2').css('display','block');
	$("#neiros__pop_ups_position_2 .neiros__callback_input").focus();
	}
else{
	$('#neiros__pop_ups_position_1').css('display','block');
	
	}	<?php */?>

$('#neiros__pop_ups_position_2').css('display','block');
$("#neiros__pop_ups_position_2 .neiros__callback_input").focus();

	



@if($ab['first_step_status']==0)
/*$('#neiros__pop_ups_position_1').css('display','none');*/


@if($off==1)
$('.neiros_all_block').css('display', 'none'); $('#neiros__pop_ups_position_2').css('display','block');$("#neiros__pop_ups_position_2 .neiros__callback_input").focus();@else
$('.neiros_all_block').css('display', 'none');$('#neiros__pop_ups_position_3').css('display','block');
@endif
$("#neiros__pop_ups_position_3 .neiros__callback_input").focus();
    @endif
$("#neiros__pop_ups_position_2 .neiros__callback_input").focus();
</script>

</body>
</html>