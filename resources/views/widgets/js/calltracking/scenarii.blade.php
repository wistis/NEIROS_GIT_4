<script>function open_myModalBox_add_rout() {


        $("#collapseFour").collapse('hide');
        $("#collapseThree").collapse('hide');
        $("#collapseTwo").collapse('hide');
        $("#collapseOne").collapse('show');
        $('#myModalBox_add_rout').modal('show');
        $('#ar_id').val(0);

        load_free_numbers();
        $('#ar_id').val(0);


        $('#ar_name').val('');

        var radios = $('.ar_reditrect');
        radios.prop('checked', false);;

        radios.filter('[value=0]').prop('checked', true);

        $('#ar_phone_redirect0').val('');
        $('#ar_phone_redirect1').val('');
        $('#ar_phone_redirect2').val('');


        var tip_calltrack = $('.ar_tip_calltrack');
        tip_calltrack.prop('checked', false);;
        tip_calltrack.filter('[value=0]').prop('checked', true);
        load_free_numbers();

    }
    function load_free_numbers() {
        datatosend = {



            _token: $('[name=_token]').val(),
        }
        $.ajax({
            type: "POST",
            url: '/ajax/load_free_numbers',
            data: datatosend,
            success: function (html1) {

                $('#fee_numbers_list').html(html1);

            }
        })
    }
$(document).on('shown.bs.modal', '#WidgetModal3', function () {
$('.accordion-setings',this).css('max-height',$('.modal-dialog',this).height()-120);
$('.accordion-setings',this).css('padding-bottom','0px');
if($('.new-scenariy', this).val() == ''){	
$('.new-scenariy', this).focus()}
})
    function edit_routing(id) {
	var id_n = id;
        datatosend = {
            ids: id,
            _token: $('[name=_token]').val(),
        }
        $.ajax({
            type: "POST",
            url: '/ajax/edit_routing_get',
            data: datatosend,
            success: function (html1) {

                $('.hidenmodal').html(html1);

                $('#WidgetModal3').modal('show');
                load_free_numbers3(id);
                $(".select3-list").select2({
                    placeholder: 'Выберите город'
                })
                $(".select4-list").select2({
                    placeholder: 'Телефон',
                    minimumResultsForSearch: -1
                })

                $(".select5-list").select2({
                    placeholder: 'Все источники',
                    minimumResultsForSearch: -1
                })
                $(".select6-list").select2({
                    placeholder: 'Выберите атрибут',
                    minimumResultsForSearch: -1
                })

                var elems = document.querySelectorAll('.js-switch');

                for (var i = 0; i < elems.length; i++) {
                    var switchery = new Switchery(elems[i], { size: 'small' , color: '#00B9EE'});
                }

	


            }
        })
    }

    $(document).on('click','#type-calltrecing-cont .btn-primary',function(){

        $('#type-calltrecing-cont .btn-primary').removeClass('active');
        $('#type-calltrecing-cont .tab-content-block').removeClass('active');
        $('#type-calltrecing-cont #'+$(this).attr('data-id')+'').addClass('active');
        $(this).addClass('active');

$('.ar_tip_calltrack').val($(this).attr('data-val'));
    })


    function edit_routing_new() {
        datatosend = {
            ids: 0,
            _token: $('[name=_token]').val(),
        }
        $.ajax({
            type: "POST",
            url: '/ajax/edit_routing_get',
            data: datatosend,
            success: function (html1) {

                $('.hidenmodal').html(html1);
                $('#WidgetModal3').modal('show');
                load_free_numbers2()
				$(".select3-list").select2({
placeholder: 'Выберите город'
	})
$(".select4-list").select2({
placeholder: 'Телефон',
  minimumResultsForSearch: -1	
	})	
	
$(".select5-list").select2({
placeholder: 'Все источники',
  minimumResultsForSearch: -1	
	})		
$(".select6-list").select2({
placeholder: 'Выберите атрибут',
  minimumResultsForSearch: -1	
	})	
				
	var elems = document.querySelectorAll('.js-switch');

for (var i = 0; i < elems.length; i++) {
  var switchery = new Switchery(elems[i], { size: 'small' , color: '#00B9EE'});
}



			
            }
        })
    }
    
    
    
    
    
    </script>
<script>
    function selecttipcall(idf) {
        if(idf==1){
            $('.mymetki').hide();
            $('.mymetki_dinamic').show();

        }
        if(idf==2){
            $('.mymetki').show();
            $('.mymetki_dinamic').hide();

        }
    }

    var ar_name;
    var ar_number = [];
    var ar_reditrect;
    var ar_phone_redirect;
    var ar_tip_calltrack;
    var ar_id;

    function select_tip_redirect(id) {
        $('#block_0').hide();
        $('#block_1').hide();
        $('#block_2').hide();
        $('#block_' + id).show();


    }

    function show_error(text) {

        mynotif('Ошибка',text,'error');

    }

    $(".btn1").click(function () {
        ar_name = $('#ar_name').val();
        ar_id=$('#ar_id').val();
        if (ar_name.length == '') {
            show_error('Введите название Сценария');
            return false;

        }

        $("#collapseTwo").collapse('show');
        $("#collapseOne").collapse('hide');
    });
    $(".btn-1").click(function () {
        $("#collapseTwo").collapse('hide');
        $("#collapseOne").collapse('show');
    });


    $(".btn2").click(function () {

        i = 0;
        $('.ar_number:checked').each(function () {
            ar_number.push($(this).val());
            i++;
        });
        if(ar_id==0) {
            if (i == 0) {
                show_error('Выберите хотябы 1 номер');
                return false;

            }
        }

        $("#collapseThree").collapse('show');
        $("#collapseTwo").collapse('hide');
    });
    $(".btn-2").click(function () {
        $("#collapseThree").collapse('hide');
        $("#collapseTwo").collapse('show');
    });
    $(".btn3").click(function () {
        ar_reditrect = $('.ar_reditrect:checked').val();
        ar_phone_redirect = $('#ar_phone_redirect' + ar_reditrect).val();
        if (ar_phone_redirect == '') {
            if (ar_reditrect == 0) {
                text = 'Введите номер телефона';
            }
            if (ar_reditrect == 1) {
                text = 'Введите SIP';
            }
            if (ar_reditrect == 2) {
                text = 'Введите пароль';
            }

            show_error(text);
            return false;

        }


        if (ar_reditrect == 2) {
            if (ar_phone_redirect.length < 8) {
                show_error('Пароль должен быть минимум 8 знаков');
                return false;
            }
        }


        $("#collapseFour").collapse('show');
        $("#collapseThree").collapse('hide');
    });
    $(".btn-3").click(function () {
        $("#collapseFour").collapse('hide');
        $("#collapseThree").collapse('show');
    });





    function delete_routing(ids) {
        mynotif('Успешно','Изменения приняты успешно','success');

        $('#idsr' + ids).hide();
        datatosend = {



            ids: ids,
            _token: $('[name=_token]').val(),
        }
        $.ajax({
            type: "POST",
            url: '/ajax/delete_routiing_calltrack',
            data: datatosend,
            success: function (html1) {


            }
        })
    }

</script>