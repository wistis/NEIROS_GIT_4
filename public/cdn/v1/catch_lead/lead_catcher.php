<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Чат</title>
<link href="css/timepicki.css" rel="stylesheet" type="text/css">
<link href="css/datepicker.min.css" rel="stylesheet" type="text/css">
<link href="css/select2.css" rel="stylesheet" type="text/css">
<link href="css/jquery.raty.css" rel="stylesheet" type="text/css">
<link href="css/style_lead_catcher.css" rel="stylesheet" type="text/css">
<script src="js/jquery-2.1.1.js"></script>
<script src="js/jquery.inputmask.js"></script>
<script src="js/jquery.ddslick.min.js"></script>
<script src="js/datepicker.min.js"></script>
<script src="js/timepicki.js"></script>
<script src="js/select2.js"></script>
<script src="js/jquery.raty.js"></script>
</head>

<body>
<? if($_GET['time']){ 
$time = $_GET['time'];

}?>
<div id="neiros_pop-ups">
<div class="neiros__closet-icon-modal"><img  src="images/icons/closet-icon-modal.PNG" alt=""></div>
	<div id="neiros_pop-ups-container">
    <div id="neiros__pop_ups_position_1" >
        			<div class="neiros__pop_ups_text">
                    		<? if($time > 3600){?>Вы были на сайте <? echo date("H часов i минут s секуд", mktime(0, 0, $time)); ?>.<br><? } ?>
								Вы нашли, что искали?
                    </div>
                    <div class="neiros__pop_ups_btn_container">
                    	<div class="neiros__pop_ups_btn yes">Да</div>
                        <div class="neiros__pop_ups_btn no">Нет</div>
                    </div>
        
        </div>
    	
        
        <div id="neiros__pop_ups_position_2" style="display:none">
        			<div class="neiros__pop_ups_text">
                    		Закажите обратный звонок
							<div>Вы можете выбрать удобное время для связи с Вами!</div>
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
        
        
         <div id="neiros__pop_ups_position_3" style="display:none">
        			<div class="neiros__pop_ups_text">
                    		Хотите мы Вам бесплатно перезвоним?

							<div>Укажите свой телефон и наш оператор перезвонит Вам в течении <b>2 секунд!</b></div>
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
                    <input type="checkbox" value="None" id="squaredTwo" name="check" checked="">
                    <label for="squaredTwo"></label>
                </div>
                <div>Согласен на обработку персональных данных</div>
            </div>
        </div>
        
        
        <div id="neiros__pop_ups_position_4" style="display:none">
        
        			<div class="neiros__pop_ups_text_operator_cont">
<div class="neiros__pop_ups_operator"><img src="images/operator2.JPG" alt=""></div>
        			<div class="neiros__pop_ups_text">
                   
                    		Могу ли я Вам помочь?
							<div> Наш лучший оператор свяжется с Вами в течении <b>2 секунд!</b><br>
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
                    <input type="checkbox" value="None" id="squaredTwo" name="check" checked="">
                    <label for="squaredTwo"></label>
                </div>
                <div>Согласен на обработку персональных данных</div>
            </div>
        </div>
        
		 <div id="neiros__pop_ups_position_5" style="display:none">
                            <div class="neiros__pop_ups_text">
                                    Закажите обратный звонок
                                    <div>Вы можете выбрать удобное время для связи с Вами!</div>
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
                            <input type="checkbox" value="None" id="squaredTwo" name="check" checked="">
                            <label for="squaredTwo"></label>
                        </div>
                        <div>Согласен на обработку персональных данных</div>
                    </div>
                </div>
        
        <div id="neiros__pop_ups_position_6" style="display:none">
        			<div class="neiros__pop_ups_text">
                                Хотите мы Вам бесплатно перезвоним?
							<div>Укажите свой телефон и наш оператор перезвонит Вам в течении 2 секунд!</div>
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
                    <input type="checkbox" value="None" id="squaredTwo" name="check" checked="">
                    <label for="squaredTwo"></label>
                </div>
                <div>Согласен на обработку персональных данных</div>
            </div>
        </div>
        
        
        <div id="neiros__pop_ups_position_7" style="display:none">
        
        			<div class="neiros__pop_ups_text_operator_cont">
