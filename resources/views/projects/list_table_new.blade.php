@extends('app')
@section('title')
    Клиенты
@endsection
@section('content')

    <script type="text/javascript" src="/default/assets/js/plugins/ui/moment/moment.min.js"></script> <div class="row">
        <script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>




        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>

        <!-- Basic sorting -->

        <div class="panel panel-flat" style="background:none; box-shadow: none; margin-bottom: 0px;">


            <div class="panel-body" style="padding-top: 0px;">


                <div class="row" id="basic-tab0" style="    margin-top: 20px;">
                    <?php /*?><div class="col-md-12">
                        <button type="button" class="btn btn-link daterange-ranges heading-btn text-semibold">
                            <i class="icon-calendar3 position-left"></i> <span>{{$start_date}}-{{$end_date}}</span> <b class="caret"></b>
                        </button>
                    </div><?php */?>
                    <div class="col-md-12" style="padding-left:0px; padding-right:0px;">


                        <table class="table table-bordered table-hover users-table" id="users-table">
                            <thead>
                            <tr class="no-open">
                                <th class="col-1">ID</th>
                                <th class="col-2">Название сделки</th>
                                <th class="col-3">Контакт</th>
                              	<th class="col-4">Дата создания</th>
                                <th class="col-5">Запись/E-mail</th>
                                <th class="col-6">Этап</th>
                                <th class="col-7">Телефон</th>
                            </tr>
                            </thead>

                     <?php /*?><tfoot>
					<tr>


                                 <th class="col-0-wis">ID</th>
                                <th class="col-1-wis">Название сделки</th>
                                <th class="col-2-wis">Контакт</th>
                              	<th class="col-3-wis">Дата создания</th>
                                <th class="col-4-wis">Запись/E-mail</th>
                                <th class="col-5-wis">Этап</th>
                                <th class="col-6-wis">Телефон</th>
					</tr>
				</tfoot><?php */?>
                        </table>

                    </div>
                </div>


            </div>
        </div>


        <!-- /basic sorting -->





        @include('modal.modalemail')




        @endsection
        @section('skriptdop')


    @include('projects.modal.project_add')


    <style>#ClientInfoModal.modal.fade:not(.in) .modal-dialog {
        -webkit-transform: translate3d(25%, 0, 0);
        transform: translate3d(25%, 0, 0);
    }
    .content{
		    padding-bottom: 0px;
    margin-bottom: 0px;
		}

    </style>


<?php /*?><link rel="stylesheet" href="/css/daterangepicker.css"><?php */?>
<script src="/js/daterangepicker3.js"></script>
<script src="/js/dataTables.fixedHeader.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<?php /*?>                            <button type="button" class="btn btn-link daterange-ranges heading-btn text-semibold">
                            <i class="icon-calendar3 position-left"></i> <span>{{$start_date}}-{{$end_date}}</span> <b class="caret"></b>
                        </button>  <?php */?>

            <script>
	function AddLiddProgect(){

		  $('#ClientInfoModalAdd').modal('show');

		}

	$('input[name=promokod]').keyup(function(){
		if($(this).val() === ''){
			$('.create-lid').css('visibility','hidden');

			}else{
		$('.create-lid').css('visibility','visible');}

		})


		var_select = '{{$project_vid}}';
	if(var_select === '0'){
		$('.change-visable-lids .icon-bars-alt').addClass('text-primary');
		$('.change-visable-lids .icon-bars-alt').closest('li').addClass('disabled')
		}
	else{
		$('.change-visable-lids .icon-paragraph-justify3').addClass('text-primary');
		$('.change-visable-lids .icon-paragraph-justify3').closest('li').addClass('disabled')
		}


/*	$(document).mouseup(function (e){ // событие клика по веб-документу
		var div = $("thead tr th div.active");
		var div2 = $("thead tr th"); // тут указываем ID элемента
		if (!div.is(e.target) // если клик был не по нашему блоку
		    && div.has(e.target).length === 0) { // и не по его дочерним элементам
			if(div2.has(e.target).length !== 0){ div.removeClass('active');
		$('thead tr th').removeClass('active-filtr');}
		}
	});	*/


