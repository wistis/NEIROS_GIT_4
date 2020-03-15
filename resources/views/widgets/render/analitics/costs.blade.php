<input name="_token" type="hidden" value="{{ csrf_token() }}" />

   

<div class="col-md-1">

    <button type="button" class="btn btn-link daterange-ranges1 heading-btn text-semibold" data-toggle="tooltip" data-placement="right" title="{{date('d-m-Y')}} - {{date('d-m-Y')}}">
        <i class="icon-calendar3 position-left"></i>
    </button>

</div>
<div class="col-md-4">
<select name="cost_canal"  id="cost_canal" class="form-control" style="width:100%" >
    <option value="0">Рекламный канал</option>
    @foreach($canals as $canal)
    <option value="{{$canal->id}}">{{$canal->name}}</option>

    @endforeach
</select>
</div>
<div class="col-md-4"><input type="text" style="width:100%" class="form-control" id="canal_summ" placeholder="Расход (Сумма)">


    <input type="hidden" class="form-control" value="" id="cost_start_date"  >
    <input type="hidden" class="form-control" value="" id="cost_end_date" >


</div>
                    <div class="col-md-3"><i style="font-size: 23px;visibility: visible;
    position: relative;"  onclick="addcoastcanal()" class="fa fa-floppy-o" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Сохранить"></i>
</div>
              
           
<div class="col-xs-12">
            <table class="table tasks-list table-lg" style=" margin-top:30px;">
                <tbody   id="table_costs">
            @foreach($costs as $cost)

              <tr id="cost{{$cost->id}}">
                  <td >{{$cost->canal_name}}</td>
                  <td >{{$cost->period_start}}</td>
                  <td >{{$cost->period_end}}</td>
                  <td >{{$cost->summ}}</td>

                  <td ><i class="fa fa-trash" onclick="deletecanal({{$cost->id}})"></i> </td>
              </tr>
                @endforeach</tbody>
            </table></div>
<style>
.tooltip .tooltip-arrow{
	display:block;}
.tooltip-inner{
	    white-space: nowrap;
	}	
	
</style>
<script>
    
    $('[data-toggle="tooltip"]').tooltip()
     $('.daterange-ranges1').daterangepicker({
				 "autoApply": false,
				  "linkedCalendars": true,
				     "alwaysShowCalendars": true,
					   "showDropdowns": true,
					   opens: 'right',
format: 'MM/DD/YYYY',
            startDate: moment().subtract(29, 'days'),
            endDate: moment(),
            dateLimit: { days: 60 },


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
	

	
}  ,
            function (start, end) {
			console.log(start.format('Y-MM-DD'))
			console.log(end.format('Y-MM-DD'))
			$('#cost_start_date').val(start.format('Y-MM-DD'));
            $('#cost_end_date').val( end.format('Y-MM-DD'));	
			$('.daterange-ranges1 span').html(start.format('D-MM-Y') + ' - ' + end.format('D-MM-Y'));
            setdate(start.format('Y-MM-D'),end.format('Y-MM-D'));

            }


); 
    </script>