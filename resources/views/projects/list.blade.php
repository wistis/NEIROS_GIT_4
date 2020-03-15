@extends('app')
@section('title')
Клиенты
@endsection
@section('content')
    <script type="text/javascript" src="/default/assets/js/plugins/ui/moment/moment.min.js"></script>
    
    <script>
    	var ArraySelectCancan = '';
    
	
	var_select = '{{$project_vid}}'; 
	if(var_select === '0'){
		$('.change-visable-lids .icon-bars-alt').addClass('text-primary');
		$('.change-visable-lids .icon-bars-alt').closest('li').addClass('disabled')
		}
	else{
		$('.change-visable-lids .icon-paragraph-justify3').addClass('text-primary');
		$('.change-visable-lids .icon-bars-alt').closest('li').addClass('disabled')
		}	
    </script>

@inject('ProjectController','\App\Http\Controllers\ProjectController')
<input name="_token" type="hidden" value="{{ csrf_token() }}" />







    <!-- Basic sorting -->
<?php /*?><div class="  ">
    <ul class="nav nav-tabs" style="margin-bottom: 0px">
        <li class="active"><a href="#basic-tab0" data-toggle="tab">Сделки</a></li>
        <li><a href="#basic-tab1" data-toggle="tab">Клиенты</a></li>



    </ul>

</div><?php */?>
  <?php /*?><div class="breadcrumb-line breadcrumb-line-component row" style="margin-bottom: 10px;padding: 10px">
                            <div class="col-md-1">Период</div>

                            <div class=" col-md-4">
                                <button type="button" class="btn btn-link daterange-ranges heading-btn text-semibold">
                                    <i class="icon-calendar3 position-left"></i> <span>{{$start_date}}-{{$end_date}}</span> <b class="caret"></b>
                                </button>
                            </div>
                            <div class="col-md-3">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Вид отображения
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <div class="row">
                                            <div class="col-md-6">Воронка</div>
                                            <div class="col-md-6"><input type="radio" name="project_vid" value="0" @if($project_vid==0) checked @endif ></div>


                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">Список</div>
                                            <div class="col-md-6"><input type="radio" name="project_vid" value="1"  @if($project_vid==1) checked @endif></div>


                                        </div>
                                        <button type="button" class="btn btn-primary safe_project_vid" >Сохранить изменения</button>
                                    </div>
                                </div>

                            </div>
                            <ul class="breadcrumb-elements">

                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="icon-gear position-left"></i>
                                        Настройки
                                        <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="/setting/stages"><i class="icon-user-lock"></i> Этапы сделок</a></li>
                                        <li><a href="/setting/projectfield"><i class="icon-statistics"></i>Доп поля сделок</a></li>

                                    </ul>
                                </li>
                            </ul>

                        </div><?php */?>

 <div class="output"></div>
<div class="panel panel-flat" style="background:none; box-shadow: none;">
<?php /*?>    <div class="panel-heading" style="display:none;">


    </div><?php */?>
   
  <div class="pipeline-scroller" id="content" >  
<div class="pipeline__body">
    <div class="panel-body panel-kanban">


      {{--cnfhfn--}}
      
      <div class="pipeline_cell"  data-cat="0"  >
            <div class="name-voronka" style="border-bottom-color: #ccc;">
   
                    
                        <div class="h1-voronka">Неразобранное</div>

                    

            </div>
            <div class="panel panel-white "  ></div>
            <div class="sortable-list connectList agile-list" id="todo_0">
            @foreach($ProjectController->get_fromval('stage_id',0) as $project  )



				

                <div class="agile-item info-element" id="todo_{{$project->id}}" data-id="{{$project->id}}" >

                       <div class="pipeline_leads__top-block"><div class="pipeline_leads__linked-entities">@if($project->fio=="") Фио не указано @else {{$project->fio}} @endif</div><div class="pipeline_leads__top-date">{{date('d.m.Y',strtotime($project->created_at))}}</div></div>

                    <div class="row agile-detail">
                        <div class="col-md-12">
                            <a href="#" onclick="openclinfo({{$project->id}})">
                                @php
                                $phone=$project->phone;
if($phone==''){$phone=$project->client_project_id;}
$name=$project->widget_name;
if($project->projects_amo !== '' && $project->widgets_tip === '17'){
			$name=$project->name;$phone='';
				}
if($project->projects_amo !== '' && $project->widgets_tip === '9'){
						$name = 'Письмо от '.$project->email;
						$phone='';
					}
