@inject('globalsetting', 'App\Http\Controllers\IndexController')

        <!DOCTYPE html>
<html lang="en">
<head>
    <script>var my_company_id={{Auth::user()->my_company_id}}</script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script  type="module"  src="/js/app.js"></script>

    <META HTTP-EQUIV="Access-Control-Allow-Origin" CONTENT="https://chat.neiros.ru">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Neiros - @yield('title')</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="/global_assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="/default/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <link href="/default/assets/css/core.min.css" rel="stylesheet" type="text/css">
    <link href="/default/assets/css/components.min.css" rel="stylesheet" type="text/css">
    <link href="/default/assets/css/colors.min.css" rel="stylesheet" type="text/css">
    <link href="/css/jquery.floatingscroll.css" rel="stylesheet" type="text/css">
    <link href="/css/main.css" rel="stylesheet" type="text/css">
     <link href="/css/floatingscroll-demo.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <link href="/global_assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="/global_assets/css/icons/material/icons.css" rel="stylesheet" type="text/css">
    <!-- Core JS files -->
    <script src="/global_assets/js/core/libraries/jquery.min.js"></script>
    
        <script type="text/javascript" src="/js/jquery-ui-1.10.4.min.js"></script>
    <script src="/global_assets/js/core/libraries/bootstrap.min.js"></script>
    <!-- /core JS files -->
    <script src="/global_assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- Theme JS files -->
    <script src="/js/app__1.js"></script>


   {{-- <script src="/global_assets/js/plugins/ui/ripple.min.js"></script>--}}
    <script src="/global_assets/js/plugins/notifications/pnotify.min.js"></script>
    <!-- /theme JS files -->


    <script src="https://use.fontawesome.com/7c8f9239c1.js"></script>


    {{--    <script type="text/javascript" src="/default/assets/js/plugins/forms/styling/switchery.min.js"></script>--}}
    <script type="text/javascript" src="/default/assets/js/plugins/forms/styling/switch.min.js"></script>
    {{-- <script type="text/javascript" src="/default/assets/js/pages/appearance_draggable_panels.js"></script>--}}
    <script type="text/javascript" src="/default/assets/js/plugins/notifications/jgrowl.min.js"></script>
     <script type="text/javascript" src="/js/jquery.floatingscroll.min.js"></script>
    <script src="/cdn/v1/catch_lead/js/jquery.inputmask.js"></script>
	
    @yield('newjs', '')
</head>
{{--<a href="
viber://pa?chatURI=wististest&context=text2">Вибер</a>
<body class="pace-done">--}}
<body class="sidebar-secondary-hidden pace-done has-detached-left sidebar-xs">
{{--sidebar-xs  --}}


@include('main_navbar')


<!-- /main navbar -->


<!-- Page container -->
<div class="page-container"  >

    <!-- Page content -->
    <div class="page-content" style="height: 100vh;">

        <!-- Main sidebar -->
        <div class="sidebar sidebar-main  sidebar-fixed">
            <div class="sidebar-content">


                <!-- /user menu -->


                <!-- Main navigation -->
@if(auth()->user()->grouproles_prov(0))
            @include('menu')
@elseif(auth()->user()->grouproles_prov(1))
                    @include('menu_manager')
                @endif
            </div>
        </div>
        <!-- /main sidebar -->
        @include('secondary_sitebar2')

        <!-- Main content -->
        <div class="content-wrapper">
            <!-- Content area --><div class="hidenmodal"></div>
            <div class="content" style="margin-top: 50px !important;">

            @yield('content')

            <!-- Footer -->
                <div class="footer text-muted">

                </div>
                <!-- /footer -->

            </div>
            <!-- /content area -->
        </div>
        <!-- /main content -->


    </div>
    <!-- /page content -->
    <?php /*?><div id="WidgetModal2" class="modal WidgetModalNew fade ClientInfoModal lids-neiros">
        <div class="modal-dialog" >
            <div class="modal-content"  style="height: 100vh">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >×</button>
                </div>
                <div class="modal-body" style="height: 100%;">
<div class="name-block-fixed" style="display: block;">
                        <div class="col-xs-12"><div class="h1-modal pos-left">Настройки  <span>Виджета квиз</span></div>

                            <button type="button" class="btn btn-primary widget-status-btn" data-id="" style="display: none;">Подключить</button>
                        </div>
                                            </div>

                    <div class="col-xs-12 block-descr">
                        <div class="col-sm-6 col-xs-12 text-center"><div class="img-block-left"><img  src=""></div></div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="paragraph">Яндекс Метрика — бесплатный интернет-сервис компании Яндекс, предназначенный для оценки посещаемости веб-сайтов, и анализа поведения пользователей. На данный момент Яндекс.Метрика является третьей по размеру системой веб-аналитики в Европе.</div>






                            <button type="button" class="btn btn-primary set_status widget_status_checkbox"  >Подключить</button>


                        </div>

                    </div>


                    <div class="col-xs-12 accordion-setings" style="display: block; margin-top: 20px;">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true"><style>
                                #block_2, #block_1, #block_0 {

                                    display: none;
                                }


                            </style>



                        </div>

                    </div>


                </div>



            </div>


        <!-- Футер модального окна -->

        </div>
    </div><?php */?>
    <div id="WidgetModal2" class="modal WidgetModalNew fade ClientInfoModal lids-neiros">
        <div class="modal-dialog" >
            <div class="modal-content"  style="height: 100vh">
                <!-- Заголовок модального окна -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >×</button>
                </div>
                <!-- Основное содержимое модального окна -->
                <div class="modal-body" style="height: 100%;">
