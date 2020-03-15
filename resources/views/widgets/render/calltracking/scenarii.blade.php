<div class="row tab-pane " id="basic-tab3">

    <a class="btn btn-info text-semibold" onClick="edit_routing()"  >Добавить
        сценарий</a>
    <div class="col-md-12">
        <fieldset>
            <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                   {{-- <td>Статус</td>--}}
                    <td>Название</td>
                    <td>Тип подмены</td>
                    <td>Номеров</td>
                {{--    <td>Точность</td>--}}
                    <td>Звонков</td>
                    <td>Дата создания</td>
                    <td>Звонок на</td>
                    <td>Действия</td>
                    <td>Действия</td>


                </tr>
                @foreach($routes as $rout)
                    <tr id="idsr{{$rout->id}}">
                        {{--<td>
                            <div class="checkbox checkbox-switchery ">
                                <label>
                                    <input type="checkbox" class="switchery1"
                                           id="statusrout{{$rout->id}}"
                                           name="status"
                                           @if($rout->status==1) checked="checked"
                                           @endif  data-id="{{$rout->id}}">

                                </label>
                            </div>
                        </td>--}}
                        <td>{{$rout->name}}</td>
                        <td>@if($rout->tip_calltrack==1)  Динамический @else
                                Статический @endif</td>
                        <td>
                            @if(count($rout->phones)>0)
                                <button type="button" class="btn btn-default btn-sm"
                                        data-popup="tooltip"
                                        title="@foreach($rout->phones as $pho)
                                        {{$pho->input}}<br>

                                                  @endforeach             " data-html="trur"
                                        data-trigger="click">{{count($rout->phones)}}</button>@else


                                0 @endif</td>
                        {{--<td>@if($rout->tip_calltrack==1)
                                0% @else   @if(count($rout->phones)>0) 100% @else
                                    0% @endif @endif</td>--}}
                        <td>
                            @if(count($rout->phones)>0)


                                {{$rout->phones->sum('amout_call')}}




                            @else 0 @endif


                        </td>
                        <td>{{date('d-m-Y',strtotime($rout->created_at))}}</td>
                        <td>{{ $rout->number_to}}</td>
                        <td><a href="#"
                               onclick="edit_routing({{$rout->id}});return false;"><i
                                        class="glyphicon  glyphicon-pencil"
                                        style="color: blue"></i> </a></td>
                        <td><a href="#"
                               onclick="delete_routing({{$rout->id}});return false;"><i
                                        class="glyphicon  glyphicon-trash"
                                        style="color: red"></i> </a></td>


                    </tr>
                @endforeach

            </table></div>
        </fieldset>
    </div>
    {{--Дополнительные поля--}}

</div>



    <script>
  $(document).on('click','#tab-add-nomer .dropdown li',function(e){
    e.stopPropagation();
	number = $('#imp_fee_numbers_list li input[type=checkbox]:checked').length;
	if(number > 0){
	$('#dLabel').html('Выбрано '+number+' номера');}
	else{
		$('#dLabel').html('Выберите добавленные номера');
		}

})
    function load_free_numbers3(id) {

        datatosend = {

            id:id,

            _token: $('[name=_token]').val(),
        }


        $.ajax({
            type: "POST",
            url: '/ajax/load_free_numbers3',
            data: datatosend,
            success: function (html1) {

                $('#imp_fee_numbers_list').html(html1);
				number = $('#imp_fee_numbers_list li input[type=checkbox]:checked').length;
				if(number > 0){
				$('#dLabel').html('Выбрано '+number+' номера');}	else{
		$('#dLabel').html('Выберите добавленные номера');
		}
            }
        })
    }

    function load_free_numbers2() {

        datatosend = {



            _token: $('[name=_token]').val(),
        }


        $.ajax({
            type: "POST",
            url: '/ajax/load_free_numbers',
            data: datatosend,
            success: function (html1) {

                $('#imp_fee_numbers_list').html(html1);
				number = $('#imp_fee_numbers_list li input[type=checkbox]:checked').length;
				if(number > 0){
				$('#dLabel').html('Выбрано '+number+' номера');}	else{
		$('#dLabel').html('Выберите добавленные номера');
		}
            }
        })
    }


/*
    $('#type-calltrecing-cont .btn-primary').on('click',function(){
        $('#type-calltrecing-cont .btn-primary').removeClass('active');
        $(this).addClass('active');
        $('.ar_tip_calltrack').val( $(this).attr('data-val'));

        $('#setings-add-nomer_val').val($(this).attr('data-id'));alert('1');


    })
*/



    $('#setings-add-nomer .btn-primary').on('click',function(){

        $('#setings-add-nomer .btn-primary').removeClass('active');
        $('#setings-add-nomer-content .tab-content-block').removeClass('active');
        $('#setings-add-nomer-content #'+$(this).attr('data-id')+'').addClass('active');
        $(this).addClass('active');
        $('#setings-add-nomer_val').val($(this).attr('data-id'));

    })

    $(document).on('click','.add_scenarij',function () {
        $.ajax({
            type: "POST",
            url: '/asterisk_ajax/0',
            data: $("#create_routing_form").serialize(),
            success: function (html1) {

                if(html1['error']==0){
                    /*mynotif('Успешно','Изменения успешно сохранены','success');*/ $('#WidgetModal3').modal('hide');
                }

                if(html1['error']==1){
                    mynotif('Ошибка',html1['message'],'danger');
                }


            }
        })

    });
    function myModalBox_add_rout_safe() {






    }
	
	$(document).on('change', '.select4-list', function(){
	val = $('option:selected',this).val()
	sel = $(this).closest('.on_of_nambers').find('.form-control-text');
	sel.inputmask('remove');
	$(this).closest('.on_of_nambers').find('.neiros-sip-show').css('display','none')
	$(this).closest('.on_of_nambers').find('.form__block_sip_neiros').css('display','none')
	if(val === '0'){
		sel.val('')
		sel.attr('placeholder','+7 (___) ___-__-__')
		
		sel.inputmask("+7 (999) 999-99-99", {"placeholder": "+7 (___) ___-__-__"});;
		}
	if(val === '1'){
		sel.attr('placeholder','')
		}
	if(val === '2'){
		sel.attr('placeholder','')
		$(this).closest('.on_of_nambers').find('.neiros-sip-show').css('display','block')
		$(this).closest('.on_of_nambers').find('.form__block_sip_neiros').css('display','block')
		
		
		}		
	
	}) 
	
</script>

@include('modal.myModalBox_add_rout')
