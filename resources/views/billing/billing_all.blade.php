@extends('app')
@section('title')
    Этапы сделок

@endsection
<script type="text/javascript" src="/global_assets/js/plugins/forms/styling/switchery.min.js"></script>
<link href="/cdn/v1/chatv2/css/select2.css" rel="stylesheet" type="text/css">

<style>.user-setting{
	    background: none !important;
	    box-shadow: none !important;
	}
  .user-setting .nav-tabs > li.active > a, .user-setting .nav-tabs > li.active > a:focus, .user-setting .nav-tabs > li.active > a:hover{
	  
	  background: none !important;
    color: #333 !important;
	  }  
   .user-setting .nav > li > a{ color: #333 !important;} 
   
   .user-setting .nav-tabs{    border-bottom: 1px solid #B3B3B3 !important;}
   .tab-content > .active.tab_pane__new{    background: #fff;
    border-radius: 5px;
    margin-top: 40px;}
	.tab_pane__new2 .panel-heading{    padding-top: 30px !important;
    padding-bottom: 30px !important; }</style>

@section('content')

    <input name="_token" type="hidden" value="{{ csrf_token() }}" />
    <!-- Task manager table -->
    <div class="panel panel-white user-setting" >



        <div class="dropdown add-user-new">


        </div>


        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
        	 
             <li role="presentation" class="active" style="    margin-right: 35px;" ><a href="#s-balance" aria-controls="s-balance" role="tab" data-toggle="tab">Тарифы и баланс</a></li>   
        		
            <li role="presentation" ><a href="#profil" aria-controls="profil" role="tab" data-toggle="tab">Платежные профили</a></li>
            <li role="presentation" style="    margin-left: 35px;"><a href="#schet" aria-controls="schet" role="tab" data-toggle="tab">Счета на оплату</a></li>
            <li role="presentation" style="    margin-left: 35px;"><a href="#number" aria-controls="number" role="tab" data-toggle="tab">Стоимость номеров</a></li>
            <li role="presentation" style="    margin-left: 35px;"><a href="#talk" aria-controls="talk" role="tab" data-toggle="tab">Стоимость разговоров</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
@include('billing.tabs.ballance')
        
        
            <div role="tabpanel" class="tab-pane tab_pane__new tab_pane__new2 fade " id="profil">

{!! $paycompanys !!}


            </div>
            <div role="tabpanel" class="tab-pane tab_pane__new fade" id="schet"> {!! $checkcompanys !!} </div>
            <div role="tabpanel" class="tab-pane tab_pane__new fade " id="talk"> {!! $recs !!}</div>

            <div role="tabpanel" class="tab-pane tab_pane__new fade" id="number">{!! $phones !!}</div>


			 















    <!-- /task manager table -->

    <!-- /footer -->

    <div id="ClientInfoModal" class="modal fade ClientInfoModal lids-neiros user-neiros">

    </div>
    </div>





    <script type="text/javascript" src="/js/select2.min.js"></script>
    <script>

        /* ------------------------------------------------------------------------------
        *
        *  # Select2 selects
        *
        *  Demo JS code for form_select2.html page
        *
        * ---------------------------------------------------------------------------- */

        document.addEventListener('DOMContentLoaded', function() {
            // Format icon
            function iconFormat(icon) {
                var originalOption = icon.element;
                if (!icon.id) { return icon.text; }
                /* var $icon = "<i class='icon-" + $(icon.element).data('icon') + "'></i>" + icon.text;*/
                var $icon = "<div class='selected-icons-select2'><img  src='/global_assets/images/icon/user/user.svg'></div><div class='selected-icons-select2-text'>"+ icon.text+"</div>";
                return $icon;
            }

            // Initialize with options

            function reload_select(){

                select3 = $(".select-icons").select2({
                    templateResult: iconFormat,
                    hideSelected: true,
                    minimumResultsForSearch: Infinity,
                    closeOnSelect: false,
                    templateSelection: iconFormat,
                    escapeMarkup: function(m) { return m; }
                });
                select3.each(function( index ) {
                    $(this).data('select2').$dropdown.addClass("selection-user-drop");
                });

                $('.select-conainer-icon-multi .select2-search__field').attr('placeholder', '+ Добавить пользователя');
                $('.select-conainer-icon-roll .select2-search__field').attr('placeholder', '+ Добавить Роль');
                $('.select-conainer-icon-group2 .select2-search__field').attr('placeholder', '+ Добавить Группу');

                $('.select-group-user').on('select2:unselect', function (e) {
                    $('.select-conainer-group-multi .select2-search__field').attr('placeholder', '+ Добавить пользователя');

                    set_user_group($(this).val(),$(this).closest('tr').attr('data-id'))



                });

                $('.select-group-user').on('select2:select', function (e) {
                    set_user_group($(this).val(),$(this).closest('tr').attr('data-id'));

                    $('.select-conainer-group-multi .select2-search__field').attr('placeholder', '+ Добавить пользователя');
                });


                $('.select-roll-user').on('select2:unselect', function (e) {
                    $('.select-conainer-icon-roll .select2-search__field').attr('placeholder', '+ Добавить Роль');
                });

                $('.select-roll-user').on('select2:select', function (e) {
                    $('.select-conainer-icon-roll .select2-search__field').attr('placeholder', '+ Добавить Роль');
                });


                $('.select-group2-user').on('select2:unselect', function (e) {
                    $('.select-conainer-icon-group2 .select2-search__field').attr('placeholder', '+ Добавить Группу');
                });

                $('.select-group2-user').on('select2:select', function (e) {
                    $('.select-conainer-icon-group2 .select2-search__field').attr('placeholder', '+ Добавить Группу');
                });

            }

            reload_select()




            function set_user_group(user,group) {
                $.ajax({
                    type: "POST",
                    url: '/setting/users/set_user_group',
                    data: {
                        user: user,
                        group: group
                    },
                    success: function (html1) {

                        $('.group_count_' + group).html(html1);


                    }
                })
            }
            $('.add-group-text div').on('click',function(){
                $(this).css('display','none');
                $('.cont-create-group').css('display','block');

            })
            var select2 =  $('.js-example-basic-single').select2({
                placeholder: '<img src="/global_assets/images/icon/user/plus.PNG"> Добавить пользователя',
                /*  	minimumResultsForSearch: -1,*/
                escapeMarkup : function(markup) { return markup; }
            });
            select2.each(function( index ) {
                $(this).data('select2').$dropdown.addClass("selection-user-drop");
            });


            $('.user-rolls').select2({
                minimumResultsForSearch: -1

            })


            $(document).on('click','.edit-user',function(){

                $.ajax({
                    type: "POST",
                    url: '/setting/users/getajaxuser',
                    data: {
                        id:$(this).data('id')
                    },
                    success: function (html1) {

                        $('#ClientInfoModal').html(html1);
                        $('#ClientInfoModal').modal('show');
                        $('.user-rolls').select2({
                            minimumResultsForSearch: -1

                        })
                        reload_select()
                    }
                })


            });
            $(document).on('click','.add_user_ajax',function(){

                $.ajax({
                    type: "POST",
                    url: '/setting/users/getnewuser',
                    data: {
                        id:'',

                    },
                    success: function (html1) {

                        $('#ClientInfoModal').html(html1);
                        $('#ClientInfoModal').modal('show');
                        $('.user-rolls').select2({
                            minimumResultsForSearch: -1

                        })
                        reload_select()


                    }
                })


            });





            $(document).on('click','.w_safebutton_new',function () {
                var my_form=$('#form_user_save').serialize();
                var formData = new FormData($('#form_user_save')[0])
                $.ajax({
                    type: "POST",
                    url: '/setting/users/saveajaxuser',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (html1) {
                        if(html1['is_new']==1){

                            $('#user_tbody').append(html1['html'])
                        }
                        if(html1['status']==2){
                            mynotif('Успешно', html1['message'], 'info')
                            $('#ClientInfoModal').modal('hide');
                            return;
                        }
                        if(html1['status']==0){
                            mynotif('Ошибка',html1['message'], 'danger')
                            $('#ClientInfoModal').modal('hide');
                            return;
                        }
                        if(html1['status']==1){
                            mynotif('Ошибка',html1['message'], 'danger')
                            ;
                            return;
                        }
                    }
                })

            });

            $(document).on('click','.add_group',function () {

                $('.cont-create-group').hide();
                $.ajax({
                    type: "POST",
                    url: '/setting/usersgroup/saveajaxgroup',
                    data: {
                        name:$('#my_group_name').val()
                    },
                    success: function (html1) {
                        $('#my_group_name').val('');
                        $('#user_group_tr').append(html1);
                    }
                })

            });


            /*$(document.body).on("change",".js-example-basic-single",function(){
            $(".js-example-basic-single").val('').trigger('change')
            });*/

            $('.js-example-basic-single').on('select2:select', function (e) {
                count = $(this).closest('tr').find('.user-group span').html()
                $(this).closest('tr').find('.user-group span').html(Number(count)+1)
                $(this).closest('tr').find('.count-user').html(Number(count)+1)
                $(".js-example-basic-single").val('').trigger('change')
            });

            var elems = document.querySelectorAll('.js-switch');

            for (var i = 0; i < elems.length; i++) {
                var switchery = new Switchery(elems[i], { size: 'small' , color: '#00B9EE'});
            }


        });
    </script>

	
    
    <script>


        $(document).on('click', '.s-balance-tarif-btn', function () {
            $('.s-balance-tarif-block').removeClass('active-tarif');
            $(this).parent().addClass('active-tarif');


var thisd=$(this);

            $('.m3_p').html(thisd.data('montsh3')+'% скидка')
            $('.m3_s').html(thisd.data('m3')+' руб.')


            $('.m6_p').html(thisd.data('month6')+'% скидка')
            $('.m6_s').html(thisd.data('m6')+' руб.')

            $
            $('.m12_p').html(thisd.data('month12')+'% скидка')
            $('.m12_s').html(thisd.data('m12')+' руб.')


            $('.m24_p').html(thisd.data('month24')+'% скидка')
            $('.m24_s').html(thisd.data('m24')+' руб.')

$('#new_tarif').val(thisd.data('id'));
            var formdata=$('#ballance_form').serialize();
            $.ajax({
                type: "POST",
                url: '/ajax/set_terif',
                data:formdata,
                success: function (html1) {




                }
            })



        });


/*var elems = document.querySelectorAll('.js-switch');
		for (var i = 0; i < elems.length; i++) {
		var switchery = new Switchery(elems[i], { size: 'small' , color: '#00B9EE'});
		}*/
   
 $('.checkbox-pay input[type="checkbox"]').on('change', function() {
   $('.checkbox-pay input[type="checkbox"]').not(this).prop('checked', false);
});  
   
 $('.s-balance-active-coupon label').click(function() {
   $('.s-balance-active-coupon-block').toggle();
}); 

 $('.s-balance-active-avto .s-balance-active-avto-str').click(function() {
   $('.s-balance-avto-block-st').toggle();
}); 



    var count = 1;
    var countElement = document.getElementById("count-project");
    function plus(){
        count++;
        countElement.value = count;
        load_tarif();
    }
    function minus(){
      if (count > 1) {
        count--;
        countElement.value = count;
          load_tarif();
      }  
    }
   
  
 
 
min_slide = 0;
max_slide = 13000;
default_value = {{$pos}};
count_slider = 50;
$('.min_value').text(min_slide)
$('.max_value').text(max_slide)


	$( function() {
		var handle = $( "#custom-handle" );
		$( "#slider" ).slider(
		{
		range: "max",
		min: min_slide, 
		max: max_slide,
	  value: default_value,
      orientation: "horizontal",
      range: "min",
      animate: true,
 
			create: function() {
				handle.html('<div><span>'+$(this).slider( "value" )+'</span></div>' );
			},
			slide: function( event, ui ) {
				handle.html('<div><span>'+ ui.value+'</span></div>' );
				$("#count-user-in-site").val(ui.value);
			}
            ,
            change: function( event, ui ) {
                load_tarif()
            }
		});
	} );
function load_tarif() {
var traff_1=$('#count-user-in-site').val();
var site_1=$('#count-project').val();
    $.ajax({
        type: "POST",
        url: '/ajax/load_tarif',
        data: {
            'traffic':traff_1,
            'sites':site_1,

        } ,
        success: function (html1) {
$('.s-balance-tarif').html(html1);

        }
    })

}
load_tarif()
 </script>   
    

@endsection
