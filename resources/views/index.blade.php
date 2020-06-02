@extends('app')
@section('title') Дашборд @endsection


@section('content')
    <script type="text/javascript" src="/default/assets/js/plugins/visualization/d3/d3.min.js"></script>
    <script type="text/javascript" src="/default/assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
    <script>
        var bardata =[];

        @for($i=0;$i<=23;$i++)
            @if(!isset($amount_sdelka_hour[$i]))
            bardata.push(0);
            @else
            bardata.push({{$amount_sdelka_hour[$i]}});
            @endif

       @endfor
mm=' {!! $amount_sdelka_summ!!}';

;   
var dataset=JSON.parse(mm);
       
        ;</script>

    <div class="modal" id="myModalCreateRestort">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" id="formCreateReports">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Конструктор</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body row">
                        <div class="col-md-12 mb-20">
                            <input type="text" name="name" id="namedd" placeholder="Название" class="form-control">
                        </div>
                        <div class="col-md-12 mb-20">Тип отчета
                            <select name="type">
                                <option value="line">График</option>
                                <option value="funnel">Воронка</option>


                            </select>
                        </div>


                        <div class="col-md-6 table-bordered"><b>Группировки</b>
                            @foreach ($reports_gropings as $item)
                                <div><input type="checkbox" value="{{$item->id}}" name="grouping[]">{{$item->name}}
                                </div>


                            @endforeach

                        </div>
                        <div class="col-md-6 table-bordered"><b>Показатели</b>

                            @foreach ($reports_resourse as $item)
                                <div><input type="checkbox" value="{{$item->code}}" name="resourses[]">{{$item->name}}
                                </div>


                            @endforeach


                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" onclick="create_reports();return false">Создать
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
<style>
 .loader {

        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.75);
        z-index: 2;

    }
    .laoder-frame {
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        height: 100vh;
    }

    .svg-loader {
        width: 110px;
        -webkit-animation: svg-loader 1s linear infinite;
        animation: svg-loader 1s linear infinite;
    }

    @-webkit-keyframes svg-loader {
        from {
            -webkit-transform: rotate(0);
            transform: rotate(0)
        }
        to {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg)
        }
    }

    @keyframes svg-loader {
        from {
            -ms-transform: rotate(0);
            -webkit-transform: rotate(0);
            transform: rotate(0)
        }
        to {
            -ms-transform: rotate(360deg);
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg)
        }
    }
    .looder_div{
      /*  display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        height: 100vh;*/
		
	    display: block;
    /* -webkit-box-pack: center; */
    -ms-flex-pack: center;
    /* justify-content: center; */
    /* -webkit-box-align: center; */
    -ms-flex-align: center;
    /* align-items: center; */
    /* height: 100vh; */
    left: 50%;
    position: absolute;
    margin-left: -56px;
    top: 50%;
    margin-top: -65px;	
		
    }
    .cssload-loader {


        left: calc(50% - 56px);
        width: 112px;
        height: 112px;
        border-radius: 50%;
        -o-border-radius: 50%;
        -ms-border-radius: 50%;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        perspective: 1400px;

    }

    .cssload-inner {
        position: absolute;
        width: 100%;
        height: 100%;
        box-sizing: border-box;
        -o-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        border-radius: 50%;
        -o-border-radius: 50%;
        -ms-border-radius: 50%;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
    }

    .cssload-inner.cssload-one {
        left: 0%;
        top: 0%;
        animation: cssload-rotate-one 1.15s linear infinite;
        -o-animation: cssload-rotate-one 1.15s linear infinite;
        -ms-animation: cssload-rotate-one 1.15s linear infinite;
        -webkit-animation: cssload-rotate-one 1.15s linear infinite;
        -moz-animation: cssload-rotate-one 1.15s linear infinite;
        border-bottom: 5px solid rgb(64,164,244);
    }

    .cssload-inner.cssload-two {
        right: 0%;
        top: 0%;
        animation: cssload-rotate-two 1.15s linear infinite;
        -o-animation: cssload-rotate-two 1.15s linear infinite;
        -ms-animation: cssload-rotate-two 1.15s linear infinite;
        -webkit-animation: cssload-rotate-two 1.15s linear infinite;
        -moz-animation: cssload-rotate-two 1.15s linear infinite;
        border-right: 5px solid rgb(64,164,244);
    }

    .cssload-inner.cssload-three {
        right: 0%;
        bottom: 0%;
        animation: cssload-rotate-three 1.15s linear infinite;
        -o-animation: cssload-rotate-three 1.15s linear infinite;
        -ms-animation: cssload-rotate-three 1.15s linear infinite;
        -webkit-animation: cssload-rotate-three 1.15s linear infinite;
        -moz-animation: cssload-rotate-three 1.15s linear infinite;
        border-top: 5px solid rgb(64,164,244);
    }







    @keyframes cssload-rotate-one {
        0% {

            transform: rotateX(35deg) rotateY(-45deg) rotateZ(0deg);
        }
        100% {
            transform: rotateX(35deg) rotateY(-45deg) rotateZ(360deg);
        }
    }

    @-o-keyframes cssload-rotate-one {
        0% {
            -o-transform: rotateX(35deg) rotateY(-45deg) rotateZ(0deg);
        }
        100% {
            -o-transform: rotateX(35deg) rotateY(-45deg) rotateZ(360deg);
        }
    }

    @-ms-keyframes cssload-rotate-one {
        0% {
            -ms-transform: rotateX(35deg) rotateY(-45deg) rotateZ(0deg);
        }
        100% {
            -ms-transform: rotateX(35deg) rotateY(-45deg) rotateZ(360deg);
        }
    }

    @-webkit-keyframes cssload-rotate-one {
        0% {
            -webkit-transform: rotateX(35deg) rotateY(-45deg) rotateZ(0deg);
        }
        100% {
            -webkit-transform: rotateX(35deg) rotateY(-45deg) rotateZ(360deg);
        }
    }

    @-moz-keyframes cssload-rotate-one {
        0% {
            -moz-transform: rotateX(35deg) rotateY(-45deg) rotateZ(0deg);
        }
        100% {
            -moz-transform: rotateX(35deg) rotateY(-45deg) rotateZ(360deg);
        }
    }

    @keyframes cssload-rotate-two {
        0% {
            transform: rotateX(50deg) rotateY(10deg) rotateZ(0deg);
        }
        100% {
            transform: rotateX(50deg) rotateY(10deg) rotateZ(360deg);
        }
    }

    @-o-keyframes cssload-rotate-two {
        0% {
            -o-transform: rotateX(50deg) rotateY(10deg) rotateZ(0deg);
        }
        100% {
            -o-transform: rotateX(50deg) rotateY(10deg) rotateZ(360deg);
        }
    }

    @-ms-keyframes cssload-rotate-two {
        0% {
            -ms-transform: rotateX(50deg) rotateY(10deg) rotateZ(0deg);
        }
        100% {
            -ms-transform: rotateX(50deg) rotateY(10deg) rotateZ(360deg);
        }
    }

    @-webkit-keyframes cssload-rotate-two {
        0% {
            -webkit-transform: rotateX(50deg) rotateY(10deg) rotateZ(0deg);
        }
        100% {
            -webkit-transform: rotateX(50deg) rotateY(10deg) rotateZ(360deg);
        }
    }

    @-moz-keyframes cssload-rotate-two {
        0% {
            -moz-transform: rotateX(50deg) rotateY(10deg) rotateZ(0deg);
        }
        100% {
            -moz-transform: rotateX(50deg) rotateY(10deg) rotateZ(360deg);
        }
    }

    @keyframes cssload-rotate-three {
        0% {
            transform: rotateX(35deg) rotateY(55deg) rotateZ(0deg);
        }
        100% {
            transform: rotateX(35deg) rotateY(55deg) rotateZ(360deg);
        }
    }

    @-o-keyframes cssload-rotate-three {
        0% {
            -o-transform: rotateX(35deg) rotateY(55deg) rotateZ(0deg);
        }
        100% {
            -o-transform: rotateX(35deg) rotateY(55deg) rotateZ(360deg);
        }
    }

    @-ms-keyframes cssload-rotate-three {
        0% {
            -ms-transform: rotateX(35deg) rotateY(55deg) rotateZ(0deg);
        }
        100% {
            -ms-transform: rotateX(35deg) rotateY(55deg) rotateZ(360deg);
        }
    }

    @-webkit-keyframes cssload-rotate-three {
        0% {
            -webkit-transform: rotateX(35deg) rotateY(55deg) rotateZ(0deg);
        }
        100% {
            -webkit-transform: rotateX(35deg) rotateY(55deg) rotateZ(360deg);
        }
    }

    @-moz-keyframes cssload-rotate-three {
        0% {
            -moz-transform: rotateX(35deg) rotateY(55deg) rotateZ(0deg);
        }
        100% {
            -moz-transform: rotateX(35deg) rotateY(55deg) rotateZ(360deg);
        }
    }