if($project->projects_bt24 !== '' && $project->widgets_tip === '16'){
						$name = $project->name;$phone=''; 
					}
                                @endphp


                            {{$name}} {{$phone}}
                            </a>
                        </div>
                    </div>



                </div>
            @endforeach
            
            </div>

        </div>



       @foreach($stages as $stage)
        <div class="pipeline_cell"  data-cat="{{$stage->id}}">
           <div class="name-voronka" style="border-bottom-color: {{$stage->color}};">
         
           		<div class="h1-voronka">{{$stage->name}}</div>
            </div>
            <div class="panel panel-white"></div>
            <script>ArraySelectCancan = ArraySelectCancan+' #todo_{{$stage->id}},'; </script>
            <div class="sortable-list connectList agile-list" id="todo_{{$stage->id}}">
            
           @foreach($ProjectController->get_fromval('stage_id',$stage->id) as $project  )
            <div class="agile-item info-element" id="todo_{{$project->id}}" data-id="{{$project->id}}">
                <div class="pipeline_leads__top-block">
                <div class="pipeline_leads__linked-entities">@if($project->fio=="") Фио не указано @else {{$project->fio}} @endif</div>
                    <div class="pipeline_leads__top-date">{{date('d.m.Y',strtotime($project->created_at))}}</div>
                    
                </div>

                <div class="row agile-detail">
                    <div class="col-md-12">
                        <a href="#" onclick="openclinfo({{$project->id}})">
                            @php
                                $phone=$project->phone;
if($phone==''){$phone=$project->client_project_id;}
$name=$project->widget_name;
if($project->projects_amo !== '' && $project->widgets_tip === '17'){
			$name=$project->name;$phone='';
				}
if($project->projects_amo !== '' && $project->widgets_tip === '9'){
						$name = 'Письмо от '.$project->email;
						$phone='';
					}
if($project->projects_bt24 !== '' && $project->widgets_tip === '16'){
						$name = $project->name;$phone='';
					}
                            @endphp


                            {{$name}} {{$phone}}
                        </a>
                    </div>
                </div>


            </div>
@endforeach
    </div>
        </div>
        @endforeach

        </div>
    </div>
 </div>
</div>






@endsection
@section('skriptdop')
    <script>
        function setdate(start, end) {
            start_date = start;
            end_date = end;


            datatosend = {
                start_date: start_date,
                end_date: end_date,


                _token: $('[name=_token]').val(),


            }


            $.ajax({
                type: "POST",
                url: '/projects/start_date',
                data: datatosend,
                success: function (html1) {


                    new PNotify({
                        title: 'Успешно ',
                        text: 'Изменения успешно сохранены',
                        icon: 'icon-success'
                    });
                    window.location.reload();
                }
            })


        }


$(document).mouseup(function (e) {
//SDELKI MODAL		
	var container_lid = $("#info input, #info .fa-pencil");
    if (container_lid.has(e.target).length === 0){
   $('#info .fa-floppy-o.active').each(function(){
				
		th = $(this).closest('div').find('input');
		if($(th).val() === $(th).attr('data-old-val') ){
			$(this).closest('div').find('.fa-floppy-o').removeClass('active')
			$(this).closest('div').find('input').attr('readonly', 'readonly');
			}
			
	
		});
    }
	
	
});		


$(document).on('click','#info div input, #info div .fa-pencil', function(){
	pencil = $(this).closest('div').find('.fa-pencil');
	if($('#info div fa-floppy-o')){
		
		}
	$('#info div .fa-floppy-o.active').each(function(){
		th = $(this).closest('div').find('input');
		if($(th).val() === $(th).attr('data-old-val') ){
			$(this).closest('div').find('.fa-floppy-o').removeClass('active')
			$(this).closest('div').find('input').attr('readonly', 'readonly');
			}
			
	
		});

	if($(pencil).hasClass("active")){
	$(pencil).removeClass('active');
	$(pencil).closest('div').find('.fa-floppy-o').addClass('active');
	$(pencil).closest('div').find('input').removeAttr('readonly'); }
	
	
	
	})		
$(document).on('click','#info .form-group .fa-floppy-o', function(){
	$(this).closest('div').find('input').attr('readonly','readonly');
	$(this).removeClass('active');
	$(this).closest('div').find('.fa-pencil').addClass('active');
	input_val = $(this).closest('div').find('input').val();
	lid_id = $(this).closest('div').find('input').data('input-cont-id');
	input_name = $(this).closest('div').find('input').data('input-name');
	
	 mynotif( 'Успешно!','Изменения успешно сохранены','info')
	
/*    $.ajax({
        type: "POST",
        url: '/projects/save_field',
        data: {
            id:lid_id,
            field:input_name,
            input_val:input_val,

        },
        success: function (html1) {


    mynotif( 'Успешно!','Изменения успешно сохранены','info')
            
        }
    })*/



	})	
