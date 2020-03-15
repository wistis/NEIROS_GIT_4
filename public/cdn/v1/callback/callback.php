<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Чат</title>
<link href="css/timepicki.css" rel="stylesheet" type="text/css">
<link href="css/datepicker.min.css" rel="stylesheet" type="text/css">
<link href="css/select2.css" rel="stylesheet" type="text/css">
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/style_call.css" rel="stylesheet" type="text/css">
<script src="js/jquery-2.1.1.js"></script>
<script src="js/jquery.inputmask.js"></script>
<script src="js/jquery.ddslick.min.js"></script>
<script src="js/datepicker.min.js"></script>
<script src="js/timepicki.js"></script>
<script src="js/select2.js"></script>
</head>

<body>


<? 
$mobile = '';
$mobile_animation = '';
$desc_animation = 'neiros__slideLeft';

if($_GET['mobile']){
	
 if($_GET['type']){
	if($_GET['type'] == 'social' || $_GET['type'] == 'lidi' || $_GET['type'] == 'phone'){
	$mobile = 'mobile';
	$mobile_animation = 'neiros__slideUp';
	$desc_animation = '';
	}	
	
}	
}	

?>


 
<div id="neiros__panel_widget" class="<? echo $mobile.$desc_animation?>" >
<? if($mobile == ''){ ?>

<? if(!$_GET['mobile']){ ?>

<? } ?>
<? }  ?>

 <? if(!$_GET['mobile']){ ?>
<div id="neiros__tab_callback_desc" class=" ">

<div class="neiros__closet-icon-modal"><img  src="images/icons/closet-icon-modal-callback.PNG" alt=""></div>

	<div id="neiros__tab_callback_desc_cont" class="">
    
     <div id="neiros__callback_chose_time"><span>Выбрать удобное время</span></div>
    
    	<div id="neiros__tab_callback_desc_text">
        Перезвоним бесплатно
		<div>за 24 секунды!</div>
        
        </div>
        <div id="neiros__tab_callback_desc_time">
       <div id="neiros__tab_callback_day"></div>
       <div id="neiros__tab_callback_time"></div>
        </div>
        
        
    	        <input type="text" id="neiros__callback_phone" placeholder="+7 (___) ___-__-__" class="neiros__callback_input neiros__RU" value="">
            <div id="neiros__select_country"></div>
            <div id="neiros__btn_calcback_desc" class="neiros__btn_calcback_call1"><span>жду звонка</span></div>
            
                <div class="neiros__copyright"> 
                    <div class="squaredTwo">
                    <input type="checkbox" value="None" id="squaredTwo" name="check" checked />
                    <label for="squaredTwo"></label>
                    </div>
                    <div>Согласен на обработку персональных данных</div>
                </div>
    		<div class="neiros__copiright_new">Виджет заряжен Neiros</div>
    
    
    </div>

</div>    
<? } else{ ?>
<div id="neiros__tab_callback" class="neiros__tab ">
    <div class="neiros__callback_container <?=$mobile_animation?>">
    
    	<div class="neiros__callback_h1">Мы перезвоним Вам за 7 секунд.
Засейкайте!</div>
		
        <input type="text" id="neiros__callback_phone" placeholder="+7 (___) ___-__-__" class="neiros__callback_input neiros__RU" value="">
<!--    	<select id="neiros__select_country">
<option value="RU" data-imagesrc="images/country/russia.png" selected></option>
        <option value="US" data-imagesrc="images/country/united-kingdom.png"></option>
        </select>-->
        <div id="neiros__select_country"></div>
        
        <div id="neiros__btn_calcback">жду звонка</div>
        <div id="neiros__countdown">00:00:07</div>
        <div id="neiros__chose_time"><span>Выбрать удобное время</span></div>
          <div class="neiros__chose_closet">Отмена</div>
          <div class="neiros__copiright_new">Виджет заряжен Neuron</div>
       
        
    </div>
    <div class="neiros__callback_container_another_time" style="display:none;">
        	<div class="neiros__callback_h1">Хотите, чтобы мы Вам перезвонили?
Вы можете выбрать удобное время для
связи с Вами! </div>

     <div class="neiros__callback_h1" style="display:none;">Сейчас сотрудники не в офисе. Но вы
можете выбрать время и мы
перезвоним Вам! </div>

<input type="text" class="neiros__datepicker" placeholder="Дата" id="neiros__callback_datepicker">
<div class="neiros__word">в</div>
<input type="text" class="neiros__timepicker" placeholder="Время"  id="neiros__callback_timepicker">

<input type="text" id="neiros__callback_phone_another" placeholder="+7 (___) ___-__-__" class="neiros__callback_input neiros__RU" value="" style="margin-top:15px;">
     <div id="neiros__select_country_2"></div>
      <div id="neiros__btn_calcback_another">жду звонка</div>
      <div class="neiros__chose_closet">Отмена</div>
      <div class="neiros__copiright_new">Виджет заряжен Neiros</div>
    </div>
    <div class="neiros__copyright"> 
    <div class="squaredTwo">
    <input type="checkbox" value="None" id="squaredTwo" name="check" checked />
	<label for="squaredTwo"></label>
    </div>
    <div>Согласен на обработку персональных данных</div>
    </div>

</div>  
  
 <? } ?>
</div>

<script>

$('#neiros__callback_chose_time').on('click',function(){
	$('#neiros__btn_calcback_desc').removeClass('neiros__btn_calcback_call1');
	$('#neiros__btn_calcback_desc').addClass('neiros__btn_calcback_call2');
	$('#neiros__tab_callback_desc_cont').addClass('neiros__btn_calcback_letter');
	$('#neiros__btn_calcback_desc span').html('ok');
	$('#neiros__tab_callback_desc_text').html('Уточните удобное<br>время звонка');
	
	})
$('#neiros__application_select').select2({
  placeholder: 'Выбрать тему обращения',
  minimumResultsForSearch: -1
});


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

$('#neiros__tab_callback_day').ddslick({
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
});
$('#neiros__tab_callback_time').ddslick({
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
});


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
$( window ).resize(function() {
		list = document.querySelector("#neiros__talk_chat_box .neiros__talk_chat");
 	list.scrollTop = list.scrollHeight;
	
	})



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
	}

	}
	
	
	
if(params['mobile']){

	}	

	
</script>

</body>
</html>