.container__deshbord{
	margin-right: 0;
margin-left: 0; margin-top:70px; width:100%
	}
.two-saidbar-analitics-deshbord{
	background: #fff;
    margin-bottom: 20px;
    box-shadow: 0px 0px 11px 0px rgba(0, 0, 0, 0.2);
	    padding-bottom: 13px;
	}
.block-grafick{
	padding-left: 0px;
    padding-right: 0px;
		}
.add-widget-btn{
	display:none;
	background: #00B9EE;
	}
.chart-js-block-right{
	    top: 12px;
	}
.all-info-chart{
padding-left: 0px;
    padding-right: 15px;
    background: #fff;
    border-radius: 10px;
box-shadow: 0px 3px 8px 0px rgba(50, 50, 50, 0.4);	position: relative;
        float: left;
    width: 100%;
	}
.all-info-chart:hover{
	box-shadow: 0px 10px 18px 0px rgba(50, 50, 50, 0.4);
	}	
.mmm.col-xs-6 .chart-js-block{position: absolute;
    right: 19px;
	z-index:2}	
	
.name-report-chart{
	font-family: 'Raleway SemiBold';
    position: absolute;
    font-size: 17px;
    left: 25px;
    top: 15px;
	z-index:2;}	
	.name-report-chart-2{
		width: 296px;
    left: 50%;
    margin-left: -148px;}	
	
	
	
	#today-revenue svg g circle{    fill: #FEB174 !important;}				
</style>    
    
    
    <div class="container container__deshbord">
        <div class="row">
        
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
            
            
            

        
           <ul class="chart-js-block-right">
				<li><button type="button" class="btn btn-primary add-widget-btn" >+ Добавить виджет</button></li>

        </ul>
        
                    <form id="reportsform2" style="display:none;"  >
  
                
        
                    <input type="hidden" name="period_start" id="period_start" value="{{$stat_start_date}}">
                    <input type="hidden" name="period_start_7" id="period_start_7" value="{{$date_7day}}">
                   <input type="hidden" name="canals" id="canals" value="0">
          
                    <input type="hidden" name="period_end" id="period_end" value="{{$stat_end_date}}">
          
            </form>
        
        </div>
        
        
        
        
            <div class="col-xs-12 block-grafick">
                <div class="row">
                
                                    <div class="col-sm-3">

                        <div class="panel  bg-teal-400">
                            <div class="panel-body">
                                <div class="heading-elements">

                                </div>

                                <h3 class="no-margin"></h3>
                               <span>Посетители</span>
                            </div>

                            <div id="server-load"></div>
                        </div>

                    </div>
                
                
                
                    <div class="col-sm-3">

                        <div class="panel bg-pink-400">
                            <div class="panel-body">
                                <div class="heading-elements">
                                </div>

                                <h3 class="no-margin"></h3>
                               <span>Заявки</span>
                            </div>

                            <div class="container-fluid">
                                <div id="members-online-new-1"></div>
                            </div>
                        </div>

                    </div>