<div class="name-block-fixed" style="display: block;">
                        <div class="col-xs-12"><div class="h1-modal pos-left">Настройки  <span>Виджета квиз</span></div>

                            <button type="button" class="btn btn-primary widget-status-btn" data-id="" style="display: none;">Подключить</button>
                        </div>
                                            </div>

                    <div class="col-xs-12 block-descr">
                        <div class="col-sm-6 col-xs-12 text-center"><div class="img-block-left"><img  src=""></div></div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="paragraph">Яндекс Метрика — бесплатный интернет-сервис компании Яндекс, предназначенный для оценки посещаемости веб-сайтов, и анализа поведения пользователей. На данный момент Яндекс.Метрика является третьей по размеру системой веб-аналитики в Европе.</div>






                            <button type="button" class="btn btn-primary set_status widget_status_checkbox"  >Подключить</button>


                        </div>

                    </div>


                    <div class="col-xs-12 accordion-setings" style="display: block; margin-top: 20px;">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true"><style>
                                #block_2, #block_1, #block_0 {

                                    display: none;
                                }


                            </style>
                            
                             <div class="panel panel-default new-panel-default">
                            
                            
                                                            <div class="panel-heading" role="tab" id="heading_kviz_1">
                                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_kviz_1" aria-expanded="false" aria-controls="collapse_kviz_1">
                                                                    <div class="number-accardion"><img src="/global_assets/images/icon_kviz/start-page.svg"></div>
                                                                    <div class="h-1">Стартовая страница</div>
                                                                    <div class="descr-text">Какое-то краткое краткое описание</div><span class="switchery-xs-new" style="position: absolute;left: 360px;top: 28px;"><input checked type="checkbox" class="js-switch" data-id=""></span>
                                                                </a>
                                                            </div>
                            
                            
                                                            <div id="collapse_kviz_1" class="panel-collapse collapse" role="tabpane1" aria-labelledby="heading_kviz_1" aria-expanded="false" style="height: 0px;">
                            
                                                              
                            
                            
                                                                    <div class="panel-body" style="padding-top:0px">
                            
                                                                       	  <div class="cont-btn-content col-xs-12" style="padding-top: 0px;">
                 <div class="tab-content-block active start-page-kviz">
                 
                 <div class="">
                 <label>Заголовок</label>
                 <input type="text" class="form-control form-control-text" placeholder="Ответь на 5 вопросов и узнай, какой тариф тебе подходит" name="" value="">
                 </div>
                 
                 <div class="text-panel-blok-kviz">
                                        <label>Подзаголовок</label>
                                        <textarea class="" placeholder="В конце текста бонус и скидка"></textarea>
                                    </div>
                                    
                <div class="">
                 <label>Текст кнопки</label>
                 <input type="text" class="form-control form-control-text" placeholder="Отправить" name="" value="">
                 </div>                     
                                    
             
                 
              </div> 
                </div>
         <div class="banel-body-footer">
              <button type="button" class="btn btn-primary save-setings   ">Сохранить</button>
         </div>                  
                            
                            
                                                            </div>
                                                        </div>

</div>

<div class="panel panel-default new-panel-default">


                                <div class="panel-heading" role="tab" id="heading-kviz-2">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-kviz-2" aria-expanded="false" aria-controls="collapse-kviz-2">
                                        <div class="number-accardion"><img src="/global_assets/images/icon_kviz/nastroika-etapov.svg"></div>
                                        <div class="h-1">Настройка этапов</div>
                                        <div class="descr-text">Какое-то краткое краткое описание</div>
                                    </a>
                                </div>


                                <div id="collapse-kviz-2" class="panel-collapse collapse" role="tabpane1" aria-labelledby="heading-kviz-2" aria-expanded="false" style="height: 0px;">

                                  


                                        <div class="panel-body" style="padding-top:0px">

                                            <div class="cont-btn-content col-xs-12" style="padding-top: 0px;">
                                                <div class="tab-content-block active">
                                                
                                                
                                                
                                                
                                                
                                                   

                                                    <div class="all_time_block">
                                                    </div>
