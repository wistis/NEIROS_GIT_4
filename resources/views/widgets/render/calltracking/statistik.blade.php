<div class="row tab-pane active" id="basic-tab6">
<style>.two-saidbar-analitics-deshbord {
    background: #fff;
    margin-bottom: 20px;
    box-shadow: 0px 0px 11px 0px rgba(0, 0, 0, 0.2);
    padding-bottom: 13px;
}
.two-saidbar-analitics-deshbord button span{display: contents !important;
    font-family: Roboto, Helvetica Neue, Helvetica, Arial, sans-serif !important;
    font-size: 13px !important;
    font-weight: 400 !important;}

</style>
<div class="col-xs-12 ">
<div class="col-xs-12 two-saidbar-analitics-deshbord two-saidbar-analitics">
        	<ul class="btn-select-period">
            <? 
$date_this_active = '';	
$date_yesterday_active = '';
$date_week_active = '';
$date_months_active = '';	
$date_kvartal_active = '';
$date_year_active = '';

$DATE_START = date("d-m-Y", strtotime($stat_start_date));
$DATE_END = date("d-m-Y", strtotime($stat_end_date));	


	$date_7day = date("Y-m-d",strtotime($stat_start_date. " - 7 day"));


$date_this = date('d-m-Y');
if($date_this === $DATE_START && $date_this === $DATE_END){
$date_this_active = 'active';	

}

$date_yesterday = date('d-m-Y',strtotime('-1 days'));
if($date_yesterday === $DATE_START && $date_yesterday === $DATE_END){
$date_yesterday_active = 'active';	
}

$date_week = date('d-m-Y',strtotime('-7 days'));
if($date_week === $DATE_START && $date_this === $DATE_END){
$date_week_active = 'active';	
}


$date_months = date('d-m-Y',strtotime('-30 days'));
if($date_months === $DATE_START && $date_this === $DATE_END){
$date_months_active = 'active';	
}


$date_kvartal = date('d-m-Y',strtotime('-120 days'));
if($date_kvartal === $DATE_START && $date_this === $DATE_END){
$date_kvartal_active = 'active';	
}


$date_year = date('d-m-Y',strtotime('-368 days'));
if($date_year === $DATE_START && $date_this === $DATE_END){
$date_year_active = 'active';	
}



 
			?>
        		<li data-type="hours" class="<?=$date_this_active?>" data-start="<?=$date_this?>" data-end="<?=$date_this?>">Сегодня</li>
                <li data-type="hours" class="<?=$date_yesterday_active?>" data-start="<?=$date_yesterday?>" data-end="<?=$date_yesterday?>">Вчера</li>
                <li data-type="day" class="<?=$date_week_active?>" data-start="<?=$date_week?>" data-end="<?=$date_this?>">Неделя</li>
                <li data-type="day" class="<?=$date_months_active?>" data-start="<?=$date_months?>" data-end="<?=$date_this?>">Месяц</li>
                <li data-type="week" class="<?=$date_kvartal_active?>" data-start="<?=$date_kvartal?>" data-end="<?=$date_this?>">Квартал</li>
                <li data-type="month" class="<?=$date_year_active?>" data-start="<?=$date_year?>" data-end="<?=$date_this?>">Год</li>
             </ul>   
             
            <button type="button" class="btn btn-link daterange-ranges heading-btn text-semibold">
                <i class="fa fa-calendar-o" aria-hidden="true"></i> <span></span>
            </button>
            
            
                   <div class="checkbox-inline checkbox-switchery checkbox-right switchery-xs col-md-2"
                             style="width: 108px;
    margin-top: 20px;
    margin-left: 26px;">
                            <label>
                                <input type="checkbox" class="switchery" checked id="checkbox1"
                                       onclick="start_load_data()">Колбэк

                            </label>
                        </div>
              
                        <div class="checkbox-inline checkbox-switchery checkbox-right switchery-xs col-md-2"
                             style="width: 108px;
    margin-top: 20px;
    margin-left: 26px;">
                            <label>
                                <input type="checkbox" class="switchery" checked id="checkbox2"
                                       onclick="start_load_data()">Коллтрекинг

                            </label>
                        </div> 


         </div>    
    
        
        </div>


    <div class="col-md-12">
        <div class="breadcrumb-line breadcrumb-line-component" style="margin-bottom: 10px"><a
                    class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>

            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
            <input name="zss" id="zss" type="hidden" value=""/>
        </div>
        <?php /*?><div class="panel panel-white">
            <div class="panel-heading">
                <h6 class="panel-title">Статистика Колбека</h6>
                <div class="heading-elements">
                    <div class="row" style="margin: 15px;float: left">

                        <div class="checkbox-inline checkbox-switchery checkbox-right switchery-xs col-md-2"
                             style="width:200px">
                            <label>
                                <input type="checkbox" class="switchery" checked id="checkbox1"
                                       onclick="start_load_data()">Колбэк

                            </label>
                        </div>
                        {{----}}
                        <div class="checkbox-inline checkbox-switchery checkbox-right switchery-xs col-md-2"
                             style="width:200px">
                            <label>
                                <input type="checkbox" class="switchery" checked id="checkbox2"
                                       onclick="start_load_data()">Коллтрекинг

                            </label>
                        </div>
                    </div>
                    <button type="button" class="btn btn-link daterange-ranges heading-btn text-semibold">
                        <i class="icon-calendar3 position-left"></i> <span>{{$stat_start_date}}
                            -{{$stat_end_date}}</span> <b class="caret"></b>
                    </button>

                </div>
            </div>
            @inject('stat','\App\Http\Controllers\CallStaticController')

        </div><?php */?>
        <div class="row">
            <div class="col-md-6">
                <div class="all-info-chart" id="mchart_week0">    <div class="preloader-calltrecing">
        <div class="theme_tail_circle">
        <div class="pace_progress" data-progress-text="60%" data-progress="60"></div>
        <div class="pace_activity"></div>
        </div>
          </div>
          </div>
            </div>
            <div class="col-md-6">
                <div class="all-info-chart" id="mchart_week1">    <div class="preloader-calltrecing">
        <div class="theme_tail_circle">
        <div class="pace_progress" data-progress-text="60%" data-progress="60"></div>
        <div class="pace_activity"></div>
        </div>
          </div></div>
            </div>
            <div class="col-md-6">
                <div  class="all-info-chart" id="mchart_week2">    <div class="preloader-calltrecing">
        <div class="theme_tail_circle">
        <div class="pace_progress" data-progress-text="60%" data-progress="60"></div>
        <div class="pace_activity"></div>
        </div>
          </div></div>
            </div>
            <div class="col-md-6">
                <div class="all-info-chart" id="mchart_week3">    <div class="preloader-calltrecing">
        <div class="theme_tail_circle">
        <div class="pace_progress" data-progress-text="60%" data-progress="60"></div>
        <div class="pace_activity"></div>
        </div>
          </div></div>
            </div>


        </div>
    </div>
    {{--Дополнительные поля--}}

</div>