<div class="col-sm-3">

                        <div class="panel bg-blue-400">
                            <div class="panel-body">
                                <div class="heading-elements">
                                </div>

                                <h3 class="no-margin"></h3>
                               <span>Продажи</span>
                            </div>

                            <div class="container-fluid">
                                <div id="members-online-new-2"></div>
                            </div>
                        </div>

                    </div>


                    <div class="col-sm-3">

                        <div class="panel bg-orange-400">
                            <div class="panel-body">
                                <div class="heading-elements">
                                    <?php /*?><ul class="icons-list">
                                        <li><a data-action="reload"></a></li>
                                    </ul><?php */?>
                                </div>

                                <h3 class="no-margin"></h3>
                                <span>Прибыль</span>
                            </div>

                            <div id="today-revenue"></div>
                        </div>

                    </div>
                </div>
                
                                    
                
                
                
                <?php /*?><div class="  panel-default row">
                    <div class=" col-md-5"> </div>
                    <div class="col-md-5" style="text-align: right; ">
                        {{--<button type="button" class="btn btn-link daterange-ranges heading-btn text-semibold">
                            <i class="icon-calendar3 position-left"></i> <span>{{$stat_start_date}}-{{$stat_end_date}}</span> <b
                                    class="caret"></b>
                        </button>--}}
                    </div>
                    <div class="col-md-2">  </div>
                    <div class="panel-body row"  style="margin-top: 50px">
                        <form id="reportsform" style="display: none">
                            {{-- <div class="col-md-3">
                                 <input type="text" value="0" id="type">
                                 <select name="stage">
                                     <option value="-">Без учета этапа</option>
                                     <option value="0">Неразобранное</option>
                                    @foreach($stages as $stage)
                                     <option value="{{$stage->id}}">{{$stage->name}}</option>
                                    @endforeach
                                 </select>


                             </div>--}}
                            <div class="col-md-3 row" style="display: none">
                                <div class="col-md-6" style="padding-top: 8px;">Детализация</div>
                                <div class="col-md-6"><select name="group" class="form-control xtipday" style="width: 100px">

                                        <option value="day">По Дням</option>
                                        <option value="week">По неделям</option>
                                        <option value="month">По месяцам</option>

                                    </select></div>


                            </div>
                            <div class="col-md-3">
                                <input type="hidden" name="period_start" id="period_start" value="{{date('Y-m-d',(time()-86400*7))}}">
                                <input type="hidden" name="dashboard" id="period_start" value="1">


                            </div>
                            <div class="col-md-3">
                                <input type="hidden" name="period_end" id="period_end" value="{{date('Y-m-d')}}">


                            </div>


                        </form>
                        @foreach($my_reports as $my_report)
                            <div class="col-lg-4">

                                <!-- Sales stats -->
                                <div class="panel panel-flat">
                                    <div class="panel-heading">
                                        <h6 class="panel-title">{{$my_report->name}}</h6>
                                        <div class="heading-elements">
                                              <i class="fa fa-cog classconf" style="opacity: 0.2"></i>
                                        </div>
                                    </div>

                                    <div class="container-fluid">
                                        <div class="row text-center">


                                            <div class="js-analytics{{$my_report->id}}" style="width: 100%;min-height: 250px"></div>

                                        </div>
                                    </div>


                                    <div id="monthly-sales-stats"></div>
                                </div>
                                <!-- /sales stats -->

                            </div>
                        @endforeach




                        <div class="col-lg-4">
                        <button class="btn btn-info" data-toggle="modal" data-target="#myModalCreateRestort"><i
                                    class="fa fa-plus"></i>Создать виджет
                        </button></div>
                    </div>
                </div><?php */?>
            </div>
            
          <style>
          .table-chart-grafick{position: absolute;
    background: #fff;
    right: 18px;
    padding-right: 29px;
    width: 340px;
    width: 46%;
    top: 133px;
    z-index: 1;
	    min-height: 300px;
	}
          .table-chart-grafick .tr-table-chart{
    font-family: 'Raleway Regular';
    float: left;
    width: 100%;
    border-bottom: 1px solid #F0F2F5;
    padding-top: 8px;
    padding-bottom: 8px;
	font-size:13px;
	position: relative;
	cursor: pointer;
   }
   
   
   .table-chart-grafick .table-chart-body .tr-table-chart{
	   opacity:0.3;}
   .table-chart-grafick .table-chart-body .tr-table-chart.active{
	   opacity:1;}
     .table-chart-grafick .tr-table-chart.head-table-chart{    text-transform: uppercase;
    font-size: 11px;
    font-weight: bold;
    font-family: 'Raleway Medium';
	cursor:default;} 
   
		  .table-chart-grafick .tr-table-chart .td-1{float: left;
    width: 188px;
	padding-left: 20px;
	
	} 
	
	.table-chart-grafick .tr-table-chart.head-table-chart .td-1{
	padding-left: 0px;
	
	}
	.table-chart-grafick .tr-table-chart .td-1 div{
float: left;
    width: 15px;
    left: 0px;
    height: 8px;
    border-radius: 2px;
    position: absolute;
    top: 15px;
		}
		  .table-chart-grafick .tr-table-chart .td-2{float: left;
    width: 50px;
    text-align: right;
    font-family: 'Roboto';}
		  .table-chart-grafick .tr-table-chart .td-3{text-align: right;
    font-family: 'Roboto';}
	
	.itogo-chart{
		display:none;
		    position: absolute;
    top: 46%;
    z-index: 1;
    left: 16%;
    width: 100px;
    text-align: center;
		}
	.itogo-chart .name-itogo{
		font-family: 'Raleway Regular';
    font-size: 15px;
			}
		.itogo-chart .summ-itogo{
	    font-family: 'Roboto Bold';
    font-size: 28px;
    margin-top: -5px;
			}
	.itogo-chart.active{
		display:block;}	
		
	.table-chart-no-data{position: absolute;
    font-family: 'Raleway SemiBold';
    top: 50%;
    font-size: 29px;
    margin-left: -81px;
    margin-top: -22px;
    left: 50%;}	
					
          </style>  
            
            
            
            <div class="mmm col-xs-6" style="padding-left:0px;">
            <div class="all-info-chart">
        <div class="loader" id="loader-1" style="display: block;">
            <div class="looder_div">
                <div class="cssload-loader">
                    <div class="cssload-inner cssload-one"></div>
                    <div class="cssload-inner cssload-two"></div>
                    <div class="cssload-inner cssload-three"></div>
                </div>
            </div>
        </div>
        <div class="name-report-chart name-report-chart-2">ТОП рекламных каналов по заявкам</div>
        <div class="table-chart-no-data" style="display:none">Нет данных</div>
        <div class="table-chart-grafick" style="display:none">
        <div class="tr-table-chart head-table-chart">
        	<div class="td-1">Рекламные каналы</div>
            <div class="td-2">Заявки</div>
        </div>
        <div class="table-chart-body">

        </div>
        </div>
        
        <div class="itogo-chart" >
        <div class="name-itogo">Всего</div>
        <div class="summ-itogo">1500</div>
        </div>

            <div class="js-analytics-doughnut" style="width: 100%;height: 450px;margin-top: 28px;"></div>
           

		</div>
        </div>
            
                  <div class="mmm col-xs-6" style="padding-right:0px;">
                  <div class="all-info-chart">
        <div class="loader" id="loader-2" style="display: block;">
            <div class="looder_div">
                <div class="cssload-loader">
                    <div class="cssload-inner cssload-one"></div>
                    <div class="cssload-inner cssload-two"></div>
                    <div class="cssload-inner cssload-three"></div>
                </div>
            </div>
        </div>
        <div class="name-report-chart">Сводный отчет</div>
        	                       <ul class="chart-js-block">
        	<li data-type="line" data-stack="0" class="active"><img src="/global_assets/images/icon/icon-1.png"><img class="hover" src="/global_assets/images/icon/hover/icon-1.png"></li>