<div id="sortable-panel-otobragenie">
         <div class="panel-otobragenie col-xs-12">
           <form name="formawork">
                                        <input type="hidden" name="form_action" value="formawork_2">
                                        <input type="hidden" name="widget" value="597">
                                        <input type="hidden" name="my_company_id" value="20">
              <div class="panel-header">
                   <div class="block-header block-header-1"><img src="/global_assets/images/icon_chat/menu_gray.svg"></div>
                   <div class="block-header block-header-2"><span class="insert-img-text-k"> <span class="text__header">Выберите тип вопроса</span></span><span class="switchery-xs-new"><input checked type="checkbox" class="js-switch" data-id=""></span></div>
                   <div class="block-header block-header-3 active"><img src="/images/icon/chat/3.png"></div>
                    <div class="block-header block-header-4"><img src="/global_assets/images/icon_chat/file_gray.svg"></div>
                     <div class="block-header block-header-5 no-delete"><img src="/global_assets/images/icon/user/trash.svg"></div>
                   
                   
               </div>
               
               <div class="panel-body-panel col-xs-12 start-page-kviz" style="display: block;">
               		
                 <div class="kviz-vibor-start-step">
                       <div class="item-kviz col-sm-3" data-id="1"> 
                       	<div class="item-container no-active ">
                            <div class="image-block">
                                    <img src="/global_assets/images/icon_kviz/vibor-varianta-big/1.png">
                            </div>
                            <div class="name-block">
                                <div>Варианты ответов</div>
                            </div>
                            </div>
                       </div>
                       
                       
                        <div class="item-kviz col-sm-3" data-id="2">
                       	<div class="item-container no-active ">
                            <div class="image-block">
                                    <img src="/global_assets/images/icon_kviz/vibor-varianta-big/2.png">
                            </div>
                            <div class="name-block">
                                <div>Варианты с картинками</div>
                            </div>
                            </div>
                       </div>
                       
                       <div class="item-kviz col-sm-3" data-id="3">
                       	<div class="item-container no-active ">
                            <div class="image-block">
                                    <img src="/global_assets/images/icon_kviz/vibor-varianta-big/3.png">
                            </div>
                            <div class="name-block">
                                <div>Варианты и картинка</div>
                            </div>
                            </div>
                       </div>
                       
                                              <div class="item-kviz col-sm-3" data-id="4">
                       	<div class="item-container no-active ">
                            <div class="image-block">
                                    <img src="/global_assets/images/icon_kviz/vibor-varianta-big/4.png">
                            </div>
                            <div class="name-block">
                                <div>Свое поле для ввода</div>
                            </div>
                            </div>
                       </div>
                       
                    <div class="item-kviz col-sm-3" data-id="5">
                       	<div class="item-container no-active ">
                            <div class="image-block">
                                    <img src="/global_assets/images/icon_kviz/vibor-varianta-big/5.png">
                            </div>
                            <div class="name-block">
                                <div>Выпадающий список</div>
                            </div>
                            </div>
                       </div>
               <div class="item-kviz col-sm-3" data-id="6">
                       	<div class="item-container no-active ">
                            <div class="image-block">
                                    <img src="/global_assets/images/icon_kviz/vibor-varianta-big/6.png">
                            </div>
                            <div class="name-block">
                                <div>Дата</div>
                            </div>
                            </div>
                       </div>       
                    <div class="item-kviz col-sm-3" data-id="7">
                       	<div class="item-container no-active ">
                            <div class="image-block">
                                    <img src="/global_assets/images/icon_kviz/vibor-varianta-big/7.png">
                            </div>
                            <div class="name-block">
                                <div>Ползунок</div>
                            </div>
                            </div>
                       </div>                  
                      
                        <div class="item-kviz col-sm-3" data-id="7">
                       	<div class="item-container no-active ">
                            <div class="image-block">
                                    <img src="/global_assets/images/icon_kviz/vibor-varianta-big/8.png">
                            </div>
                            <div class="name-block">
                                <div>Загрузка файла</div>
                            </div>
                            </div>
                       </div>     
                      
                      
                       
                       </div>   
                    
                    
                    
				<div class="kviz-input-block">
                 <label>Вопрос</label>
                 <input type="text" class="form-control form-control-text" placeholder="" name="" value="">
                 </div>
               
               			<div class="text-panel-blok-kviz text-panel-blok">
                        <label>Текст сообщения</label>
                        <textarea class=""></textarea>
                        </div>
                        
               <div class="text-h1-fo-select-panel text-h1-fo-select-panel-kviz">Тип вопроса</div>         
                         <div class="pravilo-block pravilo-block-kviz col-xs-12">          
                        <div  class="select-panel-blok col-xs-12" >
				
    <div class="dropdown add-user-new add-number-new select-panel-blok-input">
            <button  class="btn btn-success" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Выберите тип опроса</button>
             <ul class="dropdown-menu"  aria-labelledby="dLabel">

                 <li class="t_k t_k_1" data-img="1"><label class="add-number-new-checkbox">Варианты ответов<input value="var-otvetov" type="checkbox" ><span class="checkmark"></span></label></li>
                 <li class="t_k t_k_2" data-img="2"><label class="add-number-new-checkbox">Варианты с картинками<input value="var-s-kartinami" type="checkbox" ><span class="checkmark"></span></label></li>
           		<li class="t_k t_k_3" data-img="3"><label class="add-number-new-checkbox">Варианты и картинка<input value="var-i-kartinka" type="checkbox" ><span class="checkmark"></span></label></li>  
                  <li class="t_k t_k_4" data-img="4"><label class="add-number-new-checkbox">Свое поле для ввода<input value="pole-dlya-vvoda" type="checkbox" ><span class="checkmark"></span></label></li>  
                 <li class="t_k t_k_5" data-img="5"><label class="add-number-new-checkbox">Выпадающий список<input value="vipadayshii-spisok" type="checkbox" ><span class="checkmark"></span></label></li>  
                  <li class="t_k t_k_6" data-img="6"><label class="add-number-new-checkbox">Дата<input value="data" type="checkbox" ><span class="checkmark"></span></label></li>  
                   <li class="t_k t_k_7" data-img="7"><label class="add-number-new-checkbox">Ползунок<input value="polzynok" type="checkbox" ><span class="checkmark"></span></label></li>    
                  <li class="t_k t_k_8" data-img="8"><label class="add-number-new-checkbox">Загрузка файлов<input value="time-page" type="checkbox" ><span class="checkmark"></span></label></li>          
             </ul>
    </div>
     
                                           
                                            
                    </div>
                    </div> 
                <div class="kviz-block-fo-voprosi-all">    
                  <div class="kviz-input-block col-xs-12 kviz-input-block-vopros">
                 <input type="text" class="form-control form-control-text" placeholder="Введите текст варианта ответа" name="" value=""><img class="delete-vopros-kviz" src="/global_assets/images/icon_kviz/trash.svg">
                 </div>       
                   </div>     
                        
                             <div class="col-xs-12 add_sourse_block">
                                                        <div class="add_sourse add_time_call" data-variant="1" id="add_variant">
                                                            <div class="cont__left">+</div>
                                                            <div class="cont_right">Добавить Вариант</div>
                                                        </div>
                                                    </div>
                      <div class="col-xs-12 footer-kviz-block-type">                              
                         <div class="col-xs-6 block-kviz-f-1">   <label class="add-number-new-checkbox">Можно несколько
                                                            <input type="checkbox" name="ar_number[]" value="Несколько" checked="">
                                                            <span class="checkmark"></span>
                              </label>  
                             </div>
                           <div class="col-xs-6 block-kviz-f-2">   
                             <label class="add-number-new-checkbox">Необязательный вопрос
                                                            <input type="checkbox" name="ar_number[]" value="Необязательный вопрос" >
                                                            <span class="checkmark"></span>
                              </label>                             
                           </div>
                           
                                                    
                </div>                                    
                                                    
               
                                                        <div class="banel-body-footer">
                                                <button type="button" class="btn btn-primary save-setings2   ">Сохранить</button>
                                            </div>
               </div>
                    </form>
         </div>
         
         
         
         
         
                                                    
                                                      </div>


                              <div class="col-xs-12 add_sourse_block add_sourse_block__chat" style=" display:none;">
                                                        <div class="add_sourse add_time_call">
                                                            <div class="cont__left">+</div>
                                                            <div class="cont_right">ДОБАВИТЬ СООБЩЕНИЕ</div>
                                                        </div>
                               </div>                            

                                                </div>


                                            </div>


   
                                        </div>

                            


                                </div>
                            </div>


                            
 <?php /*?>                           
                                   <div class="panel panel-default new-panel-default">
                            
                            
                                                            <div class="panel-heading" role="tab" id="heading__1">
                                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse__1" aria-expanded="false" aria-controls="collapse__1">
                                                                    <div class="number-accardion"><img src="/global_assets/images/icon/settings.svg"></div>
                                                                    <div class="h-1">Правила показа операторов</div>
                                                                    <div class="descr-text">Какое-то краткое краткое описание</div>
                                                                </a>
                                                            </div>
                            
                            
                                                            <div id="collapse__1" class="panel-collapse collapse" role="tabpane1" aria-labelledby="heading__1" aria-expanded="false" style="height: 0px;">
                            
                                                              
                            
                            
                                                                    <div class="panel-body" style="padding-top:0px">
                            
                                                                       	  <div class="cont-btn-content col-xs-12" style="padding-top: 0px;">
                 <div class="tab-content-block active">
                 		<div class="col-xs-12 block__esli">
                        	<div class="block__esli_1"><span>Если</span></div>
                            <div class="block__esli_text">клиент посещает страницу, адрес которой не имеет правила</div>
                        </div>
                        
                        <div class="col-xs-12 block__esli">
                        	<div class="block__esli_1"><span>То</span></div>
                             <div class="block__esli_text">маршрутизация чатов для всех операторов</div>

                        
    			 </div>
                 <div class="show-chat-operator-all">
                 <div class="show-chat-operator col-xs-12">
                <div class=" operator-select-block">
                    <div class="dropdown operator-select add-user-new add-number-new select-panel-blok-input">
            <button  class="btn btn-success" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Выберите оператора</button>
             <ul class="dropdown-menu"  aria-labelledby="dLabel">
                 <li ><label class="add-number-new-checkbox">Оператор 1<input value="time-page" type="checkbox" ><span class="checkmark"></span></label></li>
                 
                 <li ><label class="add-number-new-checkbox">Оператор 2<input value="time-page" type="checkbox" ><span class="checkmark"></span></label></li>
                 <li ><label class="add-number-new-checkbox">Оператор 3<input value="time-page" type="checkbox" ><span class="checkmark"></span></label></li>
                 <li ><label class="add-number-new-checkbox">Оператор 4<input value="time-page" type="checkbox" ><span class="checkmark"></span></label></li>
       
             </ul>
    </div>
                </div> 
                
                <div class=" operator-select-block">
                    <div class="dropdown operator-select add-user-new add-number-new select-panel-blok-input">
            <button  class="btn btn-success" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Выберите условие</button>
             <ul class="dropdown-menu"  aria-labelledby="dLabel">
                     <li ><label class="add-number-new-checkbox">содержит строку<input value="time-page" type="checkbox" ><span class="checkmark"></span></label></li>
                 <li ><label class="add-number-new-checkbox">не содержит строку<input value="time-site" type="checkbox" ><span class="checkmark"></span></label></li>
                 <li ><label class="add-number-new-checkbox">это точно<input value="url-page" type="checkbox" ><span class="checkmark"></span></label></li>
           <li ><label class="add-number-new-checkbox">не являеться<input value="return-user" type="checkbox" ><span class="checkmark"></span></label></li>    
       
             </ul>
    </div>
                </div>
                
                
                    <div class="form__block " >

                            <input type="text" class="form-control form-control-text" placeholder="" name="catch_aou" value="">
                        </div>
                        
                 <div class="delete_pravilo2"><img src="/global_assets/images/icon/user/trash.svg"></div>       
                        
                </div>
                </div>
                
                  <div class="col-xs-12 add_sourse_block">
                                                        <div class="add_sourse add_time_call" id="add_pravilo_operator" >
                                                            <div class="cont__left">+</div>
                                                            <div class="cont_right">Добавить правило</div>
                                                        </div>
                 </div>
                 
              </div> 
                </div>
         <div class="banel-body-footer">
              <button type="button" class="btn btn-primary save-setings   ">Сохранить</button>
         </div>                  
                            
                            
                                                            </div>
                                                        </div>

</div>
                     

<div class="panel panel-default new-panel-default">


                                <div class="panel-heading" role="tab" id="heading-2">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-2" aria-expanded="false" aria-controls="collapse-2">
                                        <div class="number-accardion"><img src="/global_assets/images/icon/talk.svg"></div>
                                        <div class="h-1">Приветственное сообщение</div>
                                        <div class="descr-text">Какое-то краткое краткое описание</div>
                                    </a>
                                </div>


                                <div id="collapse-2" class="panel-collapse collapse" role="tabpane1" aria-labelledby="heading-2" aria-expanded="false" style="height: 0px;">

                                  


                                        <div class="panel-body" style="padding-top:0px">

                                            <div class="cont-btn-content col-xs-12" style="padding-top: 0px;">
                                                <div class="tab-content-block active">
                                                   

                                                    <div class="all_time_block">
                                                    </div>
<div id="sortable-panel-otobragenie">
         <div class="panel-otobragenie col-xs-12">
           <form name="formawork">
                                        <input type="hidden" name="form_action" value="formawork_2">
                                        <input type="hidden" name="widget" value="597">
                                        <input type="hidden" name="my_company_id" value="20">
              <div class="panel-header">
                   <div class="block-header block-header-1"><img src="/global_assets/images/icon_chat/menu_gray.svg"></div>
                   <div class="block-header block-header-2"><img src="/images/icon/chat/2.png"> <span class="text__header">Правила отображения</span><span class="switchery-xs-new"><input checked type="checkbox" class="js-switch" data-id=""></span></div>
                   <div class="block-header block-header-3 active"><img src="/images/icon/chat/3.png"></div>
                    <div class="block-header block-header-4"><img src="/global_assets/images/icon_chat/file_gray.svg"></div>
                     <div class="block-header block-header-5 no-delete"><img src="/global_assets/images/icon/user/trash.svg"></div>
                   
                   
               </div>
               
               <div class="panel-body-panel col-xs-12" style="display: block;">
               			<div class="text-panel-blok">
                        <label>Текст сообщения</label>
                        <textarea class=""></textarea>
                        </div>
                  
                      		<div class="text-h1-fo-select-panel">Отображение приветствия, когда</div>
                     
              <div class="pravilo-container">       
                            
                  <div class="pravilo-block col-xs-12">          
                        <div  class="select-panel-blok col-sm-5" >
				
    <div class="dropdown add-user-new add-number-new select-panel-blok-input">
            <button  class="btn btn-success" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Выбрать правило</button>
             <ul class="dropdown-menu"  aria-labelledby="dLabel">
                 <li class="t__1"><label class="add-number-new-checkbox">Время на текущей странице<input value="time-page" type="checkbox" ><span class="checkmark"></span></label></li>
                 <li class="t__2"><label class="add-number-new-checkbox">Время на сайте<input value="time-site" type="checkbox" ><span class="checkmark"></span></label></li>
                 <li class="t__3"><label class="add-number-new-checkbox">Адрес текущей страницы<input value="url-page" type="checkbox" ><span class="checkmark"></span></label></li>
           <li class="t__4"><label class="add-number-new-checkbox">Повторный пользователь<input value="return-user" type="checkbox" ><span class="checkmark"></span></label></li>    
             </ul>
    </div>
     
                                           
                                            
                    </div>
                    
                    
                    
                    
                    <div class="col-sm-7 zvonok-block two-panel-result-show select-panel-blok-time time-page"  style="display:none" >
                            <div class="form__block " style="width:auto">
                                <div class="text-form-block">больше</div>
                            </div>
                            <div class="form__block " style="width:65px">

                                <input type="text" class="form-control form-control-text" placeholder="00" name="">
                            </div>

                            <div class="form__block " style="width:auto">
                                <div class="text-form-block">сек</div>
                            </div>
                        </div>
                        
                      <div class="col-sm-7 zvonok-block two-panel-result-show select-panel-blok-time url-page"  style="display:none">
    <div class="dropdown add-user-new add-number-new select-panel-blok-input">
            <button  class="btn btn-success" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">содержит строку</button>
             <ul class="dropdown-menu"  aria-labelledby="dLabel">
                 <li ><label class="add-number-new-checkbox">содержит строку<input value="time-page" type="checkbox" ><span class="checkmark"></span></label></li>
                 <li ><label class="add-number-new-checkbox">не содержит строку<input value="time-site" type="checkbox" ><span class="checkmark"></span></label></li>
                 <li ><label class="add-number-new-checkbox">это точно<input value="url-page" type="checkbox" ><span class="checkmark"></span></label></li>
           <li ><label class="add-number-new-checkbox">не являеться<input value="return-user" type="checkbox" ><span class="checkmark"></span></label></li>    
             </ul>
    </div>
    
    <div class="form__block " >

                            <input type="text" class="form-control form-control-text" placeholder="" name="catch_aou" value="">
                        </div>
    
    
    
                        </div>        
                        
                        
                 
                <div class="delete_pravilo"><img src="/global_assets/images/icon/user/trash.svg"></div>           
               </div>
               
                   </div>
                             <div class="col-xs-12 add_sourse_block">
                                                        <div class="add_sourse add_time_call" id="add_pravilo">
                                                            <div class="cont__left">+</div>
                                                            <div class="cont_right">Добавить правило</div>
                                                        </div>
                                                    </div>
               
                                                        <div class="banel-body-footer">
                                                <button type="button" class="btn btn-primary save-setings2   ">Сохранить</button>
                                            </div>
               </div>
                    </form>
         </div>
         
         
         
         
         
                                                    
                                                      </div>


                              <div class="col-xs-12 add_sourse_block add_sourse_block__chat" style=" display:none;">
                                                        <div class="add_sourse add_time_call">
                                                            <div class="cont__left">+</div>
                                                            <div class="cont_right">ДОБАВИТЬ СООБЩЕНИЕ</div>
                                                        </div>
                               </div>                            

                                                </div>


                                            </div>


   
                                        </div>

                            


                                </div>
                            </div>
                            <div class="panel panel-default new-panel-default">
    
    
                                    <div class="panel-heading" role="tab" id="heading__3">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse__3" aria-expanded="false" aria-controls="collapse__3">
                                            <div class="number-accardion"><img src="/global_assets/images/icon/settings_2.svg"></div>
                                            <div class="h-1">Маршрутизация чатов</div>
                                            <div class="descr-text">Какое-то краткое краткое описание</div>
                                        </a>
                                    </div>
    
    
                                    <div id="collapse__3" class="panel-collapse collapse" role="tabpane1" aria-labelledby="heading__3" aria-expanded="false" style="height: 0px;">
    
                                      
    		<div class="panel-body" style="padding-top:0px">
    		  <div class="cont-btn-content col-xs-12" style="padding-top: 0px;">
                 <div class="tab-content-block active">
                 		<div class="col-xs-12 block__esli">
                        	<div class="block__esli_1"><span>Если</span></div>
           <div class="block__esli_2_select" >
    <div class="dropdown ">
            <button  class="btn btn-success" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><div class="add_sourse " ><div class="cont__left">+</div><div class="cont_right">Добавить данные</div></div></button>
             <ul class="dropdown-menu"  aria-labelledby="dLabel">
                 <li ><label class="add-number-new-checkbox">Время на сайте<input value="time-page" type="checkbox" ><span class="checkmark"></span></label></li>
                 <li ><label class="add-number-new-checkbox">Время на странице<input value="time-site" type="checkbox" ><span class="checkmark"></span></label></li>
                 <li ><label class="add-number-new-checkbox">Посетил страницу<input value="url-page" type="checkbox" ><span class="checkmark"></span></label></li>
           <li ><label class="add-number-new-checkbox">Повторный пользователь<input value="return-user" type="checkbox" ><span class="checkmark"></span></label></li>    
             </ul>
    </div>
    

    
    
    
                        </div>
                            
                        <div class="block__esli_3" style="display:none;">Время на сайте</div>    
                        </div>
                        
                        <div class="col-xs-12 block__esli">
                        	<div class="block__esli_1"><span>То</span></div>
           <div class="block__esli_2_select" >
    <div class="dropdown ">
            <button  class="btn btn-success" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><div class="add_sourse " ><div class="cont__left">+</div><div class="cont_right">Добавить данные</div></div></button>
             <ul class="dropdown-menu"  aria-labelledby="dLabel">
                 <li ><label class="add-number-new-checkbox">Чат<input value="time-page" type="checkbox" ><span class="checkmark"></span></label></li>
                 <li ><label class="add-number-new-checkbox">Колбек<input value="time-site" type="checkbox" ><span class="checkmark"></span></label></li>
    
             </ul>
    </div>
    

    
    
    
                        </div>
                            
                   <div class="block__esli_3" style="display:none;">Время на сайте</div>           
                        </div>
                        
    			 </div>
              </div>	
                      <div class="banel-body-footer">
                                                <button type="button" class="btn btn-primary save-setings   ">Сохранить</button>
                                            </div> 
       
                                            </div>
    
                                
    
    
                                    </div>
                                </div><?php */?>



                        </div>

                    </div>


                </div>



            </div>


        <?php /*?><div class="modal-body infclinfo" >

            </div><?php */?>
        <!-- Футер модального окна -->

        </div>
    </div>
    
    <div id="WidgetModal" class="modal WidgetModalNew fade ClientInfoModal lids-neiros">
        <div class="modal-dialog" >
            <div class="modal-content"  style="height: 100vh">
                <!-- Заголовок модального окна -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >×</button>
                </div>
                <!-- Основное содержимое модального окна -->
                <div class="modal-body">
                    <div class="name-block-fixed">
                        <div class="col-xs-12" ><div class="h1-modal pos-left">Настройки виджета <span></span></div>

                            <button type="button" class="btn btn-primary widget-status-btn widget1-status-btn"  data-id="">Подключить</button>
                        </div>
                        <?php /*?> <div class="col-sm-7 col-xs-12" ><div class="h1-modal pos-right">Активность</div></div><?php */?>
                    </div>

                    <div class="col-xs-12 block-descr">
                        <div class="col-sm-6 col-xs-12 text-center"><div class="img-block-left"><img  src=""></div></div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="paragraph">Яндекс Метрика — бесплатный интернет-сервис компании Яндекс, предназначенный для оценки посещаемости веб-сайтов, и анализа поведения пользователей. На данный момент Яндекс.Метрика является третьей по размеру системой веб-аналитики в Европе.</div>






                            <button type="button" class="btn btn-primary  widget_status_checkbox2"  >Подключить</button>


                        </div>

                    </div>


                    <div class="col-xs-12 accordion-setings">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">







                        </div>

                    </div>


                </div>



            </div>


        <?php /*?><div class="modal-body infclinfo" >

            </div><?php */?>
        <!-- Футер модального окна -->

        </div>
    </div>
    <div id="WidgetModal4" class="modal fade ClientInfoModal lids-neiros integration___modal WidgetModal WidgetModalNew">
        <div class="modal-dialog" >
            <div class="modal-content"  style="height: 100vh">
                <!-- Заголовок модального окна -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >×</button>
                </div>
                <!-- Основное содержимое модального окна -->
                <div class="modal-body">
					<div class="name-block-fixed name-block-fixed-integration">
           <div class="col-xs-12" >
           <div class="h1-modal pos-left"><span class="insert-h1">Настройки виджета </span></div>
           
           
           </div>
            </div>
				
                    <div class="col-xs-12 block-descr">
							
                    </div>


		


                </div>



            </div>


        <?php /*?><div class="modal-body infclinfo" >

            </div><?php */?>
        <!-- Футер модального окна -->

        </div>
    </div>
