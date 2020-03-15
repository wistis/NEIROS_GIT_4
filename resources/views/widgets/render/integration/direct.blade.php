<style>.ClientInfoModal.modal.fade:not(.in) .modal-dialog {
        -webkit-transform: translate3d(25%, 0, 0);
        transform: translate3d(25%, 0, 0);

    }</style>


<div class="col-md-3 integration-item">
    <div class="single-cases-card" >
        <div class="card-image"><a data-toggle="modal" data-target="#myModal_sett_2"><img alt="" src="/global_assets/images/integration/direct.jpg" draggable="false" class="img-responsive" ></a>
            <div class="hover-area"> </div>
        </div>
        <!-- .card-image END -->

        <div class="cases-content col-xs-12">

            <span class="col-xs-12 text-center"> {!! $status_checkbox_metrika_modal !!}</span>

        <!-- .cases-content END --></div>


</div>
</div>

<div id="myModal_sett_2" class="modal fade ClientInfoModal lids-neiros integration___modal WidgetModal">
    <div class="modal-dialog" style="">
        <div class="modal-content"   style="height: 100vh">
            <!-- Заголовок модального окна -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
           <?php /*?>     <h4 class="modal-title">Яндекс Директ</h4><?php */?>
            </div>
            <!-- Основное содержимое модального окна -->
            <div class="modal-body">
            
            <div class="name-block-fixed name-block-fixed-integration">
           <div class="col-xs-12" >
           <div class="h1-modal pos-left"><img src="/images/yandex-direct.jpg"><span></span></div>
           
                <input type="hidden" class="form-control" name="id"
                       value="{{$widget_vk->id}}">
                <input type="hidden" class="form-control" name="form_action"
                       value="integrationdirect">{!! $status_checkbox_metrika !!}
           </div>
            </div>
            
            
    <div class="row">
        <form id="integrationdirect" name="integrationdirect">
       
         <div class="col-xs-12 block-descr">  
          <div class="col-sm-6"><div class="img-block-left"><img width="100%" src="/global_assets/images/integration/direct.jpg"></div></div>
          <div class="col-sm-6">  
          	<div class="paragraph">Яндекс.Директ — рекламная система, с помощью которой вы 
можете размещать контекстные объявления на страницах 
Яндекс.Поиска и на партнёрских сайтах Рекламной сети. 
Объявления в Директе показываются исключительно тем 
людям, которые уже заняты поиском похожих услуг и товаров 
на Яндексе и других сайтах.</div>
          
          
          <input type="hidden" class="form-control" name="id"
                       value="{{$widget_vk->id}}">
                <input type="hidden" class="form-control" name="form_action"
                       value="integrationdirect">{!! $status_checkbox_metrika !!}
             
                
                </div>
                
            </div> 
            
        <div class="show-hidden-integration">       
        <div class="col-xs-12">

              


                    <div class="form-group">
                        <label class="col-xs-12 control-label">E-mail:</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="email" id="email"  value="{{$widget_vk->email}}" required>
                            <input type="text" class="form-control" name="token" id="token"
                                   value="{{$widget_vk->token}}" required>
                            <a href="/set_token_direct/{{$widget_vk->id}}">Получить токен
                            </a>
                        </div>

                    </div>


              
        </div>
        
   
        {{--Дополнительные поля--}}
        <div class="col-xs-12">
            <div class="form-group">
                <label class="col-xs-12 control-label">Рекламные компании:</label>
                <div class="col-xs-12"><div><input type="checkbox" name="mft" id="mft"   value="1"> Отметить все
                    </div>
                    @foreach($counters as $counter)

                        <div><input type="checkbox" name="radiocounter[]"  class="dircheck" @if($counter->status==1) checked="checked"
                                    @endif value="{{$counter->id}}"> {{$counter->company}} ({{$counter->name}})
                        </div>
                    @endforeach

                </div>

            </div>


        </div>
            <div class="col-xs-12">
                <div class="form-group">
                    <label class="col-xs-12 control-label">Метка Neiros:</label>
                    <div class="col-xs-12"><div><input type="checkbox" name="update_utm"     value="1"> Разметить меткой


                    </div>

                </div>


            </div>
            </div>

        <div class="form-group footer-button">
            <div class="col-xs-12">
            	
                <button type="button" class="btn btn-primary w_safebutton ">Сохранить</button>
                <button type="button" class="btn btn-default " data-dismiss="modal" aria-hidden="true">Закрыть</button>
            </div>

        </div>
        </div>
        
        </form>


    </div>
            </div>
            <!-- Футер модального окна -->
			
        </div>
    </div>
</div>
<script>
    $("#mft").click( function() {
        if($("#mft").prop('checked')){
            $('.dircheck').prop('checked', true);
        } else {
            $('.dircheck').prop('checked', false);
        }
    });
</script>