<?php /*?>        	<li data-type="line" data-stack="1"><img src="/global_assets/images/icon/icon-4.png"><img class="hover" src="/global_assets/images/icon/hover/icon-4.png"></li><?php */?>
           <li data-type="bar" data-stack="0"><img src="/global_assets/images/icon/icon-3.png"><img class="hover" src="/global_assets/images/icon/hover/icon-3.png"></li>

<?php /*?>            <li data-type="bar" data-stack="1"><img src="/global_assets/images/icon/icon-2.png"><img class="hover" src="/global_assets/images/icon/hover/icon-2.png"></li><?php */?>
        </ul>
            <div class="js-analytics" style="width: 100%;height: 450px;margin-top: 28px;"></div>
           
 </div>  

        </div>  
            
            
        </div>
    </div>

    <script type="text/javascript" src="/default/assets/js/plugins/ui/moment/moment.min.js"></script>
    <script type="text/javascript" src="/js/echarts.min.js"></script>
    <script type="text/javascript" src="/default/assets/js/plugins/visualization/d3/d3.min.js"></script>
    <script type="text/javascript" src="/default/assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
        <script src="/js/daterangepicker3.js"></script>
  	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />   
  <script>
   $('.daterange-ranges').daterangepicker({
				 "autoApply": false,
				  "linkedCalendars": true,
				     "alwaysShowCalendars": true,
					   "showDropdowns": true,
					   opens: 'left',

	"startDate": "<?=date("d-m-Y", strtotime($stat_start_date))?>",
	"endDate": "<?=date("d-m-Y", strtotime($stat_end_date))?>",
/*	"maxDate": "21-12-2019",
	"minDate": "01-01-2019",*/

 "locale": {
        "format": "DD-MM-YYYY",
        "separator": " - ",
        "applyLabel": "Применить",
        "cancelLabel": "Отмена",
        "fromLabel": "От",
        "toLabel": "До",
        "customRangeLabel": "Заданый",
        "daysOfWeek": [
            'Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'
        ],
        "monthNames": [
            'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',
            'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'
        ],
		 "firstDay": 1
    }
	

	
}
,
            function (start, end) {
                $('.daterange-ranges span').html(start.format('DD-MM-Y') + ' - ' + end.format('DD-MM-Y'));
				
               
				
				var date1 = new Date(start.format('Y-MM-DD'));

var date2 = new Date(end.format('Y-MM-DD'));

var timeDiff = Math.abs(date2.getTime() - date1.getTime());

var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
type = 'hours';
if(diffDays <= 30){
	type= 'day';
	}
if(diffDays > 30 && diffDays <= 120){
	type= 'week';
	}
				
if(diffDays > 120 && diffDays <= 368){
	type= 'month';
	}				
	
	 setdate(start.format('Y-MM-DD'), end.format('Y-MM-DD'),type);
				dateFound(start.format('Y-MM-DD'), end.format('Y-MM-DD'));
            }


); 
function dateFound(data_start,data_end){

data_start_mass = data_start.split('-');
data_end_mass = data_end.split('-');
months_end =data_end_mass[1];
months_start =data_start_mass[1];
if(months_start.indexOf('0') === 0){
	months_start = months_start.replace('0', '') 
	}
if(months_end.indexOf('0') === 0){
	months_end = months_end.replace('0', '') 
	}	
	
	
months_start = months_start - 1;
months_end = months_end - 1;
monthNames = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня','июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря']	

string = data_start_mass[2]+' '+monthNames[months_start]+' '+data_start_mass[0]+' - '+data_end_mass[2]+' '+monthNames[months_end]+' '+data_end_mass[0];
$('.daterange-ranges span').html(string);	
	}

function  setdate(start,end,data_type){


            start_date = start;
            end_date = end;
			 $('#period_start').val(start_date);
            $('#period_end').val(end_date);
            datatosend = {
                start_date: start_date,
                end_date: end_date,


                _token: $('[name=_token]').val(),


            }


            $.ajax({
                type: "POST",
                url: '/stat/start_date',
                data: datatosend,
                success: function (html1) {
                	reports_doughnut(start,end,data_type)
					top_for_block(start,end,data_type)
                 reports_new(1,'line');
                }
            })
	
	}