</div>@yield('my_modal' )




<div class="result__div" style="display:none"></div>
 <script>
 
 /*Kviz*/

$(document).on('change','.file-block input',function(){
	if($(this).val() != ''){
	$(this).closest('.file-block').find('label').addClass('active');}
	else{
		$(this).closest('.file-block').find('label').removeClass('active');
		}
	})


   function parent_select_panel(event,obj){
	  event.preventDefault();
		
	  $(obj).closest('.select-panel-blok').find('li').prop('checked', false);
	  $(obj).closest('.select-panel-blok').find('li input').prop('checked', false);

	 
	  
	    $('input', obj).prop('checked', true);
	  $(obj).closest('.select-panel-blok').find('li').removeClass('active');
		$(obj).addClass('active');
		if($(obj).is('.t_k')){
			id = $(obj).attr('data-img');
			text = $('label',obj).text()
			$(obj).closest('.panel-otobragenie').find('.panel-header .block-header-2 .insert-img-text-k').html('<img src="/global_assets/images/icon_kviz/vibor-varianta/t_k_'+id+'.png"><span class="text__header">'+text+'</span>')
			$(obj).closest('.select-panel-blok-input').find('.btn-success').html('<img src="/global_assets/images/icon_kviz/vibor-varianta/t_k_'+id+'.png"> '+text)
			$(obj).closest('.panel-body-panel').find('#add_variant').attr('data-variant',id);
			
			if(id === '1' || id === '3'){
				$(obj).closest('.panel-body-panel').find('.kviz-block-fo-voprosi-all').html(`<div class="kviz-input-block col-xs-12 kviz-input-block-vopros">
                 <input type="text" class="form-control form-control-text" placeholder="Введите текст варианта ответа" name="" value=""><img class="delete-vopros-kviz" src="/global_assets/images/icon_kviz/trash.svg">
                 </div> 
	 `);
				}
				
			if(id === '2'){
				$(obj).closest('.panel-body-panel').find('.kviz-block-fo-voprosi-all').html(`<div class="kviz-input-block col-xs-12 kviz-input-block-vopros kviz-input-block-vopros-file"><div class="file-block"><input type="file" name="file-1[]" id="file-`+id+`" 
					  />
				<label for="file-`+id+`"><img src="/global_assets/images/icon_kviz/load-img.svg">
				</label></div>
                 <input type="text" class="form-control form-control-text" placeholder="Введите текст варианта ответа" name="" value=""><img class="delete-vopros-kviz" src="/global_assets/images/icon_kviz/trash.svg">
                 </div> 
	 `);}		
			
			
			
			}
			else{
				
				
		$(obj).closest('.select-panel-blok-input').find('.btn-success').html($('label',obj).text())
	 
	 
	 
	 val = $('input',obj).val();
	 $(obj).closest('.pravilo-block').find('.two-panel-result-show').css('display','none')
	 if(val === 'time-page' || val === 'time-site'){
		 $(obj).closest('.pravilo-block').find('.time-page').css('display','block')
		 }
		 
		 if(val === 'url-page'){
			 $(obj).closest('.pravilo-block').find('.url-page').css('display','block')
			 }	 
		 
		 
	}
	 
	  
	  }
	  
	  
	  
 $(document).on('click','#add_variant',function(){
	variant =  $(this).attr('data-variant');
	Rand =	Date.now()
	 if(variant === '1' || variant === '3'){
	 $('.kviz-block-fo-voprosi-all').append(`<div class="kviz-input-block col-xs-12 kviz-input-block-vopros">
                 <input type="text" class="form-control form-control-text" placeholder="Введите текст варианта ответа" name="" value=""><img class="delete-vopros-kviz" src="/global_assets/images/icon_kviz/trash.svg">
                 </div> 
	 `);
	 }
	 
	if(variant === '2'){
	 $('.kviz-block-fo-voprosi-all').append(`<div class="kviz-input-block col-xs-12 kviz-input-block-vopros kviz-input-block-vopros-file"><div class="file-block"><input type="file" name="file-`+Rand+`[]" id="file-`+Rand+`" 
					  />
				<label for="file-`+Rand+`"><img src="/global_assets/images/icon_kviz/load-img.svg">
				</label></div>
                 <input type="text" class="form-control form-control-text" placeholder="Введите текст варианта ответа" name="" value=""><img class="delete-vopros-kviz" src="/global_assets/images/icon_kviz/trash.svg">
                 </div> 
	 `);
	 } 
	 
	 
	 })
 
  $(document).on('click','.delete-vopros-kviz',function(){
	  $(this).closest('.kviz-input-block-vopros').remove();
	 })
 
 
 
 
 
 
 
 
 
 $(document).on('click','.block__esli_2_select ul li',function(){
	text =  $('label',this).text()
	 $(this).closest('.block__esli_2_select').css('display','none');
	$(this).closest('.block__esli').find('.block__esli_3').text(text)
	 $(this).closest('.block__esli').find('.block__esli_3').css('display','block')
	 
	 
	 })
 $(document).on('click','.block__esli_3',function(){
	 $(this).css('display','none');
	 $(this).closest('.block__esli').find('.block__esli_2_select').css('display','block');
	 }) 
 
  $( function() {
    $( "#sortable-panel-otobragenie" ).sortable();
    $( "#sortable-panel-otobragenie" ).disableSelection();
  } );
  
  

  

  
  function parent_select_panel_url(event,obj){
	  	 event.preventDefault();
	/* $('.url-page ul li input').prop('checked', false);*/
	  $(obj).closest('.select-panel-blok-input').find('li input').prop('checked', false);
	 
		$(obj).closest('.select-panel-blok-input').find('ul li').removeClass('active');
	 $('input',obj).prop('checked', true);
	 $(obj).addClass('active');
$(obj).closest('.select-panel-blok-input').find('.btn-success').html($('label',obj).text())
	  
	  }  
  
  
    function operator_select(event,obj){
	 event.preventDefault();
	 
	 $(obj).closest('.operator-select-block').find('ul li input').prop('checked', false);
	$('input', obj).prop('checked', true);
	 $(obj).closest('.operator-select-block').find('ul li').removeClass('active');
	 $(obj).addClass('active');
	$(obj).closest('.select-panel-blok-input').find('.btn-success').html($('label',obj).text())
	  
	  }  
  
  $(document).on('click','.operator-select-block ul li',function(event){
	  
	  operator_select(event,this);
	  })
	  
	   $('.operator-select-block ul li').on('click',function(event){
	  
	  operator_select(event,this);
	  }) 
  
   $('.select-panel-blok ul li').on('click',  function(event){

parent_select_panel(event,this)
	 
	 }) 
  
  $(document).on('click','.delete_pravilo', function(){
	  $(this).closest('.pravilo-block').remove();
	  })
  $(document).on('click','.delete_pravilo2', function(){
	  $(this).closest('.show-chat-operator').remove();
	  })	  
	  
	  
	  
 $(document).on('click', '.select-panel-blok ul li', function(event){
	
	 parent_select_panel(event,this)
	 }) 
	
	
	
	

	 

	 
 $('.url-page ul li').on('click', function(event){
	 parent_select_panel_url(event,this)
	 
	 })	 
 $(document).on('click', '.url-page ul li', function(event){
parent_select_panel_url(event,this)
	 
	 }) 	 
	 
	 
	$(document).on('click','.block-header-5',function(){
		if(!$(this).is('.no-delete')){
		$(this).closest('.panel-otobragenie').remove();}
		}) 
		
	$(document).on('click', '.block-header-4',function(){
		html = $(this).closest('.panel-otobragenie').html();
		Rand =	Date.now()
		$('.result__div').html(html)
		$('.result__div .block-header-5').removeClass('no-delete');
		$('.result__div .switchery-xs-new').html('<input checked type="checkbox" class="js-switch'+Rand+'" data-id="">')
		html = $('.result__div').html()
		
		$('#sortable-panel-otobragenie').append('<div class="panel-otobragenie col-xs-12">'+html+'</div>')
		
			  var elems = document.querySelectorAll('.js-switch'+Rand+'');

for (var i = 0; i < elems.length; i++) {
  var switchery = new Switchery(elems[i], { size: 'small' , color: '#00B9EE'});
}
		}) 		
		