$(document).on('click',function(){
	/*console.log($(event.target).closest("th div.active").length);*/
	if($(event.target).closest("th div.active").length === 1){
	/*	$('thead tr th div').removeClass('active');
		$('thead tr th').removeClass('active-filtr');*/

		}
	else{
		if(!$('div',event.target).hasClass('active')){
			if(!$(event.target).hasClass('table')){
				if(!$(event.target).hasClass('no-open')){
				if(!$(event.target).hasClass('panel-body')){
				if(!$(event.target).hasClass('content-wrapper')){
				if(!$(event.target).hasClass('panel-flat')){


					$('thead tr th div').removeClass('active');
					$('thead tr th').removeClass('active-filtr');
					$(event.target).addClass('active-filtr');
					$('div', $(event.target)).addClass('active');
					$('div input', $(event.target)).focus();
			/*console.log(event.target)*/
					}
					}
					}}
		    }
		}
		else{

		$('thead tr th div').removeClass('active');
		$('thead tr th').removeClass('active-filtr');

			}

		}


	})

$(document).mouseup(function (e) {

	    var container2 = $("tbody tr td input, tbody tr td .fa-pencil");
    if (container2.has(e.target).length === 0){
   $('tbody tr td .fa-floppy-o.active').each(function(){

		th = $(this).closest('td').find('input');
		if($(th).val() === $(th).attr('data-old-val') ){
			$(this).closest('td').find('.fa-floppy-o').removeClass('active')
			$(this).closest('td').find('input').attr('readonly', 'readonly');
			}


		});
    }


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





/*	$('thead tr th').on('click',function(){
		if(!$('div',this).hasClass('active')){
		$('thead tr th div').removeClass('active');
		$('thead tr th').removeClass('active-filtr');
		$(this).addClass('active-filtr');
		$('div', $(this)).addClass('active');
		$('div input', $(this)).focus();}
		else{
				$('thead tr th div').removeClass('active');
		$('thead tr th').removeClass('active-filtr');
			}
		})*/


	$(document).on('click', 'thead tr th .btn-info', function(){
		$(this).closest('th').find('input').val('');
		$('thead tr th div').removeClass('active');
		$(this).closest('th').removeClass('active-filtr');

		})


$(document).on('click','tbody tr td input, tbody tr td .fa-pencil', function(){
	pencil = $(this).closest('td').find('.fa-pencil');
	if($('tbody tr td fa-floppy-o')){

		}
	$('tbody tr td .fa-floppy-o.active').each(function(){
		th = $(this).closest('td').find('input');
		if($(th).val() === $(th).attr('data-old-val') ){
			$(this).closest('td').find('.fa-floppy-o').removeClass('active')
			$(this).closest('td').find('input').attr('readonly', 'readonly');
			}


		});

	if($(pencil).hasClass("active")){
	$(pencil).removeClass('active');
	$(pencil).closest('td').find('.fa-floppy-o').addClass('active');
	$(pencil).closest('td').find('input').removeAttr('readonly'); }



	})


//SDELKI MODAL
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





//SAVE INPUT TABLE
$(document).on('click','tbody tr td .fa-floppy-o', function(){
	$(this).closest('td').find('input').attr('readonly','readonly');
	$(this).removeClass('active');
	$(this).closest('td').find('.fa-pencil').addClass('active');
	input_val = $(this).closest('td').find('input').val();
	lid_id = $(this).closest('td').find('input').data('input-cont-id');
	input_name = $(this).closest('td').find('input').data('input-name');
    $.ajax({
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
    })



	})



//SAVE INPUT SDELKI	MODAL
$(document).on('click','#info .form-group .fa-floppy-o', function(){
	$(this).closest('div').find('input').attr('readonly','readonly');
	$(this).removeClass('active');
	$(this).closest('div').find('.fa-pencil').addClass('active');
	input_val = $(this).closest('div').find('input').val();
	lid_id = $(this).closest('div').find('input').data('input-cont-id');
	input_name = $(this).closest('div').find('input').data('input-name');
	console.log(input_val);
	console.log(lid_id);
	console.log(input_name);

	console.log(lid_id);
	 mynotif( 'Успешно!','Изменения успешно сохранены','info')

     $.ajax({
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
    })



	})




/*	$(document).on('hover','.users-table.table tbody tr',    function() {
		alert('removeClass')
      $('td .fa-pencil' ,this ).removeClass('active');
    }, function() {
		alert('addClass')
      $('td .fa-pencil' ,this ).addClass('active');
    })*/



$(document).on('mouseover','.users-table.table tbody tr', function(){

	 $('td .fa-floppy-o' ,this ).each(function(){

			if(!$(this).hasClass("active")){
		 $(this).closest('td').find('.fa-pencil').addClass('active');
		}

		});
	});
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



$(document).on('mouseleave','.users-table.table tbody tr', function(){
	$('td .fa-pencil' ,this ).removeClass('active');

	})





$('#users-table thead th').each(function() {
    var title = $(this).text();
	if(title === 'Дата создания'){
/*		    $(this).html(''+title+'<div><button type="button" class="btn btn-link daterange-ranges heading-btn text-semibold"><i class="icon-calendar3 position-left"></i> <span>{{$start_date}}-{{$end_date}}</button><button type="button" class="btn btn-default">Применить</button><button type="button" class="btn btn-info">Отмена</button></div>');*/
			$(this).html(''+title+'');
			$(this).addClass('daterange-ranges');

		}
		else{
	$(this).html(''+title+'<div><input type="text" placeholder="Поиск '+title+'" /><button type="button" class="btn btn-default">Применить</button><button type="button" class="btn btn-info">Отмена</button></div>');
			}



  });


table =    $('#users-table').DataTable({
language:{
  "processing": "Подождите...",
  "search": "Поиск:",
  "lengthMenu": "Показать _MENU_ записей",
  "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
  "infoEmpty": "Записи с 0 до 0 из 0 записей",
  "infoFiltered": "(отфильтровано из _MAX_ записей)",
  "infoPostFix": "",
  "loadingRecords": "Загрузка записей...",
  "zeroRecords": "Записи отсутствуют.",
  "emptyTable": "В таблице отсутствуют данные",
  "paginate": {
    "first": "Первая",
    "previous": "Предыдущая",
    "next": "Следующая",
    "last": "Последняя"
  },},
"dom": '<"top">rt<"bottom"ilp><"clear">',
                        processing: true,
                        serverSide: true,
						responsive: true,
						searching: true,
						lengthMenu: [ 10, 20, 40, 60, 80, 100 ],
						displayLength: 40,
                        ajax: '/alldata/data',
						initComplete: function() {
					$("#users-table").wrapAll("<div class='table-responsive table-recponsiv-block'></div>");
					$(".table-responsive").floatingScroll();
      				var api = this.api();
						setTimeout(function(){
						table.fixedHeader.adjust()
						}, 10);

					$('.daterange-ranges').on('apply.daterangepicker', function(ev, picker) {
				date_serch =  picker.startDate.format('YYYY-MM-DD')+ '|'+picker.endDate.format('YYYY-MM-DD');
				  api.columns(3).search(date_serch).draw()
					});

					  api.columns().every(function() {
						var that = this;



						$('div .btn-default', this.header()).on('click', function(e) {

							this_val = $(this).closest('div').find('input').val();
						  if (that.search() !== this_val) {
							that.search(this_val).draw();
						  }
						});



						$('div .btn-info', this.header()).on('click', function(e) {
						/* $('thead tr th div').removeClass('active');*/


							this_val = '';

						  if (that.search() !== this_val) {
							that
							  .search(this_val)
							  .draw();
						  }
						});

					  });
					},
                        columns: [
                            { data: 'client_project_id', name: 'client_project_id' },
							{ data: 'widgets_name', name: 'widgets_name' },
							{ data: 'projects_fio', name: 'projects_fio' },
							{ data: 'projects_created_at', name: 'projects_created_at' },
                            { data: 'projects_email', name: 'projects_email' },
                            { data: 'stages_name', name: 'stages_name' },
                        	{ data: 'projects_phone', name: 'projects_phone' },
                        ],
        columnDefs: [
		{ "orderable": false, "targets": 0 },
		{
            targets: 2,
			"orderable": false,
            render: function(data, type, row, meta) {
                if (type === 'display') {
						if(data ===  null){
							data = ''
						}

					data = '<input type="text" readonly data-input-name="projects_fio" data-input-cont-id="'+row.projects_id+'" value="' + data + '" data-old-val="' + data + '"><i class="fa fa-pencil" aria-hidden="true"></i><i class="fa fa-floppy-o" aria-hidden="true"></i>';
                }

                return data;
            }
        },
		{
            targets: 3,
			"orderable": false,
	/*		type: 'de_datetime',*/
            render: function(data, type, row, meta) {
                if (type === 'display') {
					data_no_second = data.split(':');

					new_format = data_no_second[0].split('-')
					new_format_1 = new_format[2].split(' ');
					new_format = new_format_1[0]+'.'+new_format[1]+'.'+new_format[0]
					true_Date = '<?=date('d.m.Y')?>';

					if(new_format === true_Date){
						new_format = 'Сегодня';
						}

					data = '' + new_format + ' '+new_format_1[1]+':'+data_no_second[1];
                }

                return data;
            }
        },
		{ "orderable": false, "targets": 4 },
		{
            targets: 5,
			"orderable": false,
            render: function(data, type, row, meta) {
                if (type === 'display') {
					data = '<span class="leads__status-label" style="background-color: '+row.stages_color+'"><span class="block-selectable">' + data + '</span></span>';
                }

                return data;
            }
        },
		{
            targets: 6,
			"orderable": false,
            render: function(data, type, row, meta) {
                if (type === 'display') {
						if(data ===  null){
							data = ''
						}
					data = '<input type="text" readonly  data-input-name="projects_phone" data-input-cont-id="'+row.projects_id+'" data-input-tel-id="'+row.projects_id+'" value="' + data + '" data-old-val="' + data + '"><i class="fa fa-pencil" aria-hidden="true"></i><i class="fa fa-floppy-o" aria-hidden="true"></i>';
                }

                return data;
            }
        },
		{
            targets: 1,
			"orderable": false,
            render: function(data, type, row, meta) {
                if (type === 'display') {
					phone_number = row.projects_phone;
					if(phone_number ===  null){
							phone_number = row.projects_id
						}
				console.log(row.projects_amo)
				console.log(row.widgets_tip)
				if(row.projects_amo !== '' && row.widgets_tip === '17'){
				data = row.projects_name
				}
					if(row.projects_amo !== '' && row.widgets_tip === '9'){
						data = 'Письмо от '+row.projects_email
					}


					if(row.projects_bt24 !== '' && row.widgets_tip === '16'){
						data = row.projects_name
					}
                    data = '<a onclick="openclinfo('+row.projects_id+')">' + data + ' '+phone_number+'</a>';
                }

                return data;
            }
        }],
		 "order": [[ 3, "projects_created_at-desc" ]],
		  "lengthChange": true,
 			fixedHeader: true,
			 colReorder: true,
		   "autoWidth": false
                    });



$('.sidebar-main-toggle-menu').on('click',function(){

setTimeout(function(){
table.fixedHeader.adjust()

}, 10);
	})

	$(".table-responsive").floatingScroll();
		setTimeout(function(){
 $(".table-responsive").floatingScroll("update");
}, 500);

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



    $('.daterange-ranges').daterangepicker({
				 "autoApply": false,
				  "linkedCalendars": true,
				     "alwaysShowCalendars": true,
					   "showDropdowns": true,
					   opens: 'left',

	"startDate": "<?=date("d-m-Y", strtotime($start_date))?>",
	"endDate": "<?=date("d-m-Y", strtotime($end_date))?>",
	"maxDate": "21-12-2019",
	"minDate": "01-01-2019",

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



});

$('.daterange-ranges').on('show.daterangepicker', function(ev, picker) {

$("body").addClass("fixed-body");
});


$('.daterange-ranges').on('hide.daterangepicker', function(ev, picker) {

$("body").removeClass("fixed-body");
});




	$(document).on('click','.baneed',function () {

		$.ajax({
			type: "POST",
			url: '/projects/banclient',
			data: {
				neiros_visit:$(this).data('id'),


			},
			success: function (html1) {

				if(html1==1){
					mynotif( 'Успешно!','Клиент забанен','info')
				}else{
					mynotif( 'Успешно!','Клиент удален из бана','info')
				}


			}
		})
	})


            </script>






@endsection