dateFound('<?=date("Y-m-d", strtotime($stat_start_date))?>','<?=date("Y-m-d", strtotime($stat_end_date))?>')
$('.btn-select-period li').on('click', function(){
	if(!$(this).is('.active')){
	data_start = $(this).attr('data-start');
	data_end = $(this).attr('data-end');
	data_type = $(this).attr('data-type');
	
	$('.btn-select-period li').removeClass('active')
	$(this).addClass('active');
	$('.daterange-ranges').data('daterangepicker').setStartDate(data_start);
$('.daterange-ranges').data('daterangepicker').setEndDate(data_end);
	data_start_format = data_start.split('-');
	data_end_format = data_end.split('-') 
	$('#period_start').val(data_start_format[2]+'-'+data_start_format[1]+'-'+data_start_format[0]);
	$('#period_end').val(data_end_format[2]+'-'+data_end_format[1]+'-'+data_end_format[0]);
	
	dateFound(data_start_format[2]+'-'+data_start_format[1]+'-'+data_start_format[0],data_end_format[2]+'-'+data_end_format[1]+'-'+data_end_format[0]);
	setdate(data_start,data_end,data_type);
}
	})
 reports_new(1,'line');
 
  			var chartHolder = document.querySelector('.js-analytics');
        
                chart = echarts.init(chartHolder);
                var labelOption = {
                    normal: {
                        show: true,
                        position: 'insideBottom',
                        distance: 40,
                        align: 'left',
                        verticalAlign: 'middle',
                        rotate: 90,
                      
                        fontSize: 14 

                    } 

                };
 
        function line_gr_new(datatotable, chartHolder) {


            if (chartHolder) {
 
               
                var option = {
           
                    grid: {
                        left: 60,

                        top: 50,
                        right: 100,
                        bottom: 50,
                        backgroundColor: '#006699'
                    },
                    color: ['#2d7bcb', '#3ed25a', '#eff70b', '#f7210b', '#f80aea', '#a10af8', '#faa106'],
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {
                            type: 'shadow'
                        }
                    },
                    legend: {
                        data: datatotable['names'],
                        orient: 'vertical',
                        left: 'right',
                        top: 'center',


                    },
                    toolbox: {
                        show: true,
                        orient: 'horizontal',
                        left: 'left',
                        top: 'top',
                        feature: {
                            mark: {
                                show: true
                            },
                            dataView: {
                                show: false,
                                readOnly: false
                            },
                            magicType: {
                                show: false,
								
                                type: ['line', 'bar', 'stack'],
								

                                title: {
                                    line: ' ',
                                    bar: ' ',
                                    stack: ' '
                                }
                            },
                            restore: {
                                show: false,
								title: ' '
                            },

                        }
                    },
                    calculable: true,
                    xAxis: [{
                        type: 'category',
						boundaryGap: false,
                        axisTick: {
                            show: false
                        },
                        data: datatotable['dates']
                    }],
                    yAxis: [{
                        type: 'value'
                    }],
                    series: datatotable['series']
                }; 

                chart.setOption(option, true);
				
	
				

            }

        }

        function reports_new(id,type_charts) {
            $('.loader').show();
           
			group = 'day'
			period_start = $("#period_start").val()
			period_end = $("#period_end").val()
			if(period_start === period_end){
				period_start = $("#period_start_7").val()
				
				}
			
			canals = $("#canals").val()
            //    document.querySelector('.js-analytics').innerHTML='';
            $.ajax({
                type: "get",
                url: '/reports/' + id,
                data: {'group':group,'period_start':period_start,'canals':canals, 'period_end':period_end, 'type_charts':type_charts},
                success: function (html1) {
                    datatotable = JSON.parse(html1);
                    $('.loader').hide();

                    var chartHolder = document.querySelector('.js-analytics');

                    if (datatotable['type'] == 'line') {
                        line_gr_new(datatotable, chartHolder)
                    }
                    if (datatotable['type'] == 'funnel') {
                        var chartHolder = document.querySelector('.js-analytics2');
                        funnel_gr(datatotable, chartHolder)
                    }


                }
            })


        }
function reports_render(id,type,stack) {
            $('#loader-2').show();
			if(stack === '1'){
				stack = '&stack=' + stack;
				}
			else {
				stack = '';
				}	
					group = 'day'
			period_start = $("#period_start").val()
			period_end = $("#period_end").val()
			if(period_start === period_end){
				period_start = $("#period_start_7").val()
				
				}
			
			canals = $("#canals").val()
            forma = $("#reportsform2").serialize() + '&type_charts=' + type+ stack;
            $.ajax({
                type: "get",
                url: '/reports/' + id,
                data: {'group':group,'period_start':period_start,'canals':canals, 'period_end':period_end, 'type_charts':type},
                success: function (html1) {
                    datatotable = JSON.parse(html1);
                    $('#loader-2').hide();
                    var chartHolder = document.querySelector('.js-analytics');

                        line_gr_new(datatotable, chartHolder)
               
             


				}
            })


        }

$(".chart-js-block li").on('click', function(){
	if(!$(this).is('.active')){
	stack = $(this).attr('data-stack');
	$(".chart-js-block li").removeClass('active');
	$(this).addClass('active');
	type = $(this).attr('data-type');
	vals = $('.select_my_report.sactive').data('valur');
  	reports_render(1,type,stack);
	}
	})
	
	

	
  			var chartHolder_doughnut = document.querySelector('.js-analytics-doughnut');
        
                chart_doughnut = echarts.init(chartHolder_doughnut);
                var labelOption = {
                    normal: {
                        show: true,
                        position: 'insideBottom',
                        distance: 40,
                        align: 'left',
                        verticalAlign: 'middle',
                        rotate: 90,
                      
                        fontSize: 14 

                    } 

                };
	
				
 function doughnut_gr(data_val_name,data_name) {
option = {
    tooltip: {
        trigger: 'item',
        formatter: '{b}: {c} ({d}%)'
    },
    legend: {
        orient: 'vertical',
        right: 10,
		 type: 'scroll',
		top: 100,
        bottom: 50,
		    pageIcons: {
            horizontal:''
            
        },
/*		formatter: function (name,value) {
    return name;
},*/
        data: data_name
    },
    series: [
        {
            name: 'ТОП рекламных каналов по заявкам',
            type: 'pie',
            radius: ['40%', '60%'],
			  center: ['24%', '50%'],
            avoidLabelOverlap: false,
            label: {
                
                normal: {
                    show: false,
                    position: 'center',
                    formatter: '{b}'
                },
                emphasis: {
                    show: true,
                    textStyle: {
                        fontSize: '20',
                        fontWeight: 'bold',
                        fontFamily: 'sans-serif',
                        lineHeight: 10
                    }
                }
            },
            labelLine: {
                normal: {
                    show: true
                }
            },
            data: data_val_name
        }
    ]
};

	 chart_doughnut.setOption(option, true);
	
        }				

  Array.prototype.sum = function (prop) {
    var total = 0
    for ( var i = 0, _len = this.length; i < _len; i++ ) {
        total += Number(this[i][prop])
    }
    return total
}  