function body_panel_visible(){
 if ($('.panel-body-panel').is(':visible')) {
   $('.add_sourse_block__chat').css('display','none');
}
else{
	$('.add_sourse_block__chat').css('display','block');
	}
};	 
$(document).on('click', '.block-header-3',function(){
	if($(this).is('.active')){
		$(this).removeClass('active');
		}
	else{
		$(this).addClass('active');
		}	
	
	$(this).closest('.panel-otobragenie').find('.panel-body-panel').slideToggle( "fast" );

setTimeout(body_panel_visible, 500);
	
	})
  
$(document).on('click', '.save-setings2',function(){
	if($(this).closest('.panel-otobragenie').find('.block-header-3').is('.active')){
		$(this).closest('.panel-otobragenie').find('.block-header-3').removeClass('active');
		}
	else{
		$(this).closest('.panel-otobragenie').find('.block-header-3').addClass('active');
		}	
	
	$(this).closest('.panel-otobragenie').find('.panel-body-panel').slideToggle( "fast" );

setTimeout(body_panel_visible, 500);
	
	})
 function deletecanal(id) {
     datatosend = {
         id:id,

         _token: $('[name=_token]').val(),


     };
     $.ajax({
         type: "POST",
         url: '/ajax/deletecanal',
         data: datatosend,
         success: function (html1) {
             $('#cost'+id).remove();
         }



     });
 }
  
  </script>
<script type="text/javascript" src="https://vk.com/js/api/openapi.js?154"></script>

<!-- VK Widget -->
<script type="text/javascript" src="https://vk.com/js/api/openapi.js?154"></script>

{{--<!-- VK Widget -->
<div id="vk_community_messages"></div>
<script type="text/javascript">
    VK.Widgets.CommunityMessages("vk_community_messages", 153817342, {expanded: "1",tooltipButtonText: "Есть вопрос?"});
</script>--}}
<!-- /page container -->
<script type="text/javascript" src="/js/myscript.js?{{time()}}"></script>
@yield('skriptdop', '')

@yield('skript_callstat', '')
@yield('footer')
</body>
</html>
