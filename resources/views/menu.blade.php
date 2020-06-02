<div class="sidebar-category sidebar-category-visible">
    <div class="category-content no-padding">
        <ul class="navigation navigation-main navigation-accordion">


            <li><a href="/"><i class="fa fa-pie-chart" aria-hidden="true"></i><span><b>Дашборд</b></span></a></li>
            <li><a href="/projects"><i class="fa fa-user" aria-hidden="true"></i><span><b class="sdelki">Сделки{!! $globalsetting->getNewProject()!!}</b></span></a></li>

            <li class="hidden-fo-fixed hidden-fo-fixed-6"><a href="/widget/tip/2" class="sidebar-secondary-hide" data-settings="colltrecing" ><i class="fa fa-phone" aria-hidden="true"></i><span><b>Коллтрекинг</b></span></a></li>


            {{--Коллтрекинг--}}

 


            {{--Аналитика--}}
            <li class="hidden-fo-fixed hidden-fo-fixed-3">
                <a href="/allreports" class="sidebar-secondary-hide" data-settings="analytics" ><i class="fa fa-line-chart" aria-hidden="true"></i><span><b>Аналитика</b></span></a>
             <?php /*?>  <a href="/allnewreports"><i class="fa fa-line-chart" aria-hidden="true"></i> <span>Нейрос метки </span></a><?php */?>

            </li>
            {{--Коммуникации--}}
            <li>
                <a href="/widget/tip/12"><i class="fa fa-cube" aria-hidden="true"></i><span><b>Виджеты</b></span></a>

            </li>
            <li class="hidden-fo-fixed hidden-fo-fixed-2">
                <a href="/widgetchat"><i class="fa fa-commenting-o" aria-hidden="true"></i><span id="count_ness"><b class="sdelki">Диалоги{!! $globalsetting->getNewChat()!!}</b></span></a>

            </li>
            {{--Интеграции--}}

            <li class="hidden-fo-fixed hidden-fo-fixed-1">
                <a href="/widget/tip/9"><i class="fa fa-envelope-o" aria-hidden="true"></i><span><b>E-mail Трекинг</b></span></a>

            </li>

			<li class="insert-hidden-widget" style="display:none">
           
            <a ><i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i><span><b></b></span></a>
            </li>
            <hr>
            <li>
                <a href="/widget/tip/10"><i class="fa fa-plug" aria-hidden="true"></i><span><b>Интеграции</b></span></a>

            </li>


            {{--<li><a href="/widget"><i class="icon-home4"></i><span><b>Виджеты</b></span></a></li>--}}
            
<?php /*?>            
            
            <li><a href="/setting/advertisingchannel"><i class="icon-home4"></i><span><b>Рекламные каналы</b></span></a></li><?php */?>

            @if(Auth::user()->role==0)
                <li> <a class="sidebar-secondary-hide sidebar-secondary-hide-setings" data-settings="settings" ><i class="fa fa-cogs" aria-hidden="true"></i><span><b>Настройки</b></span></a>
                    <?php /*?><ul>
                        <li><a href="/setting/paycompanys">Платежные профили</a></li>
                        <li><a href="/setting/checkcompanys">Счета на оплату</a></li>
                        <li><a href="/setting/billing/phones">Стоимость номеров</a></li>
                        <li><a href="/setting/billing/recs">Стоимость разговоров</a></li>


                        <li><a href="/setting/clientfield">Доп поля контактов</a></li>
                        <li><a href="/setting/companyfield">Доп поля компаний</a></li>
                        <li><a href="/setting/users">Пользователи</a></li>
                        <li><a href="/setting/sites">Сайты</a></li>

                    </ul><?php */?>
                </li>
            @endif
            @if(Auth::user()->super_admin==1)
                <li>


                <li><a href="/setting/adminclient"><i class="icon-home4"></i><span><b>Администрирование</b></span></a></li>
                <li><a href="/setting/bots"><i class="icon-home4"></i><span><b>Поисковые боты</b></span></a></li>
                <li><a href="/setting/tarifs"><i class="fa fa-money" aria-hidden="true"></i><span><b>Тарифы1</b></span></a></li>
                <li><a href="/setting/admintm"><i class="fa fa-envelope-open-o" aria-hidden="true"></i><span><b>Шаблоны Писем</b></span></a></li>

            @endif


                <li class=" hidden-xs sidebar-control sidebar-main-toggle sidebar-main-toggle-menu" ><a href="#"><i class="fa fa-angle-right  hidden-xs" > </i><span><b>Свернуть</b></span></a>
                </li>
        </ul>
    </div>
    </div>
    
   

 <script>
$('.sidebar-control.sidebar-main-toggle').click(function(e){
var bod_class = $("body").attr("class");
var sermystr = bod_class.indexOf("sidebar-xs");
if(sermystr == -1){
	localStorage.setItem("menu", 'sidebar-xs');
	 $('body .sidebar-main-toggle i').removeClass('fa-angle-left');
	$('body .sidebar-main-toggle i').addClass('fa-angle-right');

	console.log('-1')
	}
 else {
	 console.log('1')
	$('body .sidebar-main-toggle i').removeClass('fa-angle-right');
	$('body .sidebar-main-toggle i').addClass('fa-angle-left');
	 localStorage.setItem("menu", '');
	 }
});

