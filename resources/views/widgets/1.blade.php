<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Чат</title>
    <link href="css/timepicki.css" rel="stylesheet" type="text/css">
    <link href="css/datepicker.min.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="css/style_call.css" rel="stylesheet" type="text/css">
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/jquery.inputmask.js"></script>
    <script src="js/jquery.ddslick.min.js"></script>
    <script src="js/datepicker.min.js"></script>
    <script src="js/timepicki.js"></script>
</head>

<body>






<div id="neiros__panel_widget" class="" >
    <div class="neiros__header_pop">

        <div id="neiros__header_phone">+7 800 555 33 55</div>

        <div id="neiros__header_show_operator" style="display:none;">

            <img src="images/agent.png" class="neiros__operator">
            <div class="neiros__operator-text">
                <span>Александр</span>
                Консультант
                <div class="neiros__status_operator neiros__op_active"></div>
                <div id="neiros__proces_writen_operator" style="display:none;"><img src="images/icons/icon-pancil.png" alt=""> Печатает ...</div>
            </div>
        </div>

    </div>
    <div class="neiros__all-servises">
        <ul>
            <li class="neiros__servis-phone"><img src="images/icons/icon-phone.png"></li>
            <li class="neiros__servis-chat neiros__active_servis"><img src="images/icons/icon-chat.png"></li>
            <li class="neiros__servis-lid"><img src="images/icons/icon-lid.png"></li>
            <li class="neiros__servis-geo"><img src="images/icons/icon-geo.png"></li>
            <li class="neiros__servis-socialpng"><img src="images/icons/icon-socialpng.png"></li>
        </ul>
    </div>

    <div id="neiros__tab_chart" class="neiros__tab active">
        <div  id="neiros__talk_chat_box">
            <div class="neiros__talk_chat">
                <div class="neiros__talk_day">
                    <div id="neiros__operator_start_dialog">
                        <img src="images/agent.png" class="neiros__operator_start">
                        <div class="neiros__operator-text">
                            <div id="neiros__status_operator_of_dialog"><div class="neiros__status_operator neiros__op_active"></div> Онлайн</div>
                            <span>Александр</span>
                            Консультант

                        </div>
                    </div>
                    <div id="neiros__operator_text_dialog">
                        Добрый день, меня зовут Александр.
                        Буду рад вам помочь! Спросите меня о
                        чем-нибудь :)
                    </div>

                </div>
            </div>
        </div>

        <div class="neiros__send--chart-form">
            <textarea maxlength="1000"  autocomplete="off"  id="neiros__send--chart-form-input" placeholder="Ваше сообщение"></textarea>
            <div id="neiros__send--chart-form_btn"></div>
        </div>
    </div>

    <div id="neiros__tab_callback" class="neiros__tab">
        <div class="neiros__callback_container">

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

        </div>
        <div class="neiros__copyright">
            <div class="squaredTwo">
                <input type="checkbox" value="None" id="squaredTwo" name="check" checked />
                <label for="squaredTwo"></label>
            </div>
            <div>Согласен на обработку персональных данных</div>
        </div>

    </div>


</div>

<script>
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

    $('.neiros__all-servises li').on('click', function(){
        $('.neiros__all-servises li').removeClass('neiros__active_servis');
        $(this).addClass('neiros__active_servis');
        className=$(this).attr('class');
        $('.neiros__tab').removeClass('active');
        if(className.indexOf("neiros__servis-phone") >= 0){
            $('#neiros__tab_callback').addClass('active');
        }
        if(className.indexOf("neiros__servis-chat") >= 0){
            $('#neiros__tab_chart').addClass('active');
        }


    })
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

    /*Отправить сообщение в чат пользователем*/
    mass.forEach.call( document.querySelectorAll('#neiros__send--chart-form_btn'), function(el) { el.addEventListener('click', function() {
        list = document.querySelector("#neiros__send--chart-form-input");
        var val = list.value;
        add_comment(val,list);


    }, false);
    })

    document.querySelector('#neiros__send--chart-form-input').addEventListener('keydown', function(e) {

        /*Оператор печатает запуск*/
        list = document.querySelector("#neiros__proces_writen_operator");
        if (e.keyCode) {
            list.style.display = 'block';
        }

        if (e.keyCode === 13) {
            list = document.querySelector("#neiros__send--chart-form-input");
            var val = list.value;
            add_comment(val,list);
        }
    });


    /*Считывание введенного текста пользователем*/
    function add_comment(val,list){
        if(val === ''){
            return false;}
        else{
            var now = new Date();
            time = now.getHours()+':'+now.getMinutes()
            list.value = '';
            list = document.querySelector("#neiros__header_phone");
            list.style.display = 'none';
            list = document.querySelector("#neiros__header_show_operator");
            list.style.display = 'block';

            list = document.querySelector("#neiros__talk_chat_box .neiros__talk_chat .neiros__talk_day");
            list.innerHTML = '<div class="neiros__talk_this_day"><div class="neiros__talk_currend_day">21.06.2018г.</div><div class="neiros__talk_text_operator_block"><div class="neiros__talk_text_operator"><div class="neiros__talk_time_comment">21:18</div>Добрый день, меня зовут Александр.Буду рад вам помочь! Спросите меня о чем-нибудь :)</div></div><div class="neiros__talk_text_client_block"><div class="neiros__talk_text_client"><div class="neiros__talk_time_comment">21:18</div>Добрый день, меня зовут Александр.Буду рад вам помочь! Спросите меня очем-нибудь :)</div></div><div class="neiros__day_end"></div></div><div class="neiros__talk_this_day"><div class="neiros__talk_currend_day">22.06.2018г.</div><div class="neiros__talk_text_operator_block"><div class="neiros__talk_text_operator"><div class="neiros__talk_time_comment">21:18</div>Добрый день, меня зовут Александр.Буду рад вам помочь! Спросите меня о чем-нибудь :)</div></div><div class="neiros__talk_text_client_block"><div class="neiros__talk_text_client"><div class="neiros__talk_time_comment">'+time+'</div>'+val+'</div></div></div>';
            /*Оператор печатает убрать*/
            list = document.querySelector("#neiros__proces_writen_operator");
            list.style.display = 'none';
            list = document.querySelector("#neiros__talk_chat_box .neiros__talk_chat");
            list.scrollTop = list.scrollHeight;

        }
    }


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

    if(params['mobile']){
        /*	list = document.querySelector("#neiros__panel_widget .neiros__all-servises");
            list.style.display = 'none';*/
        list = document.querySelector(".neiros__talk_chat");
        classes = list.classList;
        classes.add("mobile");
        list = document.querySelector(".neiros__send--chart-form");
        classes = list.classList;
        classes.add("mobile");
        list = document.querySelector(".neiros__send--chart-form textarea");
        classes = list.classList;
        classes.add("mobile");
        list = document.querySelector("#neiros__send--chart-form_btn");
        classes = list.classList;
        classes.add("mobile");
        list = document.querySelector("#neiros__send--chart-form_btn");
        classes = list.classList;
        classes.add("mobile");
    }


</script>

</body>
</html>