<div class="neiros__pop_ups_operator"><img src="images/operator2.JPG" alt=""></div>
        			<div class="neiros__pop_ups_text">
                   
                    		Могу ли я Вам помочь?
							<div> Наш лучший оператор свяжется с Вами в течении <b>2 секунд!</b><br>
                                Это бесплатно!
                            </div>
                    </div>
                   </div> 
                    
                    <div class="neiros__pop_ups_callback_container">
           <div class="neiros__pop_ups_callback_name">
                    <input type="text" id="" placeholder="Ваше имя" class="neiros__callback_input" value="">
            </div>      
        <div class="neiros__pop_ups_phone_block">
        <input type="text" id="" placeholder="+7 (___) ___-__-__" class="neiros__callback_input neuron__RU" value="">
        <div id="neiros__select_country6" class="neiros__select_country"></div>
        <div class="neiros__btn_pop_ups_phone_desc">Жду звонка!</div>
        </div>
                    </div>
        <div class="neiros__pop_ups_callback_chose_time"><span>Выбрать удобное время</span></div>            
                    
            	<div class="neiros__copyright">
                <div class="squaredTwo">
                    <input type="checkbox" value="None" id="squaredTwo" name="check" checked="">
                    <label for="squaredTwo"></label>
                </div>
                <div>Согласен на обработку персональных данных</div>
            </div>
        </div>
        
        
        <div id="neiros__pop_ups_position_8" style="display:none" >
        			<div class="neiros__pop_ups_text">
                    		Ваше сообщение принято.<br>
                            Специалист свяжется с вами в ближайшее время
                    </div>
        </div>
        
        <div id="neiros__pop_ups_position_9" style="display:none" >
        			<div class="neiros__pop_ups_text">
                    		Спасибо за ваше обращение!<br>
					Оцените качество работы специалиста
                    </div>
                    <div class="rating"></div>
        </div>
        
        
<div id="neiros__pop_ups_position_10" style="display:none">
             <div class="neiros__pop_ups_cooldown">
                  <img src="images/icons/clock.png"> <span>00:00:30</span>
             </div>
       	  </div>
	   
       
       <div id="neiros__pop_ups_position_11" style="display:none" >
        			<div class="neiros__pop_ups_text">
                    	Подпишись и будь с нами всегда <img src="images/icons/smile.PNG">
                    </div>
                    <div class="neiros__pop_ups_social">
                    	<a class="social_facebook" href=""></a>
                        <a class="social_telegram" href=""></a>
                        <a class="social_vk" href=""></a>
                        <a class="social_viber" href=""></a>
                    </div>
        </div>
        
        
        <div id="neiros__pop_ups_position_12" style="display:none" >
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
$('#neiros__pop_ups_position_3 .neiros__pop_ups_callback_chose_time').on('click', function(){
	$('#neiros__pop_ups_position_3').css('display', 'none');
	$('#neiros__pop_ups_position_2').css('display', 'block');
	$(".neiros__callback_input").focus();
	})

$('.neiros__pop_ups_right').on('click', function(){
	$('#neiros__pop_ups_position_12').remove();
	$('#neiros__pop_ups_position_8').css('display','block');
	})
$('.neiros__pop_ups_left').on('click', function(){
	$('#neiros__pop_ups_position_12').remove();
	$('#neiros__pop_ups_position_9').css('display','block');
	})	
$('.neiros__pop_ups_btn.yes, .neiros__pop_ups_btn.no').on('click',function(){
	$('#neiros__pop_ups_position_1').css('display','none');
	$('#neiros__pop_ups_position_3').css('display','block');
	$(".neiros__callback_input").focus();
	
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
		var fiveMinutes = 60 * 0.5,
    display = $('#neiros__pop_ups_position_10 .neiros__pop_ups_cooldown span');
    startTimer(fiveMinutes, display);
	$('#neiros__pop_ups_position_3').css('display','none');
	$('#neiros__pop_ups_position_10').css('display','block');
	

	})

$('#neiros__pop_ups_position_2 .neiros__btn_pop_ups_phone_desc').on('click', function(){
	$('#neiros__pop_ups_position_2').css('display','none');
	$('#neiros__pop_ups_position_11').css('display','block');
	

	})			
	
$(document).on('click','.rating img', function(){
	$('#neiros__pop_ups_position_9').css('display', 'none');
	$('#neiros__pop_ups_position_11').css('display', 'block');
	
	})	
$('.rating').raty({ 

starOff:   'images/icons/star-no-select.PNG',                            
starOn:    'images/icons/star-select.PNG'  
});
    $('#neiros__tab_callback_day').select2({
        placeholder: 'Завтра',
        minimumResultsForSearch: -1
    });
	$('#neiros__tab_callback_time').select2({
        placeholder: '10:00',
        minimumResultsForSearch: -1
    });
var ddData = [
    {
        text: "",
        value: 'RU',
        selected: true,
        description: "",
        imageSrc: "images/country/russia.png"
    },
    {
        text: '',
        selected: false,
		value: 'US',
        description: "",
        imageSrc: "images/country/united-kingdom.png"
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
</script>

</body>
</html>