function reports_doughnut(data_start,data_end,data_type){

            $.ajax({
                type: "get",
                url: '/reportsconstruct/1',
                data: {'resourse_names': 'sdelka,lead','period_start': data_start,'period_end': data_end},
                success: function (data) {
                    datatotable = JSON.parse(data);
					array = [];
					array2 = [];
					datatotable.sort(function(a, b) {
    return b.sdelka -  a.sdelka ;
});

all_sdelka = datatotable.sum("sdelka")
$('.itogo-chart .summ-itogo').html(all_sdelka)
$('.itogo-chart').addClass('active');
 $('.table-chart-body').html('')
 	data_chesk =0;
					$(datatotable).each(function(index, element) {
						if(element.sdelka >0){
							data_chesk = 1;
							color = '#37A2DA'
							if(element.typ === 'organic'){color = '#37A2DA'}
							if(element.typ === 'utm'){color = '#66E0E3'}
							if(element.typ === 'AdwordsApi'){
								element.typ ='Google Ads';
								color = '#FEDB5B'}
							if(element.typ === 'Директ'){color = '#FF9F7F'}
							if(element.typ === 'typein'){color = '#E061AE'}
							if(element.typ === 'referral'){color = '#65DB7C'}
							
							
                        array.push({value:element.sdelka,name:element.typ, itemStyle:{color:color}});
						procent = ((Number(element.sdelka)/all_sdelka)*100).toFixed(2)
						
						 $('.table-chart-body').append('<div class="tr-table-chart active" data-name="'+element.typ+'"><div class="td-1 " ><div style=" background:'+color+'"></div>'+element.typ+'</div><div class="td-2">'+element.sdelka+'</div><div class="td-3">'+procent+'%</div></div>');

					
						
						array2.push(element.typ);}
						
						
                    });
					
if(data_chesk === 0)
{	

$('.table-chart-no-data').css('display','block');		
$('.table-chart-grafick').css('display','none');
							$('.itogo-chart').removeClass('active');}	
							else{
								$('.table-chart-no-data').css('display','none');
								$('.table-chart-grafick').css('display','block');
							$('.itogo-chart').addClass('active');
								}					
             	
doughnut_gr(array,array2)
$( ".table-chart-body .tr-table-chart", document ).hover(function(){ 
name = $(this).attr('data-name')
$('.itogo-chart').removeClass('active')
	 chart_doughnut.dispatchAction({
    type: 'highlight',
    name: name
})
	    }, function(){ 
		name = $(this).attr('data-name')
		$('.itogo-chart').addClass('active')
		
	  chart_doughnut.dispatchAction({
    type: 'downplay',
    name: name
})
});





                }
            })
	}			
					
reports_doughnut('<?=date("Y-m-d", strtotime($stat_start_date))?>','<?=date("Y-m-d", strtotime($stat_end_date))?>')	
	
$(document).on('click','.table-chart-body .tr-table-chart',function(){
	name = $(this).attr('data-name')
if($(this).is('.active')){
$(this).removeClass('active');
chart_doughnut.dispatchAction({
    type: 'legendUnSelect',
    // legend name
    name: name
})	
		}
		else{
			$(this).addClass('active');
chart_doughnut.dispatchAction({
    type: 'legendSelect',
    // legend name
    name: name
})	
			}
	
	
	})
	
	$(window).resize(function() {
	chart.resize()
	chart_doughnut.resize()
	
});


chart_doughnut.on('mouseover', function (params) {
    $('.itogo-chart').removeClass('active')
});

chart_doughnut.on('mouseout', function (params) {
    $('.itogo-chart').addClass('active')
});
$('.sidebar-main-toggle-menu').on('click',function(){
		setTimeout(chart.resize, 200); 
		setTimeout(chart_doughnut.resize, 200); 
})