var mystr = localStorage.getItem("menu");
if (mystr == null){}
else{
var serch_class = mystr.indexOf("sidebar-xs");
if(serch_class == -1){
	$("body").removeClass('sidebar-xs');
	$('body .sidebar-main-toggle i').removeClass('fa-angle-right');
	$('body .sidebar-main-toggle i').addClass('fa-angle-left');
	}
else {
$("body").addClass('sidebar-xs');
$('body .sidebar-main-toggle i').removeClass('fa-angle-left');
$('body .sidebar-main-toggle i').addClass('fa-angle-right');
}
}

$('.settings-sidebar').on('click', function(){
	
	
	
	})


    var url=document.location.href;
	arr = url.split('https://cloud.neiros.ru');
	check_url = 0;
	if(arr[1] === '/setting/paycompanys' || arr[1] === '/setting/checkcompanys' || arr[1] === '/setting/billing/phones' || arr[1] === '/setting/billing/recs' || arr[1] === '/setting/clientfield' || arr[1] === '/setting/companyfield'  || arr[1] === '/setting/users'  || arr[1] === '/setting/sites'){
	
		$('body').removeClass('sidebar-secondary-hidden');
		function explode(){
			$('.settings').css('display','block');
		}
		setTimeout(explode, 100)
	
		check_url = 1;
		}

						
	if(arr[1] === '/widget/tip/2'){
			$('body').removeClass('sidebar-secondary-hidden');
		function explode(){
			$('.colltrecing').css('display','block');
		}
		setTimeout(explode, 100)
		
		}					
		if(arr[1] === '/allreports'){
			$('body').removeClass('sidebar-secondary-hidden');
		function explode(){
			$('.analytics').css('display','block');
		}
		setTimeout(explode, 100)
		
		}						
						
						
	
	
    $.each($('.navigation.navigation-main  li'),function(){

	if(check_url === 1){
		if($(this).find('a').hasClass("sidebar-secondary-hide-setings")){
			$(this).addClass('active');
			
			}
		
		
		}

	if(arr[1] == ''){
	if($(this).find('a').attr('href')==url){
		$(this).addClass('active');
		};	
	}
	else {
		if (typeof $(this).find('a').attr('href') === "undefined") {}
		else{
		var str1 = $(this).find('a').attr('href').indexOf(arr[1]);	
	
	
    if($(this).find('a').attr('href') == arr[1]){
		$(this).addClass('active')}}}

    });
	
function resize_sidebar(){
	
height_menu = $(".sidebar-xs .sidebar-fixed .sidebar-category-visible").height();	
sidebar_content = $(".sidebar-xs .sidebar-fixed .sidebar-content").height();
console.log(height_menu);	
console.log(sidebar_content);
if(sidebar_content < height_menu){
	razh = height_menu - sidebar_content;

	menu = '';	
	
	if (razh > 0 && razh <= 49){
		selector_menu = '.hidden-fo-fixed-6';
		
		} 
	if (razh > 49 && razh <= 98){
		selector_menu = '.hidden-fo-fixed-5, .hidden-fo-fixed-6';
		}
	if (razh > 98 && razh <= 119){
	selector_menu = '.hidden-fo-fixed-4, .hidden-fo-fixed-5, .hidden-fo-fixed-6';
		} 
	if (razh > 119 && razh <= 196){
		selector_menu = '.hidden-fo-fixed-3, .hidden-fo-fixed-4, .hidden-fo-fixed-5, .hidden-fo-fixed-6';
		} 	
     if (razh > 147 && razh <= 213){
		selector_menu = '.hidden-fo-fixed-2, .hidden-fo-fixed-3, .hidden-fo-fixed-4, .hidden-fo-fixed-5, .hidden-fo-fixed-6';
		} 
	 if (razh > 213){
		selector_menu = '.hidden-fo-fixed';
		} 					 	
	
    ModalArray=$(selector_menu);
	$(selector_menu).css('display','none');

			ModalArray.each(function(){
				menu = menu+""+$(this).html()+"";
		});	
	$('.sidebar-main-toggle-menu b').html('Развернуть');	
    $('.insert-hidden-widget a span').html(menu)
	$('.insert-hidden-widget').css('display','block');
	}
	else{
		$('.hidden-fo-fixed').css('display','block');
		$('.insert-hidden-widget').css('display','none');
		$('.sidebar-main-toggle-menu b').html('Свернуть');	
		$('.sidebar-category.sidebar-category-visible').scrollTop(0);
		$('.sidebar-fixed .sidebar-content').scrollTop(0);
		}
	
	}	
	
resize_sidebar()

$('.sidebar-main-toggle').on('click', function(){

	setTimeout(resize_sidebar, 10);
	
	})	


		
		
		  
</script>