//SDELKI MODAL			
	$(document).on('mouseover','#info .form-group', function(){
			if(!$('.fa-floppy-o' ,this ).hasClass("active")){
		 $('.fa-pencil' ,this ).addClass('active');
		}
	})		
//SDELKI MODAL	
$(document).on('mouseleave','#info .form-group', function(){
	$('.fa-pencil' ,this ).removeClass('active');
	
	})		
	
	
    </script>

    <script type="text/javascript" src="/default/assets/js/plugins/pickers/daterangepicker.js"></script>
    <script>    // Daterange picker
        // ------------------------------

        $('.daterange-ranges').daterangepicker(
            {
                startDate: moment().subtract(29, 'days'),
                endDate: moment(),
                minDate: '01/01/2018',
                /* maxDate: '12/31/2016',*/
                dateLimit: {days: 60},
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                opens: 'left',
                applyClass: 'btn-small bg-slate-600 btn-block',
                cancelClass: 'btn-small btn-default btn-block',
                format: 'MM/DD/YYYY'
            },
            function (start, end) {
                $('.daterange-ranges span').html(start.format('D-MM-Y') + ' - ' + end.format('D-MM-Y'));
                setdate(start.format('Y-MM-D'), end.format('Y-MM-D'));
            }
        );

        $('.daterange-ranges span').html('<?=date("d-m-Y", strtotime($start_date))?> - <?=date("d-m-Y", strtotime($end_date))?>');


        function open_email(id) {
            datatosend = {
                id: id,

                _token: $('[name=_token]').val(),


            }


            $.ajax({
                type: "POST",
                url: '/projects/get_email_modal',
                data: datatosend,
                success: function (html1) {
                    res = JSON.parse(html1);
                    $('#e_subject').html(res['subject']);
                    $('#e_from').html(res['from']);
                    $('#e_to').html(res['to']);
                    $('#e_message').html(res['message']);

                    $('#myModalEmail').modal('show');

                }
            })
        }
		
		
		
		        $(document).ready(function(){
			ArraySelectCancan =	ArraySelectCancan.slice(0,-1)
            $("#todo_0, "+ArraySelectCancan+"").sortable({
                connectWith: ".connectList",
	stop: function( event, ui ) {
		id = ui.item.attr('id').split('todo_'); 
		cat_id = ui.item.closest('.pipeline_cell').attr('data-cat')
		console.log(id[1]);
		console.log(cat_id);


        $.ajax({
            type: "POST",
            url: '/projects/edit/updatestage',
            data: {

                id:id[1],
                stage_id:cat_id


            },
            success: function (html1) {


            }
        })


		}
            }).disableSelection();

        });
		
	var prevPos
$('body').on('mousedown', function (evt) {
  $(this).on('mousemove', drag)
  prevPos = {x:evt.clientX, y:evt.clientY}
}).on('mouseup mouseout', function() {
  $(this).off('mousemove', drag)
})
 
function drag(evt) {
  window.scrollBy(prevPos.x - evt.clientX, prevPos.y - evt.clientY)
  prevPos = {x:evt.clientX, y:evt.clientY}
}	
		
$(".pipeline-scroller").floatingScroll();		
		
/*		$( document ).ready(function() {
    var $doc = $(document),
        ratio = $doc.width() / $(window).width(), //отношение окна к общей ширене блока, чтобы тянуть весь блок.
        mousepos, to;
    $doc.on('mousedown', 'body', dragstart);
 
    function dragstart(e) {
		console.log();
        e.preventDefault();
        mousepos = e.screenX;

        $doc.on('mousemove.drag', drag);
        $doc.one('mouseup.drag mouseout.drag', dragstop);
    }
 
    function drag(e) {
        clearTimeout(to);
		
        var delta = (e.screenX - mousepos) * ratio;
				console.log(delta);
        to = setTimeout(function () { // таймаут чтобы события от мыши не перекрывали друг друга, 
            $doc.scrollLeft($doc.scrollLeft() + delta);
            mousepos = e.screenX;
        }, 1);
    }
 
    function dragstop(e) {
        $doc.off('mousemove.drag mouseup.drag mouseout.drag');
    }
 
 
});*/
		
    </script>
@endsection