function top_for_block(data_start,data_end,data_type){
	
	if(data_start === data_end){
		group_1 = 'hours';
		}
	else{
		group_1 = data_type;
		}
		
	
		
			
	$.ajax({
                type: "get",
                url: '/reportsconstruct/1',
                data: {'resourse_names': 'sdelka,lead,posetitel,summ','period_start': data_start,'period_end': data_end,'group': group_1},
                success: function (data) {
datatotable = JSON.parse(data);
data_array_sdelka = [];
data_array_index = [];
data_array_lead = [];
data_array_posetitel = [];
data_array_summ = [];
console.log(datatotable);
sdelka = 0;
lead = 0;
posetitel = 0;
summ = 0;

for(key in datatotable) {
 data_array_sdelka.push(Number(datatotable[key].sdelka));
  data_array_lead.push(Number(datatotable[key].lead));
  
  data_array_posetitel.push(Number(datatotable[key].posetitel));
  data_array_summ.push(  {date: key, alpha: datatotable[key].summ});
  
  lead = lead+Number(datatotable[key].lead);
  sdelka = sdelka+Number(datatotable[key].sdelka);
  posetitel = posetitel+Number(datatotable[key].posetitel);
	summ = summ+Number(datatotable[key].summ);

 data_array_index.push(key);
}

$('.bg-pink-400 .no-margin').html(sdelka)
$('.bg-blue-400 .no-margin').html(lead)
$('.bg-teal-400 .no-margin').html(posetitel)
$('.bg-orange-400 .no-margin').html(summ)


 $("#members-online-new-1, #members-online-new-2, #server-load, #today-revenue").html('')
	generateBarChart_new("#members-online-new-1", 24, 70, true, "elastic", 1200, 70, "rgba(255,255,255,0.5)", group_1,data_array_sdelka,data_array_index);
	generateBarChart_new("#members-online-new-2", 24, 70, true, "elastic", 1200, 70, "rgba(255,255,255,0.5)", group_1,data_array_lead,data_array_index);
	generateBarChart_new("#server-load", 24, 70, true, "elastic", 1200, 70, "rgba(255,255,255,0.5)", group_1,data_array_posetitel,data_array_index);
dailyRevenue('#today-revenue', 70, data_array_summ,data_array_index); // initialize chart
                }
            })
	
	}

   function generateBarChart_new(element, barQty, height, animate, easing, duration, delay, color, tooltip, Data_array,data_array_index) {
		barQty = Data_array.length
	
        var d3Container = d3.select(element),
            width = d3Container.node().getBoundingClientRect().width;
	
        var x = d3.scale.ordinal()
            .rangeBands([0, width], 0.3)

        var y = d3.scale.linear()
            .range([0, height]);

        x.domain(d3.range(0, Data_array.length))

        y.domain([0, d3.max(Data_array)])

        var container = d3Container.append('svg');

        var svg = container
            .attr('width', width)
            .attr('height', height)
            .append('g');

        var bars = svg.selectAll('rect')
            .data(Data_array)
            .enter()
            .append('rect')
            .attr('class', 'd3-random-bars')
            .attr('width', x.rangeBand())
            .attr('x', function(d,i) {
                return x(i);
            })
            .style('fill', color);


        var tip = d3.tip()
            .attr('class', 'd3-tip')
            .offset([-10, 0]);

        // Show and hide
	
        if(tooltip == "hours" || tooltip == "day" || tooltip == "week" || tooltip == "month") {
            bars.call(tip)
                .on('mouseover', tip.show)
                .on('mouseout', tip.hide);
        }

        if(tooltip == "hours") {
            tip.html(function (d, i) {
				string = data_array_index[i].split('-')
         return "<div class='text-center'>" +
                    "<h6 class='no-margin'>" + d + "</h6><div class='text-size-small'>" + string[1] + ":00" + "</div>" +
                    "</div>"
            });
        }

        if(tooltip == "day" || tooltip == "week" || tooltip == "month") {
            tip.html(function (d, i) {
                return "<div class='text-center'>" +
                    "<h6 class='no-margin'>" + d + "</h6><div class='text-size-small'>" + data_array_index[i] + "" + "</div>" +
                    "</div>"
            });
        }

        // Online members tooltip content
        if(tooltip == "members") {
            tip.html(function (d, i) {
                return "<div class='text-center'>" +
                    "<h6 class='no-margin'>" + d +  "</h6>" +
                    "<span class='text-size-small'> </span>" +
                    "<div class='text-size-small'>" + i + ":00" + "</div>" +
                    "</div>"
            });
        }



        // Bar loading animation
        // ------------------------------

        // Choose between animated or static
        if(animate) {
            withAnimation();
        } else {
            withoutAnimation();
        }

        // Animate on load
        function withAnimation() {
            bars
                .attr('height', 0)
                .attr('y', height)
                .transition()
                .attr('height', function(d) {
                    return y(d);
                })
                .attr('y', function(d) {
                    return height - y(d);
                })
                .delay(function(d, i) {
                    return i * delay;
                })
                .duration(duration)
                .ease(easing);
        }

        // Load without animateion
        function withoutAnimation() {
            bars
                .attr('height', function(d) {
                    return y(d);
                })
                .attr('y', function(d) {
                    return height - y(d);
                })
        }


        $(window).on('resize', barsResize);

        // Call function on sidebar width change
        $(document).on('click', '.sidebar-control', barsResize);

      
        function barsResize() {

            // Layout variables
            width = d3Container.node().getBoundingClientRect().width;



            container.attr("width", width);

            // Width of appended group
            svg.attr("width", width);

            // Horizontal range
            x.rangeBands([0, width], 0.3);


            // Chart elements
            // -------------------------

            // Bars
            svg.selectAll('.d3-random-bars')
                .attr('width', x.rangeBand())
                .attr('x', function(d,i) {
                    return x(i);
                });
        }
    }
	

	function dailyRevenue(element, height, data_array,data_array_index) {


        // Basic setup
        // ------------------------------

        // Add data set

        // Main variables
        var d3Container = d3.select(element),
            margin = {top: 0, right: 0, bottom: 0, left: 0},
            width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right,
            height = height - margin.top - margin.bottom,
            padding = 20;

        // Format date
        var parseDate = d3.time.format("%Y-%m-%d").parse,
            formatDate = d3.time.format("%a, %B %e");
        formatDate2 = d3.time.format("%d.%m.%Y");


        // Add tooltip
        // ------------------------------

        var tooltip = d3.tip()
            .attr('class', 'd3-tip')
            .html(function (d) {
                return "<ul class='list-unstyled mb-5'>" +
                    "<li>" + "<div class='text-size-base mt-5 mb-5'><i class='icon-check2 position-left'></i>" + formatDate2(d.date) + "</div>" + "</li>" +
                    "<li>" + "Сумма: &nbsp;" + "<span class='text-semibold pull-right'>" + d.alpha + "</span>" + "</li>" +
"</ul>";
            });



        // Create chart
        // ------------------------------

        // Add svg element
        var container = d3Container.append('svg');

        // Add SVG group
        var svg = container
            .attr('width', width + margin.left + margin.right)
            .attr('height', height + margin.top + margin.bottom)
            .append("g")
            .attr("transform", "translate(" + margin.left + "," + margin.top + ")")
            .call(tooltip);



        // Load data
        // ------------------------------

        data_array.forEach(function (d) {
            d.date = parseDate(d.date);
            d.alpha = +d.alpha;
        });



        // Construct scales
        // ------------------------------

        // Horizontal
        var x = d3.time.scale()
            .range([padding, width - padding]);

        // Vertical
        var y = d3.scale.linear()
            .range([height, 5]);



        // Set input domains
        // ------------------------------

        // Horizontal
        x.domain(d3.extent(data_array, function (d) {
            return d.date;
        }));

        // Vertical
        y.domain([0, d3.max(data_array, function (d) {
            return Math.max(d.alpha);
        })]);



        // Construct chart layout
        // ------------------------------

        // Line
        var line = d3.svg.line()
            .x(function(d) {
                return x(d.date);
            })
            .y(function(d) {
                return y(d.alpha)
            });



        //
        // Append chart elements
        //

        // Add mask for animation
        // ------------------------------

        // Add clip path
        var clip = svg.append("defs")
            .append("clipPath")
            .attr("id", "clip-line-small");

        // Add clip shape
        var clipRect = clip.append("rect")
            .attr('class', 'clip')
            .attr("width", 0)
            .attr("height", height);

        // Animate mask
        clipRect
            .transition()
            .duration(1000)
            .ease('linear')
            .attr("width", width);



        // Line
        // ------------------------------

        // Path
        var path = svg.append('path')
            .attr({
                'd': line(data_array),
                "clip-path": "url(#clip-line-small)",
                'class': 'd3-line d3-line-medium'
            })
            .style('stroke', '#fff');

        // Animate path
        svg.select('.line-tickets')
            .transition()
            .duration(1000)
            .ease('linear');



        // Add vertical guide lines
        // ------------------------------

        // Bind data
        var guide = svg.append('g')
            .selectAll('.d3-line-guides-group')
            .data(data_array);

        // Append lines
        guide
            .enter()
            .append('line')
            .attr('class', 'd3-line-guides')
            .attr('x1', function (d, i) {
                return x(d.date);
            })
            .attr('y1', function (d, i) {
                return height;
            })
            .attr('x2', function (d, i) {
                return x(d.date);
            })
            .attr('y2', function (d, i) {
                return height;
            })
            .style('stroke', 'rgba(255,255,255,0.3)')
            .style('stroke-dasharray', '4,2')
            .style('shape-rendering', 'crispEdges');

        // Animate guide lines
        guide
            .transition()
            .duration(1000)
            .delay(function(d, i) { return i * 150; })
            .attr('y2', function (d, i) {
                return y(d.alpha);
            });



        // Alpha app points
        // ------------------------------

        // Add points
        var points = svg.insert('g')
            .selectAll('.d3-line-circle')
            .data(data_array)
            .enter()
            .append('circle')
            .attr('class', 'd3-line-circle d3-line-circle-medium')
            .attr("cx", line.x())
            .attr("cy", line.y())
            .attr("r", 3)
            .style('stroke', '#fff')
            .style('fill', '#29B6F6');



        // Animate points on page load
        points
            .style('opacity', 0)
            .transition()
            .duration(250)
            .ease('linear')
            .delay(1000)
            .style('opacity', 1);


        // Add user interaction
        points
            .on("mouseover", function (d) {
                tooltip.offset([-10, 0]).show(d);

                // Animate circle radius
                d3.select(this).transition().duration(250).attr('r', 4);
            })

            // Hide tooltip
            .on("mouseout", function (d) {
                tooltip.hide(d);

                // Animate circle radius
                d3.select(this).transition().duration(250).attr('r', 3);
            });

        // Change tooltip direction of first point
        d3.select(points[0][0])
            .on("mouseover", function (d) {
                tooltip.offset([0, 10]).direction('e').show(d);

                // Animate circle radius
                d3.select(this).transition().duration(250).attr('r', 4);
            })
            .on("mouseout", function (d) {
                tooltip.direction('n').hide(d);

                // Animate circle radius
                d3.select(this).transition().duration(250).attr('r', 3);
            });

        // Change tooltip direction of last point
        d3.select(points[0][points.size() - 1])
            .on("mouseover", function (d) {
                tooltip.offset([0, -10]).direction('w').show(d);

                // Animate circle radius
                d3.select(this).transition().duration(250).attr('r', 4);
            })
            .on("mouseout", function (d) {
                tooltip.direction('n').hide(d);

                // Animate circle radius
                d3.select(this).transition().duration(250).attr('r', 3);
            })


    }
		
		top_for_block('<?=date("Y-m-d", strtotime($stat_start_date))?>','<?=date("Y-m-d", strtotime($stat_end_date))?>', 'day')	
