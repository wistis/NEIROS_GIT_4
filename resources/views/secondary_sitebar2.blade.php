<!-- Secondary sidebar -->
<div class="sidebar sidebar-secondary sidebar-default" style="background: white" >
    <div class="sidebar-content">




        <!-- Sub navigation -->
        <div class="sidebar-category sidebar-category-fixed">
        <div style="
    position: fixed;
    background: #000;
    top: 154px;
    width: 20px;
    height: 40px;
    border-radius: 0px 30px 30px 0px;
    margin-left: -3px;
    z-index: 50;
"><i class="fa hidden-xs fa-angle-left" style="
    color: #fff;
    /* top: 10px; */
    margin-top: 10px;
    margin-left: 4px;
    font-size: 16px;
"> </i></div>
        
        
            <div class="category-title">
                <span>Navigation</span>
                <ul class="icons-list">
                    <li><a href="#" data-action="collapse"></a></li>
                </ul>
            </div>

            <div class="category-content display-all-content no-padding settings" style="display:none;">
                <ul class="navigation navigation-alt navigation-accordion">
                    <li class="navigation-header">Настройки</li>


                    <li><a href="/setting/billing_all"><i class="fa fa-credit-card" aria-hidden="true"></i> <span>Биллинг</span></a></li>
                        {{--<li><a href="/setting/checkcompanys"><i class="fa fa-cogs" aria-hidden="true"></i> <span>Счета на оплату</span></a></li>
                        <li><a href="/setting/billing/phones"><i class="fa fa-cogs" aria-hidden="true"></i> <span>Стоимость номеров</span></a></li>
                        <li><a href="/setting/billing/recs"><i class="fa fa-cogs" aria-hidden="true"></i> <span>Стоимость разговоров</span></a></li>
--}}
 @if(Auth::user()->super_admin==1)
                        <li><a href="/setting/clientfield"><i class="fa fa-cogs" aria-hidden="true"></i> <span>Доп поля контактов</span></a></li>
                        <li><a href="/setting/companyfield"><i class="fa fa-cogs" aria-hidden="true"></i> <span>Доп поля компаний</span></a></li>
                            <li><a href="/setting/messages"><i class="fa fa-cogs" aria-hidden="true"></i> <span>Сообщения</span></a></li>
  @endif                      
                        
                        
                        <li><a href="/setting/users"><i class="fa fa-users" aria-hidden="true"></i> <span>Пользователи</span></a></li>
                        <li><a href="/setting/sites"><i class="fa fa-code" aria-hidden="true"></i> <span>Сайты</span></a></li>
                    <li><a href="/setting/smsreports"><i class="fa fa-envelope-open-o" aria-hidden="true"></i> <span>SMS отчеты</span></a></li>
                
              <li><a href="/setting/partners"><i class="fa fa-black-tie" aria-hidden="true"></i> <span style="
    display: block;
    float: left;
    margin-top: -3px;
    line-height: 1.2;
">Партнерская<br>программа</span></a> </li>
                    
                </ul>
            </div>
            
            <div class="category-content display-all-content no-padding colltrecing" style="display:none;">
                <ul class="navigation navigation-alt navigation-accordion">
                        <li class="active"><a  data-type-menu="#basic-tab6"><i class="fa fa-bar-chart" aria-hidden="true"></i> <span>Статистика</span></a></li>
<?php /*?>                        <li><a  data-type-menu="#basic-tab1"><i class="fa fa-cogs" aria-hidden="true"></i>  Основное</a></li>
<?php */?>                           <li><a   data-type-menu="#basic-tab2"><i class="fa fa-list-ol" aria-hidden="true"></i> <span>Номера</span></a></li>           
                      <li><a   data-type-menu="#basic-tab3"><i class="fa fa-usb" aria-hidden="true"></i> <span>Сценарии</span></a></li>   
                      <li><a   data-type-menu="#basic-tab4"><i class="fa fa-volume-up" aria-hidden="true"></i> <span>Входящие звонки</span></a></li>
                    <li><a  class="item-widget1" data-name="Настройка коллтрекинга" data-id="calltrack_setting_ajax"><i class="fa fa-cog" aria-hidden="true"></i> <span>Настройки</span></a></li>

                </ul>
            </div>
            
            <div class="category-content display-all-content no-padding analytics" style="display:none;">
                <ul class="navigation navigation-alt navigation-accordion">
                    <li class="navigation-header">Аналитика</li>

                <li ><a  class="item-widget1" data-name="Настройка Промокодов" data-id="100001" ><i class="fa fa-list-alt" aria-hidden="true"></i> <span>Промокоды</span></a></li>

                <li><a class="item-widget1" data-name="Настройка Событий"  data-id="allreports_setting"><i class="fa fa-bullseye" aria-hidden="true"></i> <span>События</span></a></li>
                <li><a class="item-widget1" data-name="Настройка Рекламных каналов" data-id="advertisingchannel" ><i class="fa fa-window-restore" aria-hidden="true"></i> <span>Рекламные каналы</span></a></li>
                <li><a  class="item-widget1" data-name="Настройка Расходов" data-id="advertisingchannelcost" ><i class="fa fa-cogs" aria-hidden="true"></i> <span>Расходы</span></a></li>

                    
                </ul>
            </div>
            
            
        </div>
        <!-- /sub navigation -->



    </div>
</div>
<!-- /secondary sidebar -->