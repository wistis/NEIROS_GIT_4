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


                    <li><a href="/setting/billing_all"><i class="fa fa-cogs" aria-hidden="true"></i> Биллинг</a></li>
                        {{--<li><a href="/setting/checkcompanys"><i class="fa fa-cogs" aria-hidden="true"></i> Счета на оплату</a></li>
                        <li><a href="/setting/billing/phones"><i class="fa fa-cogs" aria-hidden="true"></i> Стоимость номеров</a></li>
                        <li><a href="/setting/billing/recs"><i class="fa fa-cogs" aria-hidden="true"></i> Стоимость разговоров</a></li>
--}}

                        <li><a href="/setting/clientfield"><i class="fa fa-cogs" aria-hidden="true"></i> Доп поля контактов</a></li>
                        <li><a href="/setting/companyfield"><i class="fa fa-cogs" aria-hidden="true"></i> Доп поля компаний</a></li>
                        <li><a href="/setting/users"><i class="fa fa-cogs" aria-hidden="true"></i> Пользователи</a></li>
                        <li><a href="/setting/sites"><i class="fa fa-cogs" aria-hidden="true"></i> Сайты</a></li>
                    <li><a href="/setting/smsreports"><i class="fa fa-cogs" aria-hidden="true"></i> SMS отчеты</a></li>
                    <li><a href="/setting/messages"><i class="fa fa-cogs" aria-hidden="true"></i> Сообщения</a></li>
             
                    
                </ul>
            </div>
            
            <div class="category-content display-all-content no-padding colltrecing" style="display:none;">
                <ul class="navigation navigation-alt navigation-accordion">
                    <li class="navigation-header" style="padding-bottom: 30px;"><div style="float: left;margin-bottom: 10px;padding-right: 10px;">Коллтрекинг</div> <? if(isset($status_checkbox)){?> <div class="switchery-xs" style="margin-top: 4px;">{!! $status_checkbox !!}</div> <? } ?></li>
                        <li class="active"><a  data-type-menu="#basic-tab6"><i class="fa fa-bar-chart" aria-hidden="true"></i> Статистика</a></li>
<?php /*?>                        <li><a  data-type-menu="#basic-tab1"><i class="fa fa-cogs" aria-hidden="true"></i>  Основное</a></li>
<?php */?>                           <li><a   data-type-menu="#basic-tab2"><i class="fa fa-list-ol" aria-hidden="true"></i> Номера</a></li>           
                      <li><a   data-type-menu="#basic-tab3"><i class="fa fa-usb" aria-hidden="true"></i> Сценарии</a></li>   
                      <li><a   data-type-menu="#basic-tab4"><i class="fa fa-volume-up" aria-hidden="true"></i> Входящие звонки</a></li>
                    <li><a  class="item-widget1" data-name="Настройка коллтрекинга" data-id="calltrack_setting_ajax"><i  class="fa fa-cogs" aria-hidden="true"></i>Настройки</a></li>

                </ul>
            </div>
            
            <div class="category-content display-all-content no-padding analytics" style="display:none;">
                <ul class="navigation navigation-alt navigation-accordion">
                    <li class="navigation-header">Аналитика</li>

                <li ><a  class="item-widget1" data-name="Настройка Промокодов" data-id="100001" ><i class="fa fa-list-alt" aria-hidden="true"></i> Промокоды</a></li>

                <li><a class="item-widget1" data-name="Настройка Событий"  data-id="allreports_setting"><i class="fa fa-bullseye" aria-hidden="true"></i> События</a></li>
                <li><a class="item-widget1" data-name="Настройка Рекламных каналов" data-id="advertisingchannel" ><i class="fa fa-window-restore" aria-hidden="true"></i> Рекламные каналы</a></li>
                <li><a  class="item-widget1" data-name="Настройка Расходов" data-id="advertisingchannelcost" ><i class="fa fa-cogs" aria-hidden="true"></i> Расходы</a></li>

                    
                </ul>
            </div>
            
            
        </div>
        <!-- /sub navigation -->



    </div>
</div>
<!-- /secondary sidebar -->