</script>  
    
    
<script>
<?php /*?>    @foreach($my_reports as $my_report)
    reports({{$my_report->id}});
    @endforeach<?php */?>


    function reports(id) {
        forma = $("#reportsform").serialize();
        //    document.querySelector('.js-analytics').innerHTML='';
        $.ajax({
            type: "get",
            url: '/reports/' + id,
            data: forma,
            success: function (html1) {
                datatotable = JSON.parse(html1);


                var chartHolder = document.querySelector('.js-analytics'+id);

                if (datatotable['type'] == 'line') {
                    line_gr(datatotable, chartHolder)
                }
                if (datatotable['type'] == 'funnel') {
                    var chartHolder = document.querySelector('.js-analytics'+id);
                    funnel_gr(datatotable, chartHolder)
                }


            }
        })


    }
    function funnel_gr(datatotable, chartHolder) {

        if (chartHolder) {
            var chartHolderWidth = chartHolder.parentNode.clientWidth;
            chartHolder.style.width = chartHolderWidth + 'px';
            chart = echarts.init(chartHolder);
            var labelOption = {
                normal: {
                    show: false,
                    position: 'insideBottom',
                    distance: 60,
                    align: 'left',
                    verticalAlign: 'middle',
                    rotate: 90,
                    // formatter: '{c}  {name|{a}}',
                    fontSize: 14 // rich: {
                    //     name: {
                    //         textBorderColor: '#fff'
                    //     }
                    // }

                } // specify chart configuration item and data

            };
            option = {
                color: ['#2d7bcb', '#3ed25a', '#eff70b', '#f7210b', '#f80aea', '#a10af8', '#faa106'],
                tooltip: {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c}%"
                },

                legend: {


                },
                series: [
                    {
                        name:' ',
                        type:'funnel',
                        left: '10%',
                        top: 100,
                        //x2: 80,
                        bottom: 10,
                        width: '80%',
                        // height: {totalHeight} - y - y2,
                        min: 0,
                        max: 100,
                        minSize: '0%',
                        maxSize: '100%',
                        sort: 'descending',
                        gap: 1,
                        label: {
                            show: false,
                            position: 'inside'
                        },
                        labelLine: {
                            length: 10,
                            lineStyle: {
                                width: 1,
                                type: 'solid'
                            }
                        },
                        itemStyle: {
                            borderColor: '#fff',
                            borderWidth: 1
                        },
                        emphasis: {
                            label: {
                                fontSize: 0
                            }
                        },
                        data: datatotable['series']
                    }

                ]
            };


            chart.setOption(option, true);
        }

    }
    function line_gr(datatotable, chartHolder) {


        if (chartHolder) {
            var chartHolderWidth = chartHolder.parentNode.clientWidth;
            chartHolder.style.width = chartHolderWidth + 'px';
            chart = echarts.init(chartHolder);
            var labelOption = {
                normal: {
                    show: false,
                    position: 'insideBottom',
                    distance: 40,
                    align: 'left',
                    verticalAlign: 'middle',
                    rotate: 90,
                    // formatter: '{c}  {name|{a}}',
                    fontSize: 14 // rich: {
                    //     name: {
                    //         textBorderColor: '#fff'
                    //     }
                    // }

                } // specify chart configuration item and data

            };
            var option = {
                /*title: {
                    text: 'График', left: 'center'
                },*/
                grid: {
                    left: 60,
                    top: 5,
                    right: 10,
                    bottom: 50,
                    backgroundColor: '#006699'
                },
                color: ['#2d7bcb', '#3ed25a', '#eff70b', '#f7210b', '#f80aea', '#a10af8', '#faa106'],
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        type: 'shadow'
                    }
                },
                legend: {
                    type:'scroll',
                    bottom:100,
                    data: datatotable['names'],
                    orient: 'horizontal',
                    left: 'center',
                    top: 'bottom',


                },

                calculable: true,
                xAxis: [{
                    type: 'category',
                    axisTick: {
                        show: false
                    },
                    data: datatotable['dates']// ['2012', '2013', '2014', '2015', '2016']
                }],
                yAxis: [{
                    type: 'value'
                }],
                series: datatotable['series']
            }; // use configuration item and data specified to show chart

            chart.setOption(option, true);

        }

    }
    function create_reports() {

        forma = $('#formCreateReports').serialize();
        llname = $('#namedd').val();
        if (llname.length == 0) {
            alert('Название отчета')
            return false;
        }
        $('#myModalCreateRestort').modal('hide');
        $.ajax({
            type: "POST",
            url: '/allreports/create_w',
            data: forma,
            success: function (html1) {
                m = JSON.parse(html1)
              window.location.reload()

            }
        })


    }
</script>


@endsection


